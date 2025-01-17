<?php
$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'pct';
// // Database connection (use same configuration as above)
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// // Get all images from database
$result = $db->query("SELECT * FROM test");

while ($row = $result->fetch_assoc()) {
//     // Convert blob data to base64
    $imageData = base64_encode($row['image']);
    $imageName = $row['family_head_name'];
    
//     // Display image
    echo "<div style='margin: 10px;'>";
    echo "name";
    echo "<h3>$imageName</h3>";
    echo "<img src='data:image/jpeg;base64,$imageData' style='max-width: 500px;'>";
    echo "</div>";
}

?>  