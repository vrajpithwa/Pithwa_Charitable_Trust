<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $newsletter_date = $_POST['newsletter_date'];
    $title = $_POST['title'];
    $excerpt = $_POST['excerpt'];
    $pdf_url = $_POST['pdf_url'];

    // Image handling
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = $_FILES['image']['tmp_name'];
        $imageData = file_get_contents($image);
        $imageBase64 = base64_encode($imageData);
    } else {
        die("Image upload error.");
    }
    include "db_connect.php";
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare the SQL statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO newsletters (image_base64, newsletter_date, title, excerpt, pdf_url) 
                            VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $imageBase64, $newsletter_date, $title, $excerpt, $pdf_url);
    header('Content-Type: application/json');
    // Execute the statement
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Newsletter added successfully.']);
        echo "Newsletter added successfully!";
    } else {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $stmt->error]);
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
