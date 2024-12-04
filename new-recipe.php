<?php
include 'db_connection.php';
include 'search_bar.php'; 

// Handle search term if present
$searchTerm = isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '';

// Only proceed with recipe ID if no search term is provided
if (empty($searchTerm)) {
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

    $stmt->close(); // Close statement
}

// Close the database connection if no search is performed
if (empty($searchTerm)) {
    $conn->close();
}
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
<!-- search bar-->
<div class="fixed-container">
    <div class="search-bar">
        <header class="header">
            <a href="index.php" class="logo"><img src="images/nibbly-logo.png"></a>
            <input class="menu-btn" type="checkbox" id="menu-btn" />
            <label class="menu-icon" for="menu-btn"><span class="navicon"></span></label>
            <ul class="menu">
                <li><a href="about.php">About</a></li>
                <li><a href="cuisines.php">Cuisines</a></li>
                <li><a href="all-recipes.php">All Recipes</a></li>
            </ul>
        </header>
        <div class="topnav">
            <div class="search-container">
                <form action="new-recipe.php" method="GET">
                    <input type="text" placeholder="Feelin' Hungry?" name="search" value="<?php echo htmlspecialchars($searchTerm); ?>">
                </form>
            </div>
        </div>
    </div>
</div>
<!--search bar end-->

<?php
// If a search term is provided, show search results
if (!empty($searchTerm)) {
    echo '<h2>Search Results for "' . htmlspecialchars($searchTerm) . '"</h2>';
    echo '<div class="recipe-grid">';
    handleSearch($searchTerm, $conn); // Use the search function to display results
    echo '</div>';
} else {
    // If no search term, display the single recipe content
?>
    <h2 class="recipe-header"><?php echo htmlspecialchars($recipe['recipe_name'] ?? 'Single Recipe'); ?></h2>
    <hr class="solid">
    <div class="recipe-div">
        <!-- Recipe Image -->
        <div class="ingredients-div">
            <div class="ingredients-image">
                <?php
                $image_path = "images/recipes/{$recipe['id']}.jpg"; // Dynamically generate the image path
                if (!file_exists($image_path)) {
                    $image_path = "images/placeholder.webp"; // Fallback to placeholder
                }
                ?>
                <img class="showcase-image" src="<?php echo $image_path; ?>" alt="<?php echo htmlspecialchars($recipe['recipe_name'] ?? 'Recipe Image'); ?>">
            </div>
        </div>

        <!-- Recipe Description -->
        <div class="blurb-div">
            <h3>Description</h3>
            <p><?php echo htmlspecialchars($recipe['description'] ?? 'No description provided.'); ?></p>
        </div>

        <!-- Recipe Ingredients -->
        <div class="ingredients-list">
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
<?php
}
?>

<footer>
    <p>2024 &copy;. Nibbly</p>
</footer>
</body>
</html>
