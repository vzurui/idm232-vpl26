<?php
include 'db_connection.php'; // Include the database connection

// Get the recipe ID from the URL
if (!isset($_GET['id']) || (int)$_GET['id'] <= 0) {
    die("Invalid recipe ID. Please provide a valid recipe ID.");
}

$recipe_id = (int)$_GET['id']; // Sanitize the ID

// Fetch the recipe from the database
$sql = "SELECT * FROM recipes_list WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $recipe_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $recipe = $result->fetch_assoc();
} else {
    die("Recipe not found. Please go back and try again.");
}

$conn->close(); // Close the database connection
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($recipe['recipe_name'] ?? 'Single Recipe'); ?></title>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header class="header">
        <a href="index.html" class="logo"><h1>Nibbly</h1></a>
        <input class="menu-btn" type="checkbox" id="menu-btn" />
        <label class="menu-icon" for="menu-btn"><span class="navicon"></span></label>
        <ul class="menu">
            <li><a href="about.html">About</a></li>
            <li><a href="cuisines.html">Cuisines</a></li>
            <li><a href="all-recipes.html">All Recipes</a></li>
        </ul>
    </header>

    <h2><?php echo htmlspecialchars($recipe['recipe_name'] ?? 'Single Recipe'); ?></h2>
    <div class="recipe-div">
        <!-- Recipe Image -->
        <div class="ingredients-div">
            <img src="images/elementor-placeholder-image.webp" alt="<?php echo htmlspecialchars($recipe['recipe_name'] ?? 'Recipe Image'); ?>">
            <div>
                <h3>Ingredients</h3>
                <ul>
                    <?php
                    if (!empty($recipe['ingredients'])) {
                        $ingredients = explode(',', $recipe['ingredients']); // Assuming ingredients are comma-separated
                        foreach ($ingredients as $ingredient) {
                            echo "<li>" . htmlspecialchars(trim($ingredient)) . "</li>";
                        }
                    } else {
                        echo "<li>No ingredients available.</li>";
                    }
                    ?>
                </ul>
            </div>
        </div>

        <!-- Recipe Description -->
        <div class="blurb-div">
            <h3>Description</h3>
            <p><?php echo htmlspecialchars($recipe['description'] ?? 'No description provided.'); ?></p>
        </div>

        <!-- Recipe Steps -->
        <div class="blurb-div">
            <h3>Steps</h3>
            <ol>
                <?php
                if (!empty($recipe['steps'])) {
                    $steps = explode('*', $recipe['steps']); // Assuming steps are separated by '*'
                    foreach ($steps as $step) {
                        echo "<li>" . htmlspecialchars(trim($step)) . "</li>";
                    }
                } else {
                    echo "<li>No steps available.</li>";
                }
                ?>
            </ol>
        </div>
    </div>

    <hr class="solid">

    <footer>
        <p><a href="all-recipes.php">Back to All Recipes</a></p>
    </footer>
</body>
</html>
