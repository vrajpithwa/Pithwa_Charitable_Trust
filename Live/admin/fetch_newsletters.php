<?php
include "../db_connect.php";
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM newsletters ORDER BY newsletter_date DESC";
$result = $conn->query($sql);

$newsletters = [];
while ($row = $result->fetch_assoc()) {
    $newsletters[] = $row;
}

header('Content-Type: application/json');
echo json_encode($newsletters);

$conn->close();
?>
