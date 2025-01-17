<?php
// mou.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "meta.php"; ?>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/index.css">
    <style>
        .mou-container {
            max-width: 1200px;
            margin: 120px auto 40px;
            padding: 0 20px;
        }

        .mou-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }

        .mou-card {
            background: var(--white);
            border-radius: 1rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            overflow: hidden;
            transition: 0.3s;
        }

        .mou-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        }

        .mou-content {
            padding: 1.5rem;
        }

        .mou-title {
            font-size: 1.25rem;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }

        .mou-details {
            color: var(--text);
            margin-bottom: 1rem;
        }

        .mou-date {
            color: #666;
            font-size: 0.9rem;
        }

        .view-btn {
            display: inline-block;
            padding: 0.5rem 1rem;
            background: var(--primary);
            color: var(--white);
            text-decoration: none;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: 0.3s;
        }

        .view-btn:hover {
            background: var(--secondary);
            transform: translateY(-2px);
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.8);
        }

        .modal-content {
            margin: 5% auto;
            padding: 20px;
            width: 80%;
            background: #fff;
            border-radius: 10px;
            position: relative;
        }

        .modal-close {
            position: absolute;
            top: 10px;
            right: 20px;
            font-size: 30px;
            color: #333;
            cursor: pointer;
        }

        .modal iframe, .modal img {
            width: 100%;
            height: 80vh;
        }
        .mou-header {
            padding: 8rem 8rem;
            background: linear-gradient(45deg, var(--primary), var(--secondary));
            color: var(--white);
            text-align: center;
        }
    </style>
</head>
<body>
    <div style="color: black">
        <?php include "navbar.php"; ?>
    </div>
    <header class="mou-header">
        <h1>Medical Initiative MOUs</h1>
    </header>
    <div class="mou-container">
        <div class="mou-grid">
            <?php
            // Database connection
            include "db_connect.php";
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Fetch MOU data
            $sql = "SELECT * FROM mou ORDER BY mou_date DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $file_content = base64_encode($row['file_content']);
                    $file_type = $row['file_type'];
                    $modal_content = '';

                    // Prepare the modal content based on file type
                    if ($file_type == 'pdf') {
                        $modal_content = '<iframe src="data:application/pdf;base64,' . $file_content . '" frameborder="0"></iframe>';
                    } elseif (strpos($file_type, 'image') !== false) {
                        $modal_content = '<img src="data:' . $file_type . ';base64,' . $file_content . '" alt="MOU Image">';
                    }

                    echo '
                    <div class="mou-card" data-aos="fade-up">
                        <div class="mou-content">
                            <h3 class="mou-title">' . htmlspecialchars($row['hospital_name']) . '</h3>
                            <p class="mou-details">' . htmlspecialchars($row['mou_details']) . '</p>
                            <p class="mou-date">Valid from: ' . date("F Y", strtotime($row['mou_date'])) . '</p>
                            <button class="view-btn" onclick=\'showModal(`' . $modal_content . '`)\'>View Document</button>
                        </div>
                    </div>';
                }
            } else {
                echo "No MOU records found.";
            }

            $conn->close();
            ?>
        </div>
    </div>

    <!-- Modal -->
    <div id="fileModal" class="modal">
        <div class="modal-content">
            <span class="modal-close" onclick="closeModal()">&times;</span>
            <div id="modal-body"></div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script src="./assets/js/index.js"></script>
    <script>
        function showModal(content) {
            const modal = document.getElementById('fileModal');
            const modalBody = document.getElementById('modal-body');
            modalBody.innerHTML = content;
            modal.style.display = 'block';
        }

        function closeModal() {
            const modal = document.getElementById('fileModal');
            modal.style.display = 'none';
        }

        // Close modal on click outside
        window.onclick = function(event) {
            const modal = document.getElementById('fileModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        };
    </script>
</body>
</html>
