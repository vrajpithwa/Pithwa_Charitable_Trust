<?php
// Database connection settings
$host = "localhost"; // Change this if needed
$username = "root";  // Change this to your MySQL username
$password = "";      // Change this to your MySQL password
$dbname = "pct"; // Change this to your database name

// Connect to the database
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Handle form submission
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $village = $_POST['village'];
    $current_address = $_POST['current_address'];
    $phone = $_POST['phone'];

   

    // Save to MySQL database
    $stmt = $conn->prepare("INSERT INTO Snehamilan_registrations (name, village, current_address, phone) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $village, $current_address, $phone);

    if ($stmt->execute()) {
        $message = "Registration successful! Data saved in both CSV and database.";
    } else {
        $message = "Error saving to database: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
