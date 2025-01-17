<?php
// Database connection
include "db_connect.php";
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Validate and fetch the file
$id = intval($_GET['id']);
$sql = "SELECT file_content, file_type FROM mou WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($file_content, $file_type);
    $stmt->fetch();

    // Determine MIME type and serve the file
    if ($file_type == 'pdf') {
        header("Content-Type: application/pdf");
        echo $file_content;
    } elseif (strpos($file_type, 'image') !== false) {
        // Extract the specific image format (e.g., png, jpeg, etc.)
        $image_format = str_replace('image/', '', $file_type);
        header("Content-Type: image/$image_format");
        echo $file_content;
    } else {
        echo "Unsupported file type.";
    }
} else {
    echo "File not found.";
}

$stmt->close();
$conn->close();
?>
