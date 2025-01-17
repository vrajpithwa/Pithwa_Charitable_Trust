<?php
include "../db_connect.php";
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_POST['id'];
$type = $_POST['type'];

if ($type === 'newsletter') {
    $sql = "DELETE FROM newsletters WHERE id = ?";
} elseif ($type === 'mou') {
    $sql = "DELETE FROM mou WHERE id = ?";
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid type.']);
    exit;
}

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Entry deleted successfully.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error deleting entry.']);
}

$stmt->close();
$conn->close();
?>
