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
        <title>About</title>
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
        <form action="about.php" method="GET">
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
	<h2>About Us</h2>
	<div class="about">
	<p>At Nibbly, we believe every meal is an opportunity to create something special. We’re here to transform your everyday cooking into flavor-packed, feel-good moments you’ll look forward to. Whether it’s a quick fix for a busy day or an adventure in bold, global flavors, Nibbly makes cooking simple, exciting, and absolutely delicious.
  </p>
  <img class="about-image" src="images/delicious-heart.png">

  <p>Our mission is to take the stress out of cooking by offering recipes that are easy to follow, fun to make, and guaranteed to delight. From comforting classics to innovative dishes, we’ve curated a collection of ideas that cater to all cravings, moods, and skill levels.
  </p>
    <img class="about-image" src="images/table.png">
    <p>We’re more than just a recipe website—we’re your trusted partner in the kitchen, inspiring creativity, adventure, and a love for great food. One recipe at a time, Nibbly is here to make cooking easier, tastier, and way more fun. So grab your apron, turn up the heat, and let’s get cooking!
  </p>
  <img class="about-image" src="images/satisfied-user.png">
	</div>
	<?php
}
?>
<!-- footer -->
  <footer>
    <p>2024 &copy;. Nibbly</p>
</footer>

</body>
</html>