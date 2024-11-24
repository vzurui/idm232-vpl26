<?php
// Include the database connection
require_once 'db_connection.php';

// Run your queries
$sql = "SELECT * FROM recipes";
$result = $connection->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "Recipe Name: " . htmlspecialchars($row['recipe_name']) . "<br>";
    }
} else {
    echo "No recipes found.";
}

// Close the connection
$connection->close();
?>

