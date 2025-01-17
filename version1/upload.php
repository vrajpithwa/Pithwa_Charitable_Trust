<?php
// Database configuration
$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'pct';

// Create database connection
$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);



// Prepare the query to fetch all files
$sql = "SELECT id, filename, file_data FROM event_gallery";

try {
    $conn = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUsername, $dbPassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Fetch distinct event names
    $eventTypesQuery = "SELECT DISTINCT event_name FROM event_gallery ORDER BY event_name";
    $eventTypes = $conn->query($eventTypesQuery)->fetchAll(PDO::FETCH_COLUMN);
    
    $selectedCategory = isset($_GET['category']) ? $_GET['category'] : 'All';
    
    // Fetch images with base64 data
    if ($selectedCategory && $selectedCategory != 'All') {
        $query = "SELECT id, event_name, filename, TO_BASE64(file_data) as image_data, uploaded_at 
                 FROM event_gallery 
                 WHERE event_name = :category 
                 ORDER BY uploaded_at DESC";
        $stmt = $conn->prepare($query);
        $stmt->execute(['category' => $selectedCategory]);
    } else {
        $query = "SELECT id, event_name, filename, TO_BASE64(file_data) as image_data, uploaded_at 
                 FROM event_gallery 
                 ORDER BY uploaded_at DESC";
        $stmt = $conn->prepare($query);
        $stmt->execute();
    }
    
    $images = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Group images by year
    $imagesByYear = [];
    foreach ($images as $image) {
        $year = date('Y', strtotime($image['uploaded_at']));
        $imagesByYear[$year][] = $image;
    }
    krsort($imagesByYear);
    
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery - Pithwa Charitable Trust</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
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

        body {
            background: var(--background);
            color: var(--text);
            line-height: 1.6;
        }

        .nav {
            position: fixed;
            top: 0;
            width: 100%;
            background: var(--white);
            padding: 1rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            z-index: 1000;
        }

        .nav-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .logo {
            color: var(--primary);
            text-decoration: none;
            font-size: 1.5rem;
            font-weight: bold;
        }

        .gallery-header {
            margin-top: 80px;
            padding: 4rem 2rem;
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
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: 0.3s;
        }

        .gallery-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
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
            background: linear-gradient(transparent, rgba(0,0,0,0.8));
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

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.9);
            z-index: 1001;
            overflow: auto;
            animation: modalFade 0.3s ease-in-out;
        }

        @keyframes modalFade {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .modal-content {
            position: relative;
            margin: auto;
            padding: 20px;
            width: 90%;
            max-width: 900px;
            top: 50%;
            transform: translateY(-50%);
        }

        .modal-image {
            width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.2);
        }

        .modal-close {
            position: absolute;
            top: -40px;
            right: 0;
            color: var(--white);
            font-size: 30px;
            font-weight: bold;
            cursor: pointer;
            background: none;
            border: none;
            padding: 5px;
            z-index: 1002;
        }

        .modal-details {
            color: var(--white);
            text-align: center;
            margin-top: 20px;
            padding: 15px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            backdrop-filter: blur(10px);
        }

        .modal-details h3 {
            margin-bottom: 10px;
            font-size: 1.5rem;
        }

        .modal-navigation {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 100%;
            display: flex;
            justify-content: space-between;
            padding: 0 20px;
        }

        .modal-nav-btn {
            margin-left: -56px;
            margin-right: -16px;
            background: rgba(255, 255, 255, 0.2);
            color: var(--white);
            border: none;
            padding: 15px;
            cursor: pointer;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: 0.3s;
        }

        .modal-nav-btn:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        body.modal-open {
            overflow: hidden;
        }
    </style>
