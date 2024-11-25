<?php
// Database connection configuration
$host = 'localhost';         // Server name
$dbname = 'CSV_DB 5';   // Database name
$username = 'root';          // MySQL username (default for MAMP)
$password = 'root';              // MySQL password (default for MAMP)

// Establish connection
$connection = new mysqli($host, $username, $password, $dbname);

// Check for connection errors
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
?>


