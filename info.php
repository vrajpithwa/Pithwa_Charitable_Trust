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
} else {
    echo "Connected successfully<br>";
}

// SQL query to select all records from `family_head_details`
$query = "SELECT * FROM `family_head_details`";
$result = $conn->query($query);

// Check if query returns results
if ($result->num_rows > 0) {
    // Output data of each row
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Address</th>
                <th>Other Column Names...</th>
            </tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["family_head_name"] . "</td>
                <td>" . $row["name"] . "</td>
                <td>" . $row["address"] . "</td>
                <td>Other Data...</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

// Close the database connection
$conn->close();
?>
