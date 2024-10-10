<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pct";
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Collect family head data from the form
    $family_head_name = $conn->real_escape_string($_POST['family-head']); // Sanitize input
    $query = "INSERT INTO `family_head_details` (`family_head_name`) VALUES ('$family_head_name')";

    if ($conn->query($query) === TRUE) {
        echo "Record inserted successfully";
    } else {
        echo "Error: " . $query . "<br>" . $conn->error; // Use $query here instead of $sql
    }
}

$conn->close();
?>
