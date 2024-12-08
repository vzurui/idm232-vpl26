<?php
include 'db_connection.php'; // include connection
include 'search_bar.php'; // include search bar
$searchTerm = isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuisines</title>
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
      <form action="cuisines.php" method="GET">
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


    <main>
        <h2>Cuisines</h2>
				<p class="cuisine-caption">Find the flavor your dinner's been <i>missing.</i></p>
        <div class="cuisine-container">
            <!-- Cuisine List -->
            <ul class="cuisines-list">
    <?php
    include 'db_connection.php'; // Include database connection

    // Fetch all distinct cuisines in alphabetical order
    $sql = "SELECT DISTINCT cuisine FROM recipes_list WHERE cuisine IS NOT NULL AND cuisine != '' ORDER BY cuisine ASC";
    $result = $conn->query($sql);

    // Check which cuisine is selected
    $selected_cuisine = isset($_GET['cuisine']) ? htmlspecialchars($_GET['cuisine']) : '';

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $cuisine = htmlspecialchars($row['cuisine']);
            
            // keeps the cuisine underlined when you click on it
            $active_class = ($selected_cuisine === $cuisine) ? 'active' : '';
            
            echo "<li><a href='cuisines.php?cuisine=$cuisine' class='$active_class'>$cuisine</a></li>";
        }
    } else {
        echo "<li>No cuisines available</li>";
    }
    ?>
</ul>

            <!-- Recipe Grid -->
            <div class="recipe-grid">
                <?php
                // Check if a specific cuisine is selected
                $selected_cuisine = isset($_GET['cuisine']) ? htmlspecialchars($_GET['cuisine']) : '';

                if (!empty($selected_cuisine)) {
                    // Fetch recipes for the selected cuisine
                    $sql = "SELECT id, recipe_name, recipe_subtitle FROM recipes_list WHERE cuisine = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("s", $selected_cuisine);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $id = $row['id'];
                            $name = htmlspecialchars($row['recipe_name']);
                            $subtitle = htmlspecialchars($row['recipe_subtitle']);

                            $image_path = "images/recipes/{$id}.jpg";

                            echo "<a class='recipe-card' href='new-recipe.php?id=$id'>";
                            echo "<img src='$image_path' alt='Image of $name'>";
                            echo "<h3>$name</h3>";
                            echo "<p>$subtitle</p>";
                            echo "</a>";
                        }
                    } else {
                        echo "<p>No recipes found for $selected_cuisine cuisine.</p>";
                    }

                    $stmt->close();
                } else {
                  echo '<p class="cuisine-select"></p>';

                    echo '<p class="cuisine-select">Select a cuisine to view more!</p>';
                }

                $conn->close();
                ?>
            </div>
        </div>
    </main>
    <?php
}
?>
<!-- footer -->
    <footer>
    <p>2024 &copy;. Nibbly</p>
</footer>
</body>
</html>
