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
<header class="header">
<a href="index.html" class="logo"><img src="images/nibbly-logo.png"></a>
    <input class="menu-btn" type="checkbox" id="menu-btn" />
    <label class="menu-icon" for="menu-btn"><span class="navicon"></span></label>
    <ul class="menu">
        
  <li><a href="about.html">About</a></li>
  <li><a href="cuisines.php">Cuisines</a></li>
  <li><a href="all-recipes.php">All Recipes</a></li>
</ul>
  </header>

  <div class="topnav">
    <div class="search-container">
      <form action="/action_page.php">
        <input type="text" placeholder="Search Here!" name="search">
      </form>
    </div>
  </div>
<!--search bar end-->

    <main>
        <h2>Cuisines</h2>
				<p>Find the flavor your dinner's been missing.</p>
        <div class="cuisine-container">
            <!-- Cuisine List -->
            <ul class="cuisines-list">
                <?php
                include 'db_connection.php'; // Include database connection

                // Fetch all distinct cuisines
                $sql = "SELECT DISTINCT cuisine FROM recipes_list WHERE cuisine IS NOT NULL AND cuisine != ''";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $cuisine = htmlspecialchars($row['cuisine']);
                        echo "<li><a href='cuisines.php?cuisine=$cuisine'>$cuisine</a></li>";
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
                            $placeholderImage = "images/placeholder.webp";

                            echo "<a class='recipe-card' href='recipe.php?id=$id'>";
                            echo "<img src='$placeholderImage' alt='Image of $name'>";
                            echo "<h3>$name</h3>";
                            echo "<p>$subtitle</p>";
                            echo "</a>";
                        }
                    } else {
                        echo "<p>No recipes found for $selected_cuisine cuisine.</p>";
                    }

                    $stmt->close();
                } else {
                    echo "<p>Select a cuisine to view recipes!</p>";
                }

                $conn->close();
                ?>
            </div>
        </div>
    </main>

    <footer>
        <p><a href="search-found.html">Search</a></p>
    </footer>
</body>
</html>
