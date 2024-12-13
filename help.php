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
        <title>Help</title>
        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/style.css">
      </head>
<body>

<!-- header -->
<?php include 'header.php'; ?>

<div class="help-page">
	<h2 class="help-header">
		How To Use
</h2>
<p>
At Nibbly, finding your next favorite recipe is simple and fun! Use the <span class="underlined">Cuisines</span> filter to explore dishes from around the world—perfect for satisfying any craving. Know exactly what you’re looking for? Try the <span class="underlined">Search Bar</span> to type in ingredients or recipe names and get instant results. Or, if you’re just browsing, head to <span class="underlined">All Recipes</span> section to discover curated suggestions that match your mood. 
</p>
<p>
Your next flavor-packed adventure is just a click away—happy cooking!
</p>
</div>

<!-- footer -->
<footer>
  <p class="help-button"><a href="help.php">Need Help?</a></p>
  <p>2024 &copy;. Nibbly</p>
</footer>
</body>
</html>