<?php
include 'db_connection.php'; // Include the database connection

// Get the recipe ID from the URL
$recipe_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Validate the `id`
if ($recipe_id <= 0) {
    echo "<p>Invalid or missing recipe ID.</p>";
    exit;
}

// Fetch the recipe details from the database
$sql = "SELECT * FROM recipes_list WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $recipe_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $recipe = $result->fetch_assoc(); // Fetch recipe details as an associative array
} else {
    echo "<p>Recipe not found!</p>";
    exit;
}

$conn->close(); // Close the database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($recipe['recipe-name']); ?></title>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <a href="all-recipes.php">Back to All Recipes</a>
        <h1><?php echo htmlspecialchars($recipe['recipe-name']); ?></h1>
    </header>

    <main>
        <h2><?php echo htmlspecialchars($recipe['recipe-subtitle']); ?></h2>
        <p><strong>Cuisine:</strong> <?php echo htmlspecialchars($recipe['cuisine']); ?></p>
        <p><strong>Protein:</strong> <?php echo htmlspecialchars($recipe['protein']); ?></p>
        <p><strong>Cook Time:</strong> <?php echo htmlspecialchars($recipe['cook-time']); ?> minutes</p>
        <p><strong>Servings:</strong> <?php echo htmlspecialchars($recipe['servings']); ?></p>

        <h2>Description</h2>
        <p><?php echo htmlspecialchars($recipe['description']); ?></p>

        <h2>Ingredients</h2>
        <ul>
            <?php
            // Display ingredients as a list
            $ingredients = explode(',', $recipe['ingredients']);
            foreach ($ingredients as $ingredient) {
                echo "<li>" . htmlspecialchars(trim($ingredient)) . "</li>";
            }
            ?>
        </ul>

        <h2>Steps</h2>
        <p><?php echo nl2br(htmlspecialchars($recipe['steps'])); ?></p>
    </main>
</body>
</html>
