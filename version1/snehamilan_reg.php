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
        $message = "Registration successful! Data saved in and database.";
    } else {
        $message = "Error saving to database: " . $stmt->error;
    }

    $stmt->close();
}

// Retrieve data from the database
$result = $conn->query("SELECT id, name, village, current_address, phone, submission_time FROM Snehamilan_registrations order by id DESC");


$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>પીઠવા ચેરિટેબલ ટ્રસ્ટ</title>
    <link rel="stylesheet" href="./assets/css/index.css">
    <style> 
        .container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 20px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}

.form-container{
    background: #fff;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    width: 95%;
    margin-bottom: 20px;
    text-align: center;
}

.table-container {
    background: #fff;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    width: 95%;
    margin-bottom: 20px;
    text-align: center;
}

h1, h2 {
    text-align: center;
    color: #d32f2f;
}

form {
    display: flex;
    flex-direction: column;
    align-items: center;
}

label {
    margin-bottom: 5px;
    font-weight: bold;
    color: #555;
    width: 100%;
    text-align: left;
}

input {
    margin-bottom: 15px;
    padding: 10px;
    font-size: 1rem;
    border: 1px solid #ccc;
    border-radius: 4px;
    width: 100%;
}

button {
    padding: 10px;
    font-size: 1rem;
    background-color: #d32f2f;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    width: 100%;
}

button:hover {
    background-color: #a52727;
}

.message {
    margin-top: 15px;
    font-size: 1rem;
    color: green;
    text-align: center;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table, th, td {
    border: 1px solid #ddd;
}

th, td {
    padding: 10px;
    text-align: left;
}

th {
    background-color: #d32f2f;
    color: #fff;
}
    </style>
</head>
<body>
<div class="container">
    <?php include "header.php";?>
 <div class="form-container">
        <h1>પીઠવા રેસીડન્સ ટ્રસ્ટ (અમદાવાદ)</h1>
        <form action="" method="POST">
            <label for="name">નામ:</label>
            <input type="text" id="name" name="name" required>

            <label for="village">જુનુ ગામ:</label>
            <input type="text" id="village" name="village" required>

            <label for="current_address">હાલ રહેતા ગામ/સ્થાન:</label>
            <input type="text" id="current_address" name="current_address" required>

            <label for="phone">મોબાઇલ નમ્બર:</label>
            <input type="tel" id="phone" name="phone" required>

            <button type="submit">સબમિટ</button>
        </form>
        <?php if ($message): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>
    </div>

    <div class="table-container">
        <h2>Registration Details</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Village</th>
                    <th>Current Address</th>
                    <th>Phone</th>
                    <th>Submission Time</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['village']); ?></td>
                            <td><?php echo htmlspecialchars($row['current_address']); ?></td>
                            <td><?php echo htmlspecialchars($row['phone']); ?></td>
                            <td><?php echo htmlspecialchars($row['submission_time']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align: center;">No data available</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php include "footer.php"; ?>
</div>
</body>
</html>
