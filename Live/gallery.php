<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include "db_connect.php";

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Add caching headers
header('Cache-Control: public, max-age=31536000');
header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 31536000) . ' GMT');

// Cache event types for better performance
$eventTypesQuery = "SELECT DISTINCT event_name FROM event_gallery ORDER BY event_name";
$eventTypesResult = $conn->query($eventTypesQuery);

if (!$eventTypesResult) {
    die("Query failed: " . $conn->error);
}

$eventTypes = [];
while ($row = $eventTypesResult->fetch_assoc()) {
    $eventTypes[] = $row['event_name'];
}

$selectedCategory = isset($_GET['category']) ? $_GET['category'] : 'All';

// Pagination implementation
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$imagesPerPage = 12;
$offset = ($page - 1) * $imagesPerPage;

// Get total count for pagination
if ($selectedCategory && $selectedCategory != 'All') {
    $countQuery = "SELECT COUNT(*) as total FROM event_gallery WHERE event_name = ?";
    $stmt = $conn->prepare($countQuery);
    $stmt->bind_param("s", $selectedCategory);
} else {
    $countQuery = "SELECT COUNT(*) as total FROM event_gallery";
    $stmt = $conn->prepare($countQuery);
}
$stmt->execute();
$totalCount = $stmt->get_result()->fetch_assoc()['total'];
$totalPages = ceil($totalCount / $imagesPerPage);

// Fetch images with pagination
if ($selectedCategory && $selectedCategory != 'All') {
    $query = "SELECT id, event_name, filename, file_data, uploaded_at 
              FROM event_gallery 
              WHERE event_name = ? 
              ORDER BY uploaded_at DESC
              LIMIT ? OFFSET ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sii", $selectedCategory, $imagesPerPage, $offset);
} else {
    $query = "SELECT id, event_name, filename, file_data, uploaded_at 
              FROM event_gallery 
              ORDER BY uploaded_at DESC
              LIMIT ? OFFSET ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $imagesPerPage, $offset);
}

$stmt->execute();
$result = $stmt->get_result();

$images = [];
$imagesByYear = [];
while ($row = $result->fetch_assoc()) {
    $year = date('Y', strtotime($row['uploaded_at']));
    $imagesByYear[$year][] = $row;
}
krsort($imagesByYear);

$stmt->close();
$conn->close();

