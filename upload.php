<?php
// Database configuration
$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'pct';

// Create database connection
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// upload.php - Handle image upload
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["image"])) {
    $file = $_FILES['image'];
    
    // Check if file is an actual image
    $check = getimagesize($file["tmp_name"]);
    if($check === false) {
        die("File is not an image.");
    }
    
    // Prepare image for database
    $image = file_get_contents($file["tmp_name"]);
    $imageName = $file["name"];
    
    // Prepare and bind
    $stmt = $db->prepare("INSERT INTO test (family_head_name, image) VALUES (?, ?)");
    $stmt->bind_param("ss", $imageName, $image);
    
    // Execute query
    if ($stmt->execute()) {
        $imageId = $stmt->insert_id;
        echo "Image uploaded successfully. ID: " . $imageId;
    } else {
        echo "Error uploading image: " . $stmt->error;
    }
    
    $stmt->close();
}

// Create the upload form HTML
?>
