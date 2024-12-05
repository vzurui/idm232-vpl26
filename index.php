<?php
include 'db_connection.php'; //include connection
include 'search_bar.php'; //include search bar
$searchTerm = isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '';
?>

<!DOCTYPE html>
<html lang="en">
      <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home</title>
        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/style.css">
      </head>
<body>
<!--search bar-->
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
      <form action="index.php" method="GET">
        <input type="text" placeholder="Feelin' Hungry?" name="search" value="<?php echo htmlspecialchars($searchTerm); ?>">
      </form>
    </div>
  </div>
</div>
</div>
<!--end of search bar-->
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

<div class="nibbly-container">
<p class="home-text">What's Cooking,</p>
<img class="nibbly-colors"src="images/home-page-logo.png">
<p class="home-text">Good Looking?</p>
</div>
<p id="home-bold"class="home-text"><b>Let's get started.</b></p>

<?php
}
?>
<!-- footer -->
<footer>
  <p>2024 &copy;. Nibbly</p>
</footer>
</body>
</html>