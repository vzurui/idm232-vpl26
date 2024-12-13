<?php
require_once 'db_connection.php'; 
require_once'search_bar.php'; 

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

<!-- header -->
<?php include 'header.php'; ?>


<?php
// if a search term is provided, show search results
if (!empty($searchTerm)) {
    echo '<h2>Search Results for "' . $searchTerm . '"</h2>';
    echo '<div class="recipe-grid">';
    handleSearch($searchTerm, $conn); // use the search function to display results
    echo '</div>';
} else {
    // if no search term, display the "About Us" content
?>	

<div class="nibbly-container">
<p class="home-text">What's Cooking,</p>
<img class="nibbly-colors"src="images/home-page-logo.png" alt="Home Page Logo">
<p class="home-text">Good Looking?</p>
</div>
<p id="home-bold"class="home-text"><b>Let's get started.</b></p>

<?php
}
?>

<!-- footer -->
<footer>
  <p class="help-button"><a href="help.php">Need Help?</a></p>
  <p>2024 &copy;. Nibbly</p>
</footer>
</body>
</html>