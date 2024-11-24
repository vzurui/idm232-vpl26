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
  <li><a href="all-recipes.html">All Recipes</a></li>
</ul>
  </header>

<h2>Welcome!</h2>
<p>
<?php 
		echo "hello i am trying PHP for the first time!"
		?>
		Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
<img class="placeholder-image" src="images/elementor-placeholder-image.webp" alt="gray-placeholder-image">
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
<hr class="solid">

<footer>
  <p><a href="no-search.html">No Search</a></p>
  <p><a href="search-found.html">Search</a></p>
</footer>
</body>
</html>