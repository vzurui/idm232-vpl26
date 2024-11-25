<?php
require 'db_connection.php'; // Include your database connection file

if (isset($_GET['id'])) {
    $recipe_id = intval($_GET['id']); // Sanitize the recipe ID

    $sql = "SELECT * FROM successful_recipe_run WHERE id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $recipe_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $recipe = $result->fetch_assoc();

        // Display the recipe details with null handling
        echo "<h1>" . htmlspecialchars($recipe['recipe_name'] ?? 'No recipe name available') . "</h1>";
        echo "<h2>" . htmlspecialchars($recipe['recipe_subtitle'] ?? 'No subtitle available') . "</h2>";
        echo "<p>Cook Time: " . htmlspecialchars($recipe['cook_time'] ?? 'N/A') . " minutes</p>";
        echo "<p>Servings: " . htmlspecialchars($recipe['servings'] ?? 'N/A') . "</p>";
        echo "<h3>Description</h3>";
        echo "<p>" . htmlspecialchars($recipe['description'] ?? 'No description available') . "</p>";
        echo "<h3>Ingredients</h3>";
        echo "<p>" . nl2br(htmlspecialchars($recipe['ingredients'] ?? 'No ingredients available')) . "</p>";
        echo "<h3>Steps</h3>";
        echo "<p>" . nl2br(htmlspecialchars($recipe['steps'] ?? 'No steps available')) . "</p>";
    } else {
        echo "<p>Recipe not found.</p>";
    }

    $stmt->close();
} else {
    echo "<p>No recipe ID provided.</p>";
}

$connection->close(); // Close the database connection
?>
