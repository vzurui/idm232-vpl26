<?php
require 'db_connection.php';

// Get the recipe ID from the URL
$recipe_id = $_GET['id'] ?? null;
$recipe = null;

if ($recipe_id) {
    // Fetch the recipe from the database
    $sql = "SELECT * FROM successful_recipe_run WHERE id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $recipe_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $recipe = $result->fetch_assoc();
    $stmt->close();
}

// Debugging: Check what $recipe contains
// This will help identify if the query is working correctly
echo "<pre>";
print_r($recipe);
echo "</pre>";

$connection->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($recipe['recipe_name'] ?? 'Recipe Not Found') ?></title>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header class="header">
    <a href="index.php" class="logo"><h1>Nibbly</h1></a>
</header>
<main>
    <?php if ($recipe): ?>
        <h1><?= htmlspecialchars($recipe['recipe_name'] ?? 'Recipe Not Found') ?></h1>
        <p><?= htmlspecialchars($recipe['description'] ?? 'No description available.') ?></p>
        <ul>
            <?php foreach (explode("\n", $recipe['ingredients'] ?? '') as $ingredient): ?>
                <li><?= htmlspecialchars($ingredient) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Recipe not found. Please try another recipe.</p>
    <?php endif; ?>
</main>
</body>
</html>
