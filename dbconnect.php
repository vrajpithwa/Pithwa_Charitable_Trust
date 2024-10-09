<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydb";
$conn = new mysqli($servername, $username, $password);

if($conn -> connect_error){
    die("conn failed: ".$conn->connect_error ); 
}else{
    echo "conn success";
}

?>