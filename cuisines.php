<?php
include 'db_connection.php'; // include connection
include 'search_bar.php';    // include search bar logic
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
<!-- search bar -->
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
<!-- search bar end -->

<?php
if (!empty($searchTerm)) {
    echo '<h2>Search Results for "' . $searchTerm . '"</h2>';
    echo '<div class="recipe-grid">';
    handleSearch($searchTerm, $conn); 
    echo '</div>';
} else {
?>

<main>
    <h2>Cuisines</h2>
    <p class="cuisine-caption">Find the flavor your dinner's been <i>missing.</i></p>
    <div class="cuisine-container">
        <!-- cuisine List -->
        <ul class="cuisines-list">
        <?php
        // fetch all distinct cuisines in alphabetical order
        $sql = "SELECT DISTINCT cuisine FROM recipes_list WHERE cuisine IS NOT NULL AND cuisine != '' ORDER BY cuisine ASC";
        $result = $conn->query($sql);

        // check which cuisine is selected
        $selected_cuisine = isset($_GET['cuisine']) ? htmlspecialchars($_GET['cuisine']) : '';

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $cuisine = htmlspecialchars($row['cuisine']);
                // keeps the cuisine underlined when clicked
                $active_class = ($selected_cuisine === $cuisine) ? 'active' : '';
                echo "<li><a href='cuisines.php?cuisine=$cuisine' class='$active_class'>$cuisine</a></li>";
            }
        } else {
            echo "<li>No cuisines available</li>";
        }
        ?>
        </ul>

        <!-- recipe Grid -->
        <div class="recipe-grid">
        <?php
        if (!empty($selected_cuisine)) {
            // fetch recipes for the selected cuisine along with cook time and servings
            $sql = "SELECT id, recipe_name, recipe_subtitle, cook_time, servings FROM recipes_list WHERE cuisine = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $selected_cuisine);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $id = $row['id'];
                    $name = htmlspecialchars($row['recipe_name']);
                    $subtitle = htmlspecialchars($row['recipe_subtitle']);
                    $cook_time = htmlspecialchars($row['cook_time'] ?? 'N/A');
                    $servings = htmlspecialchars($row['servings'] ?? 'N/A');

                    $image_path = "images/recipes/{$id}.jpg";

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
                echo "<p>No recipes found for $selected_cuisine cuisine.</p>";
            }

            $stmt->close();
        } else {
            echo '<p></p>'; // empty text to center next text
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
<!-- Footer -->
<footer>
    <p>2024 &copy;. Nibbly</p>
</footer>
</body>
</html>
