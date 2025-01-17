<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $hospital_name = $_POST['hospital_name'];
    $mou_details = $_POST['mou_details'];
    $mou_date = $_POST['mou_date'];

    // Handle file upload
    $upload_file = $_FILES['file_upload'];

    // Get file type and read file content
    $file_type = strtolower(pathinfo($upload_file['name'], PATHINFO_EXTENSION));
    $file_content = file_get_contents($upload_file['tmp_name']);

    // Determine if the file is a PDF or image
    if ($file_type == 'pdf') {
        $file_category = 'pdf';
    } elseif (in_array($file_type, ['jpg', 'jpeg', 'png', 'gif'])) {
        $file_category = 'image';
    } else {
        echo "Only PDF or image files are allowed.";
        exit;
    }

    // Database connection
    include "../db_connect.php";
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO mou (hospital_name, mou_details, mou_date, file_type, file_content) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $hospital_name, $mou_details, $mou_date, $file_category, $file_content);

    // Execute the query
    header('Content-Type: application/json');
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'MOU added successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error: ' . $stmt->error]);
        }
        exit;


    $stmt->close();
    $conn->close();
}
?>
