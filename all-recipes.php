<?php
require_once 'db_connection.php'; 
require_once 'search_bar.php'; 

$searchTerm = isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Recipes</title>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
  
<!-- header -->
<?php include 'header.php'; ?>

<?php
// if a search term is provided, show search results
if (!empty($searchTerm)) {
    echo '<h2>Search Results for "' . $searchTerm . '"</h2>';
    echo '<div class="recipe-grid">';
    handleSearch($searchTerm, $conn); // Use the search function to display results
    echo '</div>';
} else {
    // if no search term, display all recipes
?>  
    <h2>All Recipes</h2>
    <div class="all-recipe-grid">
    <?php
    // fetch all recipes from the database
    $sql = "SELECT id, recipe_name, recipe_subtitle, cook_time, servings FROM recipes_list";
    $result = $conn->query($sql);

    if ($result) { // ensure query executed successfully
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $id = $row['id'];
                $name = htmlspecialchars($row['recipe_name'] ?? 'No Name Available');
                $subtitle = htmlspecialchars($row['recipe_subtitle'] ?? 'No Subtitle Available');
                $cook_time = htmlspecialchars($row['cook_time'] ?? 'N/A');
                $servings = htmlspecialchars($row['servings'] ?? 'N/A');

                // dynamically generate the image path
                $image_path = "images/recipes/{$id}.jpg";
            

                // dynamically generate each recipe card
                echo "<a class='recipe-card' href='new-recipe.php?id=$id'>";
                echo "<img src='$image_path' alt='Image of $name'>";
                echo "<div class='recipe-info'>";
                echo "<h3>$name</h3>";
                echo "<p>$subtitle</p>";
                echo "<div class='recipe-details'>";
                echo "<p>Cook Time: $cook_time mins</p>";
                echo "<p>Servings: $servings</p>";
                echo "</div>";
                echo "</div>";
                echo "</a>";
            }
        } else {
            echo "<p>No recipes found!</p>";
        }
    } else {
        echo "<p>Error fetching recipes. Please try again later.</p>"; // error handling
    }
    ?>
    </div>
<?php
}
$conn->close(); // close the database connection
?>

<!--footer-->
<footer>
    <p>2024 &copy;. Nibbly</p>
</footer>
</body>
</html>
