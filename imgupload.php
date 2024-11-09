
<!DOCTYPE html>
<html>
<head>
    <title>Image Upload</title>
</head>
<body>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <input type="file" name="image" accept="image/*" required>
        <input type="submit" value="Upload Image">
    </form>
</body>
</html>

<?php
// view.php - Retrieve and display images
// Create a new PHP file named view.php with this code:
?>

<?php
// Database connection (use same configuration as above)
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Get all images from database
$result = $db->query("SELECT id, name, image_data FROM images");

while ($row = $result->fetch_assoc()) {
    // Convert blob data to base64
    $imageData = base64_encode($row['image_data']);
    $imageName = $row['name'];
    
    // Display image
    echo "<div style='margin: 10px;'>";
    echo "<h3>$imageName</h3>";
    echo "<img src='data:image/jpeg;base64,$imageData' style='max-width: 500px;'>";
    echo "</div>";
}

// SQL to create the required table
/*
CREATE TABLE images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    image_data MEDIUMBLOB NOT NULL,
    upload_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
*/
?>