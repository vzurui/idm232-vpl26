<?php
require_once 'db_connection.php'; 
require_once 'search_bar.php'; 

$searchTerm = isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; 

$recipe_name = 'Single Recipe'; // ensures the title page shows as receipe name

// check if no search term is provided and a valid recipe ID exists
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
            $recipe_name = $recipe['recipe_name']; // update recipe name for the title
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
    <title><?php echo htmlspecialchars($recipe_name); ?></title>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<!-- header -->
<?php include 'header.php'; ?>

<div class="recipe-div">
<?php
// if a search term is provided, display search results
if (!empty($searchTerm)) {
    echo '<h2>Search Results for "' . htmlspecialchars($searchTerm) . '"</h2>';
    echo '<div class="recipe-grid">'; 
    handleSearch($searchTerm, $conn); 
    echo '</div>';
} else {
    // if no search term, display the single recipe
    if (!isset($_GET['id']) || !is_numeric($_GET['id']) || (int)$_GET['id'] <= 0) {
        $conn->close(); // close connection 
        die("<p>Invalid recipe ID. Please provide a valid recipe ID.</p>");
    }

    $recipe_id = (int)$_GET['id'];
    $sql = "SELECT * FROM recipes_list WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        $conn->close(); // close connection 
        die("<p>Database query failed: " . htmlspecialchars($conn->error) . "</p>");
    }

    $stmt->bind_param("i", $recipe_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $recipe = $result->fetch_assoc();
    } else {
        $stmt->close();
        $conn->close();
        die("Recipe not found. Please go back and try again.");
    }

    $stmt->close();
    $conn->close(); // close connection 
    ?>

    <h2 class="recipe-header"><?php echo htmlspecialchars($recipe['recipe_name']); ?></h2> 
    <hr class="solid">

    <!-- recipe details: cuisine, cook time, servings -->
    <div class="recipe-details">
        <div class="details-row">
            <p><strong>Cuisine:</strong> <?php echo htmlspecialchars($recipe['cuisine'] ?? 'N/A'); ?></p>
            <p><strong>Cook Time:</strong> <?php echo htmlspecialchars($recipe['cook_time'] ?? 'N/A'); ?> mins</p>
            <p><strong>Servings:</strong> <?php echo htmlspecialchars($recipe['servings'] ?? 'N/A'); ?></p>
        </div>
    </div>

    <!-- recipe image -->
    <div class="ingredients-div">
        <div class="ingredients-image">
            <?php
            $image_path = "images/recipes/{$recipe['id']}.jpg";
            ?>
            <img class="showcase-image" src="<?php echo $image_path; ?>" alt="<?php echo htmlspecialchars($recipe['recipe_name']); ?>">
        </div>

        <!-- description -->
        <div class="blurb-div">
            <h3>Description</h3>
            <p><?php echo htmlspecialchars($recipe['description'] ?? 'No description provided.'); ?></p>
        </div>

        <!-- ingredients -->
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

    <!-- steps -->
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
?>
</div>

<!-- footer -->
<footer>
  <p class="help-button"><a href="help.php">Need Help?</a></p>
  <p>2024 &copy;. Nibbly</p>
</footer>
</body>
</html>