</head>
<body>
    <nav class="nav">
        <div class="nav-content">
            <a href="index.html" class="logo">Pithwa Charitable Trust</a>
        </div>
    </nav>

    <header class="gallery-header">
        <h1>Our Gallery</h1>
        <p>Capturing moments of impact and change</p>
    </header>

    <div class="gallery-categories">
        <a href="?category=All" class="category-btn <?php echo $selectedCategory == 'All' ? 'active' : ''; ?>">All</a>
        <?php foreach($eventTypes as $eventType): ?>
            <a href="?category=<?php echo urlencode($eventType); ?>" 
               class="category-btn <?php echo $selectedCategory == $eventType ? 'active' : ''; ?>">
                <?php echo htmlspecialchars($eventType); ?>
            </a>
        <?php endforeach; ?>
    </div>

    <div class="gallery-container">
        <?php foreach($imagesByYear as $year => $yearImages): ?>
            <div class="year-section">
                <h2 class="year-title"><?php echo $year; ?></h2>
                <div class="gallery-grid">
                    <?php foreach($yearImages as $image): ?>
                        <div class="gallery-item" 
                             data-aos="fade-up" 
                             onclick="openModal('<?php echo $image['id']; ?>')"
                             data-image="data:image/jpeg;base64,<?php echo $image['image_data']; ?>"
                             data-title="<?php echo htmlspecialchars($image['event_name']); ?>"
                             data-date="<?php echo date('F j, Y', strtotime($image['uploaded_at'])); ?>">
                            <img src="data:image/jpeg;base64,<?php echo $image['image_data']; ?>" 
                                 alt="<?php echo htmlspecialchars($image['filename']); ?>" loading="lazy">
                            <div class="gallery-overlay">
                                <h3><?php echo htmlspecialchars($image['event_name']); ?></h3>
                               
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Modal -->
    <div id="imageModal" class="modal">
        <div class="modal-content">
            <button class="modal-close" onclick="closeModal()">&times;</button>
            <img id="modalImage" class="modal-image" src="" alt="">
            <div class="modal-details">
                <h3 id="modalTitle"></h3>
                <p id="modalDate"></p>
            </div>
            <div class="modal-navigation">
                <button class="modal-nav-btn" onclick="navigateImage(-1)">❮</button>
                <button class="modal-nav-btn" onclick="navigateImage(1)">❯</button>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000,
            once: true,
            offset: 100
        });

        let currentImageIndex = 0;
        const galleryItems = document.querySelectorAll('.gallery-item');

        function openModal(imageId) {
            const modal = document.getElementById('imageModal');
            const modalImg = document.getElementById('modalImage');
            const modalTitle = document.getElementById('modalTitle');
            const modalDate = document.getElementById('modalDate');
            
            const clickedImage = document.querySelector(`[data-id="${imageId}"]`);
            currentImageIndex = Array.from(galleryItems).indexOf(event.currentTarget);
            
            modalImg.src = event.currentTarget.getAttribute('data-image');
            modalTitle.textContent = event.currentTarget.getAttribute('data-title');
            modalDate.textContent = event.currentTarget.getAttribute('data-date');
            
            modal.style.display = "block";
            document.body.classList.add('modal-open');
        }

        function closeModal() {
            document.getElementById('imageModal').style.display = "none";
            document.body.classList.remove('modal-open');
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
            
            modalImg.src = newItem.getAttribute('data-image');
            modalTitle.textContent = newItem.getAttribute('data-title');
            modalDate.textContent = newItem.getAttribute('data-date');
        }

        // Close modal when clicking outside the image
        document.getElementById('imageModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        // Keyboard navigation
        document.addEventListener('keydown', function(e) {
            if (document.getElementById('imageModal').style.display === "block") {
                if (e.key === "Escape") {
                    closeModal();
                } else if (e.key === "ArrowRight") {
                    navigateImage(1);
                } else if (e.key === "ArrowLeft") {
                    navigateImage(-1);
                }
            }
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    <script>
        AOS.init({
            duration: 1000,
            once: true,
            offset: 100
        });

        lightbox.option({
            'resizeDuration': 200,
            'wrapAround': true,
            'showImageNumberLabel': false,
            'fadeDuration': 300
        });
    </script>
</body>
</html>