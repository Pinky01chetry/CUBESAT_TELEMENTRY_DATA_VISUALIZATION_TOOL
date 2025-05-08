<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "satellite_dashboard";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connection to database successful!";
}

$conn->close();
?>
