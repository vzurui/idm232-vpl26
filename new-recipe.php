<?php
require_once 'db_connection.php'; 
require_once'search_bar.php'; 

$searchTerm = isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; // get search term

$recipe_name = 'Single Recipe'; // ensures recipe name shows in title

if (empty($searchTerm) && isset($_GET['id']) && is_numeric($_GET['id']) && (int)$_GET['id'] > 0) {
    $recipe_id = (int)$_GET['id'];
    $sql = "SELECT recipe_name FROM recipes_list WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $recipe_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $recipe = $result->fetch_assoc();
            $recipe_name = $recipe['recipe_name'] ?? 'Single Recipe';
        }

        $stmt->close();
    }
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

<!-- header -->
<?php include 'header.php'; ?>

<div class="recipe-div">
<?php
if (!empty($searchTerm)) {
    echo '<h2>Search Results for "' . htmlspecialchars($searchTerm) . '"</h2>';
    echo '<div class="recipe-grid">'; // open grid container
    handleSearch($searchTerm, $conn); // call your search function to display results
    echo '</div>'; // close grid container
} else {
    // fetch and display a single recipe if no search is performed
    if (!isset($_GET['id']) || !is_numeric($_GET['id']) || (int)$_GET['id'] <= 0) {
        die("<p>Invalid recipe ID. Please provide a valid recipe ID.</p>");
    }
    
    $recipe_id = (int)$_GET['id'];
    $sql = "SELECT * FROM recipes_list WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("<p>Database query failed: " . htmlspecialchars($conn->error) . "</p>");
    }

    $stmt->bind_param("i", $recipe_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $recipe = $result->fetch_assoc();
    } else {
        die("Recipe not found. Please go back and try again.");
    }

    $stmt->close();

    // display the single recipe
    ?>
    <h2 class="recipe-header"><?php echo htmlspecialchars($recipe['recipe_name'] ?? 'Single Recipe'); ?></h2> 
    <hr class="solid">
         <!-- add servings and cook_time -->
    <div class="recipe-details">
        <div class="details-row">
            <p><strong>Cuisine:</strong> <?php echo htmlspecialchars($recipe['cuisine'] ?? 'N/A'); ?></p>
            <p><strong>Cook Time:</strong> <?php echo htmlspecialchars($recipe['cook_time'] ?? 'N/A'); ?> mins</p>
            <p><strong>Servings:</strong> <?php echo htmlspecialchars($recipe['servings'] ?? 'N/A'); ?></p>
        </div>
    </div>

    
    <div class="ingredients-div">
        <div class="ingredients-image">
            <?php
            $image_path = "images/recipes/{$recipe['id']}.jpg";
            ?>
            <img class="showcase-image" src="<?php echo $image_path; ?>" alt="<?php echo htmlspecialchars($recipe['recipe_name'] ?? 'Recipe Image'); ?>">
        </div>

   

        <div class="blurb-div">
            <h3>Description</h3>
            <p><?php echo htmlspecialchars($recipe['description'] ?? 'No description provided.'); ?></p>
        </div>

        <div class="ingredients-list">
            <h3>Ingredients</h3>
            <ul>
                <?php
                if (!empty($recipe['ingredients'])) {
                    $ingredients = explode(',', $recipe['ingredients']);
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

    <div class="blurb-div">
        <h3>Steps</h3>
        <ol>
            <?php
            if (!empty($recipe['steps'])) {
                $steps = explode('*', $recipe['steps']);
                foreach ($steps as $step) {
                    echo "<li>" . htmlspecialchars(trim($step)) . "</li>";
                }
            } else {
                echo "<li>No steps available.</li>";
            }
            ?>
        </ol>
    </div>
    <?php
}

$conn->close();
?>

</div>
<!-- footer -->
<footer>
    <p><a href="all-recipes.php">Back to All Recipes</a></p>
</footer>
</body>
</html>
