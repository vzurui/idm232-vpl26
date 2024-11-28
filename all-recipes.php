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
<header class="header">
    <a href="index.html" class="logo"><h1>Nibbly</h1></a>
    <input class="menu-btn" type="checkbox" id="menu-btn" />
    <label class="menu-icon" for="menu-btn"><span class="navicon"></span></label>
    <ul class="menu">
        <div class="topnav">
            <div class="search-container">
                <form action="/action_page.php">
                    <input type="text" placeholder="Search Here!" name="search">
                </form>
            </div>
        </div>
        <li><a href="about.html">About</a></li>
        <li><a href="categories.html">Categories</a></li>
        <li><a href="all-recipes.php">All Recipes</a></li>
    </ul>
</header>

<main>
    <h2>All Recipes</h2>
    <div class="recipe-grid">
        <?php
        include 'db_connection.php'; // Include the database connection

        // Fetch recipes from the database
        $sql = "SELECT `recipe-name` AS Title, `recipe-subtitle` AS Subtitle FROM recipes_list";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $title = htmlspecialchars($row['Title']);
                $subtitle = htmlspecialchars($row['Subtitle']);
                $placeholderImage = "images/elementor-placeholder-image.webp";

                echo "<a class='recipe' href='recipe.html'>";
                echo "<img src='$placeholderImage' alt='$title'>";
                echo "<div class='recipe-info'>";
                echo "<h3>$title</h3>";
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
</main>

<footer>
    <p><a href="no-search.html">No Search</a></p>
    <p><a href="search-found.html">Search</a></p>
</footer>
</body>
</html>
