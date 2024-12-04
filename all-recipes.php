<?php
include 'db_connection.php';
include 'search_bar.php'; 
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
      <form action="all-recipes.php" method="GET">
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
    echo '<h2>Search Results for "' . $searchTerm . '"</h2>';
    echo '<div class="recipe-grid">';
    handleSearch($searchTerm, $conn); // Use the search function to display results
    echo '</div>';
} else {
    // If no search term, display the "About Us" content
?>	

    <h2>All Recipes</h2>
    <div class="all-recipe-grid">
    <?php
    include 'db_connection.php'; // Include the database connection

    // Fetch all recipes from the database
    $sql = "SELECT id, recipe_name, recipe_subtitle FROM recipes_list";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $id = $row['id']; // Fetch the unique recipe ID
            $name = htmlspecialchars($row['recipe_name'] ?? 'No Name Available'); // Fetch the recipe name
            $subtitle = htmlspecialchars($row['recipe_subtitle'] ?? 'No Subtitle Available'); // Fetch the recipe subtitle

            // Dynamically generate the image path based on the recipe ID
            $image_path = "images/recipes/{$id}.jpg";
            }

            // Dynamically generate each recipe card
            echo "<a class='recipe-card' href='new-recipe.php?id=$id'>";
            echo "<img src='$image_path' alt='Image of $name'>";
            echo "<div class='recipe-info'>";
            echo "<h3>$name</h3>";
            echo "<p>$subtitle</p>";
            echo "</div>";
            echo "</a>";
        }
    } else {
        echo "<p>No recipes found!</p>";
    }

    $conn->close(); // Close the database connection
    ?>
</div>
<?php
}
?>
<footer>
    <p>2024 &copy;. Nibbly</p>
</footer>
</body>
</html>
