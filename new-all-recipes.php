<?php
include 'db_connection.php'; // Include the database connection

// Fetch all recipes from the database
$sql = "SELECT id, `recipe-name`, `recipe-subtitle` FROM recipes_list";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<div class='recipe-grid'>"; // Start the grid container
    while ($row = $result->fetch_assoc()) {
        $id = $row['id']; // Fetch the unique recipe ID
        $name = htmlspecialchars($row['recipe-name']); // Fetch the recipe name
        $subtitle = htmlspecialchars($row['recipe-subtitle']); // Fetch the recipe subtitle
        $placeholderImage = "images/elementor-placeholder-image.webp"; // Placeholder for images

        // Dynamically generate each recipe card
        echo "<a class='recipe-card' href='recipe.php?id=$id'>"; // Link to the recipe page
        echo "<img src='$placeholderImage' alt='$name'>"; // Placeholder image
        echo "<div class='recipe-info'>";
        echo "<h3>$name</h3>";
        echo "<p>$subtitle</p>";
        echo "</div>";
        echo "</a>";
    }
    echo "</div>"; // Close the grid container
} else {
    echo "<p>No recipes found!</p>";
}

$conn->close(); // Close the database connection
?>
