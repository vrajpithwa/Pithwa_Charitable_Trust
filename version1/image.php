<?php
// image.php - Script to serve images from database
header('Content-Type: image/jpeg'); // Adjust content type if you store different image types

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "pct";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $stmt = $conn->prepare("SELECT file_data FROM event_gallery WHERE id = ?");
        $stmt->execute([$id]);
        $image = $stmt->fetch(PDO::FETCH_COLUMN);
        
        if ($image) {
            echo $image;
        }
    } catch(PDOException $e) {
        // Log error instead of displaying it
        error_log("Database error: " . $e->getMessage());
    }
}
?>