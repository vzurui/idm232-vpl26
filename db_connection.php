<?php
$host = 'localhost';
$username = 'root';
$password = 'root';
$database = 'idm232_db';

$conn = new mysqli($host, $password, $username, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully!";

$conn->close();
?>



