<?php

function handleSearch($searchTerm, $conn) {
    if (!empty($searchTerm)) {
        // Update the SQL query to include the cuisine column
        $sql = "SELECT id, recipe_name, recipe_subtitle, cuisine FROM recipes_list 
                WHERE recipe_name LIKE ? OR recipe_subtitle LIKE ? OR cuisine LIKE ?";
        $stmt = $conn->prepare($sql);
        $likeTerm = "%$searchTerm%";
        $stmt->bind_param("sss", $likeTerm, $likeTerm, $likeTerm); // Bind the search term for all 3 conditions
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $id = $row['id'];
                $name = htmlspecialchars($row['recipe_name']);
                $subtitle = htmlspecialchars($row['recipe_subtitle']);
                $cuisine = htmlspecialchars($row['cuisine']); // Get the cuisine column
                $image_path = "images/recipes/{$id}.jpg";

                echo "<a class='recipe-card' href='new-recipe.php?id=$id'>";
                echo "<img src='$image_path' alt='Image of $name'>";
                echo "<div class='recipe-info'>";
                echo "<h3>$name</h3>";
                echo "<p>$subtitle</p>";
                if (!empty($cuisine)) {
                    echo "<p><em>Cuisine: $cuisine</em></p>"; // Optionally show the cuisine type
                }
                echo "</div>";
                echo "</a>";
            }
        } else {
            // Display "Nothing Found" section
            echo '<p class="no-results"></p>';
            echo '<div class="nothing-found">';
            echo '<p class="no-results">Sorry, no results found. Let\'s plate this search differently.</p>';
            echo '</div>';
        }
        $stmt->close();
    } else {
        // Return false to indicate no search was performed
        return false;
    }
}

?>
