<?php
// Include database connection
include 'database.php'; 

// Initialize variables
$recipes = [];
$recipe = null;

// Check if a recipe name is passed as a query parameter
if (isset($_GET['name'])) {
    $name = $conn->real_escape_string($_GET['name']);
    $result = $conn->query("SELECT * FROM recipes WHERE title = '$name'");
    
    if ($result && $result->num_rows > 0) {
        $recipe = $result->fetch_assoc();
    }
} else {
    // Fetch all recipes if no specific recipe is selected
    $result = $conn->query("SELECT title, image FROM recipes");

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $recipes[] = $row;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $recipe ? htmlspecialchars($recipe['title']) : 'Recipes'; ?></title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style3.css">
</head>
<body>
    <!-- Navbar -->
    <header>
        <div class="navbar">
            <h1>Cooking Recipes</h1>
            <nav>
                <a href="index.php">Home</a>
                <a href="about.html">About Us</a>
                <a href="recipe.php">Recipes</a>
                <a href="logout.php">Logout</a>
            </nav>
        </div>
    </header>

    <?php if ($recipe): ?>
        <!-- Recipe Details Section -->
        <section class="recipe-detail">
            <h1><?php echo htmlspecialchars($recipe['title']); ?></h1>
            <?php if ($recipe['image']): ?>
                <img src="<?php echo htmlspecialchars($recipe['image']); ?>" alt="Recipe Image" class="recipe-image">
            <?php else: ?>
                <p>No image available</p>
            <?php endif; ?>

            <h2>Ingredients</h2>
            <ul>
                <?php foreach (explode("\n", $recipe['ingredients']) as $ingredient): ?>
                    <li><?php echo htmlspecialchars($ingredient); ?></li>
                <?php endforeach; ?>
            </ul>

            <h2>Instructions</h2>
            <p><?php echo nl2br(htmlspecialchars($recipe['instructions'])); ?></p>
        </section>
    <?php else: ?>
        <!-- Recipes List Section -->
        <section class="recipes">
            <center>
            <h1>Featured Recipes</h1>
            </center>
            <div class="recipe-section">
                <?php foreach ($recipes as $recipe): ?>
                    <div class="recipe-card">
                        <?php if ($recipe['image']): ?>
                            <img src="<?php echo htmlspecialchars($recipe['image']); ?>" alt="Recipe Image">
                        <?php else: ?>
                            <img src="default-image.jpg" alt="Recipe Image">
                        <?php endif; ?>
                        <h2><?php echo htmlspecialchars($recipe['title']); ?></h2>
                        <a href="recipe.php?name=<?php echo urlencode($recipe['title']); ?>">View Recipe</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>

    <footer>
        <p>© 2024 Cooking Recipes. All rights reserved.</p>
    </footer>
</body>
</html>
