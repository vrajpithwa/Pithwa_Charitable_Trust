<?php
// require_once 'vendor/autoload.php';
// $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
// $dotenv->load();
// $servername = $_ENV['DB_HOST'];
// $username = $_ENV['DB_USERNAME'];
// $password = $_ENV['DB_PASSWORD'];
// $dbname = $_ENV['DB_NAME'];
// // Create connection
// $conn = mysqli_connect($servername, $username, $password, $dbname);

?>

<?php
  define('DB_SERVER', 'localhost');
  define('DB_USERNAME', 'root');
  define('DB_PASSWORD', '');
  define('DB_NAME', 'pct'); $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
  if ($conn === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
  }
?>