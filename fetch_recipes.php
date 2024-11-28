<?php
include 'db_connection.php'; // Include the database connection

// Corrected SQL query using backticks for column names
$sql = "SELECT `recipe-name` AS Title, `recipe-subtitle` AS Subtitle FROM recipes";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $title = htmlspecialchars($row['Title']);
        $subtitle = htmlspecialchars($row['Subtitle']);

        echo "<div class='recipe-card'>";
        echo "<h3>$title</h3>";
        echo "<p>$subtitle</p>";
        echo "</div>";
    }
} else {
    echo "<p>No recipes found!</p>";
}

$conn->close(); // Close the database connection
?>