// Handle AJAX requests for infinite scroll
if (isset($_GET['ajax']) && $_GET['ajax'] === 'true') {
    foreach ($imagesByYear as $year => $yearImages) {
        foreach ($yearImages as $image) {
            include 'gallery-item.php';
        }
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery - Pithwa Charitable Trust</title>
    

    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js" as="script">
    <link rel="stylesheet" href="./assets/css/index.css">
    
    <style>
        :root {
            --primary: #3c2a98;
            --secondary: #ff6b6b;
            --background: #f8f9fa;
            --text: #2c3e50;
            --white: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Your existing CSS styles remain the same */
        body {
            background: var(--background);
            color: var(--text);
            line-height: 1.6;
        }


        .nav-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .gallery-header {
            padding: 8rem 8rem;
            background: linear-gradient(45deg, var(--primary), var(--secondary));
            color: var(--white);
            text-align: center;
        }

        .gallery-categories {
            display: flex;
            justify-content: center;
            gap: 1rem;
            padding: 2rem;
            flex-wrap: wrap;
        }

        .category-btn {
            padding: 0.5rem 1.5rem;
            border: none;
            border-radius: 25px;
            background: var(--white);
            color: var(--primary);
            cursor: pointer;
            transition: 0.3s;
            font-weight: 500;
            text-decoration: none;
        }

        .category-btn.active {
            background: var(--primary);
            color: var(--white);
        }

        .gallery-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
        }

        .gallery-item {
            position: relative;
            border-radius: 15px;
            overflow: hidden;
            aspect-ratio: 1;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: 0.3s;
        }

        .gallery-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: 0.5s transform;
        }

        .gallery-item:hover img {
            transform: scale(1.1);
        }

        .gallery-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(transparent, rgba(0, 0, 0, 0.8));
            color: white;
            padding: 1.5rem;
            transform: translateY(100%);
            transition: 0.3s;
        }

        .gallery-item:hover .gallery-overlay {
            transform: translateY(0);
        }

        .year-section {
            margin: 4rem 0;
            text-align: center;
        }

        .year-title {
            display: inline-block;
            padding: 0.5rem 2rem;
            background: linear-gradient(45deg, var(--primary), var(--secondary));
            color: var(--white);
            border-radius: 25px;
            margin-bottom: 2rem;
        }

        @media (max-width: 768px) {
            .gallery-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                gap: 1rem;
            }
        }
        .gallery-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.9);
            z-index: 1001;
            overflow: auto;
        }

        .gallery-modal-content {
            position: relative;
         margin: auto;
            width: 90%;
            max-width: 900px;
            top: 50%;
            transform: translateY(-50%);
        }

        .gallery-modal-image {
            width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.2);
        }

        .gallery-modal-close {
            position: absolute;
            top: -40px;
            right: 0;
            color: white;
            font-size: 30px;
            font-weight: bold;
            cursor: pointer;
            background: none;
            border: none;
            padding: 5px;
        }

        .gallery-modal-details {
            color: white;
            text-align: center;
            margin-top: 20px;
            padding: 15px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
        }

        .gallery-modal-navigation {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 100%;
            display: flex;
            justify-content: space-between;
            padding: 0 20px;
        }

        .gallery-modal-nav-btn {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: none;
            padding: 15px;
            cursor: pointer;
            border-radius: 50%;
            margin: 0 10px;
            z-index: 1002;
        }

        body.modal-open {
            overflow: hidden;
        }
        /* Add pagination styles */
        .pagination {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 2rem;
            padding-bottom: 2rem;
        }

        .pagination a {
            padding: 0.5rem 1rem;
            border-radius: 4px;
            background: var(--white);
            color: var(--primary);
            text-decoration: none;
            transition: 0.3s;
        }

        .pagination a.active {
            background: var(--primary);
            color: var(--white);
        }

        .pagination a:hover {
            background: var(--primary);
            color: var(--white);
        }

        /* Loading indicator styles */
        #loading-indicator {
            text-align: center;
            padding: 2rem;
            display: none;
        }

        .spinner {
            display: inline-block;
            width: 40px;
            height: 40px;
            border: 4px solid var(--background);
            border-top: 4px solid var(--primary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Your existing modal styles remain the same */

    </style>
</head>
<body>
    <?php include "navbar.php"; ?>
    
    <header class="gallery-header">
        <h1>Our Gallery</h1>
        <p>Capturing moments of impact and change</p>
    </header>

    <div class="gallery-categories">
        <a href="?category=All" class="category-btn <?php echo $selectedCategory == 'All' ? 'active' : ''; ?>">All</a>
        <?php foreach ($eventTypes as $eventType): ?>
            <a href="?category=<?php echo urlencode($eventType); ?>"
               class="category-btn <?php echo $selectedCategory == $eventType ? 'active' : ''; ?>">
                <?php echo htmlspecialchars($eventType); ?>
            </a>
        <?php endforeach; ?>
    </div>

    <div class="gallery-container">
        <?php foreach ($imagesByYear as $year => $yearImages): ?>
            <div class="year-section">
                <h2 class="year-title"><?php echo $year; ?></h2>
                <div class="gallery-grid">
                    <?php foreach ($yearImages as $image): ?>
                        <div class="gallery-item" 
                             data-aos="fade-up" 
                             data-id="<?php echo $image['id']; ?>"
                             data-image="data:image/jpeg;base64,<?php echo base64_encode($image['file_data']); ?>"
                             data-title="<?php echo htmlspecialchars($image['event_name']); ?>"
                             data-date="<?php echo date('F j, Y', strtotime($image['uploaded_at'])); ?>">
                            <div class="lazy-container skeleton">
                            <img src="data:image/jpeg;base64,<?php echo base64_encode($image['file_data']); ?>"
     alt="<?php echo htmlspecialchars($image['filename']); ?>">


                            </div>
                            <div class="gallery-overlay">
                                <h3><?php echo htmlspecialchars($image['event_name']); ?></h3>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
        
        <div id="loading-indicator">
            <div class="spinner"></div>
            <p>Loading more images...</p>
        </div>
    </div>

    <!-- Modal Structure -->
    <div id="imageModal" class="gallery-modal">
        <div class="gallery-modal-content">
            <button class="gallery-modal-close" onclick="closeModal()">&times;</button>
            <div class="gallery-modal-navigation">
                <button class="gallery-modal-nav-btn prev-btn" onclick="navigateImage(-1)">&lt;</button>
                <button class="gallery-modal-nav-btn next-btn" onclick="navigateImage(1)">&gt;</button>
            </div>
            <img id="modalImage" class="gallery-modal-image" src="" alt="Gallery Image">
            <div class="gallery-modal-details">
                <h3 id="modalTitle"></h3>
                <p id="modalDate"></p>
            </div>
        </div>
    </div>

    <!-- Your custom script -->
<script src="./assets/js/index.js"></script>
<!-- Load AOS first (at the bottom of the body) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
    // // Now initialize AOS after it has been loaded
    // AOS.init({
    //     duration: 1000,
    //     once: true,
    //     offset: 100
    // });
    //     // Cache control
    //     function cacheImage(src, imageId) {
    //         if (typeof(Storage) !== "undefined") {
    //             try {
    //                 localStorage.setItem('img_' + imageId, src);
    //             } catch (e) {
    //                 console.warn('localStorage is full, clearing old items');
    //                 clearOldCache();
    //             }
    //         }
    //     }

    //     function clearOldCache() {
    //         for (let i = 0; i < localStorage.length; i++) {
    //             let key = localStorage.key(i);
    //             if (key.startsWith('img_')) {
    //                 localStorage.removeItem(key);
    //                 break;
    //             }
    //         }
    //     }

    //     // Lazy loading implementation
    //     document.addEventListener("DOMContentLoaded", function() {
    //         const lazyImages = document.querySelectorAll("img.lazy");
            
    //         const imageObserver = new IntersectionObserver((entries, observer) => {
    //             entries.forEach(entry => {
    //                 if (entry.isIntersecting) {
    //                     const img = entry.target;
    //                     const imageId = img.closest('.gallery-item').dataset.id;
                        
    //                     const cachedSrc = localStorage.getItem('img_' + imageId);
    //                     if (cachedSrc) {
    //                         img.src = cachedSrc;
    //                     } else {
    //                         img.src = img.dataset.src;
    //                         cacheImage(img.dataset.src, imageId);
    //                     }
                        
    //                     img.classList.remove("lazy");
    //                     img.parentElement.classList.remove("skeleton");
    //                     observer.unobserve(img);
    //                 }
    //             });
    //         });

    //         lazyImages.forEach(img => {
    //             imageObserver.observe(img);
    //             img.onerror = function() {
    //                 this.src = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
    //                 this.parentElement.classList.remove("skeleton");
    //             };
    //         });
    //     });

    //     // Modal handling
    //     let currentImageIndex = 0;
    //     const galleryItems = document.querySelectorAll('.gallery-item');

    //     galleryItems.forEach((item, index) => {
    //         item.addEventListener('click', () => openModal(index));
    //     });

    //     function openModal(index) {
    //         const modal = document.getElementById('imageModal');
    //         const modalImg = document.getElementById('modalImage');
    //         const modalTitle = document.getElementById('modalTitle');
    //         const modalDate = document.getElementById('modalDate');
            
    //         if (!modal || !modalImg || !modalTitle || !modalDate) {
    //             console.error('Modal elements not found');
    //             return;
    //         }

    //         currentImageIndex = index;
    //         const currentItem = galleryItems[currentImageIndex];

    //         modalImg.src = currentItem.getAttribute('data-image');
    //         modalTitle.textContent = currentItem.getAttribute('data-title');
    //         modalDate.textContent = currentItem.getAttribute('data-date');

    //         modal.style.display = "block";
    //         document.body.classList.add('modal-open');
    //     }

    //     function closeModal() {
    //         const modal = document.getElementById('imageModal');
    //         if (modal) {
    //             modal.style.display = "none";
    //             document.body.classList.remove('modal-open');
    //         }
    //     }

    //     function navigateImage(direction) {
    //         currentImageIndex += direction;
    //         if (currentImageIndex >= galleryItems.length) {
    //             currentImageIndex = 0;
    //         } else if (currentImageIndex < 0) {
    //             currentImageIndex = galleryItems.length - 1;
    //         }

    //         const newItem = galleryItems[currentImageIndex];
    //         const modalImg = document.getElementById('modalImage');
    //         const modalTitle = document.getElementById('modalTitle');
    //         const modalDate = document.getElementById('modalDate');

    //         if (modalImg && modalTitle && modalDate) {
    //             modalImg.src = newItem.getAttribute('data-image');
    //             modalTitle.textContent = newItem.getAttribute('data-title');
    //             modalDate.textContent = newItem.getAttribute('data-date');
    //         }
    //     }

    //     // Infinite scroll implementation
    //     let loading = false;
    //     let page = <?php echo $page; ?>;
    //     const totalPages = <?php echo $totalPages; ?>;
    //     const currentCategory = '<?php echo $selectedCategory; ?>';

    //     window.addEventListener('scroll', () => {
    //         if (loading || page >= totalPages) return;
            
    //         if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 1000) {
    //             loading = true;
    //             document.getElementById('loading-indicator').style.display = 'block';
                
    //             page++;
                
    //             fetch(`?page=${page}&category=${currentCategory}&ajax=true`)
    //                 .then(response => response.text())
    //                 .then(html => {
    //                     const parser = new DOMParser();
    //                     const doc = parser.parseFromString(html, 'text/html');
    //                     const newItems = doc.querySelectorAll('.gallery-item');
                        
    //                     const container = document.querySelector('.gallery-grid');
    //                     newItems.forEach(item => {
    //                         container.appendChild(item);
    //                         const img = item.querySelector('img.lazy');
    //                         if (img) {
    //                             imageObserver.observe(img);
    //                         }
    //                     });
                        
    //                     loading = false;
    //                     document.getElementById('loading-indicator').style.display = 'none';
    //                 });
    //         }
    //     });

    //     // Modal event listeners
    //     document.getElementById('imageModal').addEventListener('click', function(e) {
    //         if (e.target === this) {
    //             closeModal();
    //         }
    //     });

    //     // Keyboard navigation
    //     document.addEventListener('keydown', function(e) {
    //         const modal = document.getElementById('imageModal');
    //         if (modal && modal.style.display === "block") {
    //             if (e.key === "Escape") {
    //                 closeModal();
    //             } else if (e.key === "ArrowRight") {
    //                 navigateImage(1);
    //             } else if (e.key === "ArrowLeft") {
    //                 navigateImage(-1);
    //             }
    //         }
    //     });

    //     // Initialize AOS
      

    // Initialize variables
let currentImageIndex = 0;
const galleryItems = document.querySelectorAll('.gallery-item');
const spinner = document.getElementById('loadingSpinner'); // Get the spinner

// Track the number of images that are fully loaded
let imagesLoaded = 0;
const totalImages = galleryItems.length;

// Add event listener for each image to hide spinner once all are loaded
galleryItems.forEach(item => {
    const img = item.querySelector('img');
    
    img.onload = function() {
        imagesLoaded++;
        // If all images are loaded, hide the spinner
        if (imagesLoaded === totalImages) {
            spinner.style.display = 'none'; // Hide spinner
        }
    };

    img.onerror = function() {
        // Handle image load error (if necessary)
        imagesLoaded++;
        if (imagesLoaded === totalImages) {
            spinner.style.display = 'none';
        }
    };
});

// Add click event listeners to all gallery items
galleryItems.forEach((item, index) => {
    item.addEventListener('click', () => openModal(index));
});

function openModal(index) {
    const modal = document.getElementById('imageModal');
    const modalImg = document.getElementById('modalImage');
    const modalTitle = document.getElementById('modalTitle');
    const modalDate = document.getElementById('modalDate');
    
    // Make sure all elements exist before proceeding
    if (!modal || !modalImg || !modalTitle || !modalDate) {
        console.error('Modal elements not found');
        return;
    }

    currentImageIndex = index;
    const currentItem = galleryItems[currentImageIndex];

    modalImg.src = currentItem.getAttribute('data-image');
    modalTitle.textContent = currentItem.getAttribute('data-title');
    modalDate.textContent = currentItem.getAttribute('data-date');

    modal.style.display = "block";
    document.body.classList.add('modal-open');
}

function closeModal() {
    const modal = document.getElementById('imageModal');
    if (modal) {
        modal.style.display = "none";
        document.body.classList.remove('modal-open');
    }
}

function navigateImage(direction) {
    currentImageIndex += direction;

    if (currentImageIndex >= galleryItems.length) {
        currentImageIndex = 0;
    } else if (currentImageIndex < 0) {
        currentImageIndex = galleryItems.length - 1;
    }

    const newItem = galleryItems[currentImageIndex];
    const modalImg = document.getElementById('modalImage');
    const modalTitle = document.getElementById('modalTitle');
    const modalDate = document.getElementById('modalDate');

    if (modalImg && modalTitle && modalDate) {
        modalImg.src = newItem.getAttribute('data-image');
        modalTitle.textContent = newItem.getAttribute('data-title');
        modalDate.textContent = newItem.getAttribute('data-date');
    }
}

// Close modal when clicking outside the image
document.getElementById('imageModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});

// Keyboard navigation
document.addEventListener('keydown', function(e) {
    const modal = document.getElementById('imageModal');
    if (modal && modal.style.display === "block") {
        if (e.key === "Escape") {
            closeModal();
        } else if (e.key === "ArrowRight") {
            navigateImage(1);
        } else if (e.key === "ArrowLeft") {
            navigateImage(-1);
        }
    }
});

// Initialize AOS
AOS.init({
    duration: 1000,
    once: true,
    offset: 100
});

    </script>
</body>
</html>