<?php
// Include database connection
include 'database.php'; 

// Get the recipe name from the URL parameter
$recipe_name = isset($_GET['name']) ? $_GET['name'] : '';

// Fetch the recipe details from the database
$recipe = null;
if ($recipe_name) {
    $stmt = $conn->prepare("SELECT title, image, ingredients, instructions FROM recipes WHERE title = ?");
    $stmt->bind_param("s", $recipe_name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $recipe = $result->fetch_assoc();
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Details</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <div class="navbar">
            <h1 class="logo">Art Of Cooking</h1>
            <nav>
                <a href="index.php">Home</a>
                <a href="about.html">About Us</a>
                <a href="recipe.php">Recipes</a>
                <a href="logout.php">Logout</a>
            </nav>
        </div>
    </header>

        <!-- Hero Section -->
        <section class="hero">
        <div class="hero-text">
            <h1>Welcome to our Recipe Collection!</h1>
            <p>Search mouth-watering recipes to satisfy your cravings</p>
            <a href="about.html" class="btn">About Us</a>
        </div>
    </section>
    <center>
    <h2 class="class2 section-title">Recipe Categories</h2>
    </center>
    <section class="class2 recipe-section">

        <div class="class2 grid-container">
            <!-- Quick & Easy Card -->
            <div class="class2 card">
                <img src="images/recipe-quick.jpg" alt="Quick & Easy Recipes" class="class2">
                <div class="class2 card-content">
                    <h3 class="class2">Quick & Easy</h3>
                    <p class="class2">Delicious meals ready in under 30 minutes for your busy schedule.</p>
                </div>
            </div>

            <!-- Healthy Options Card -->
            <div class="class2 card">
                <img src="images/dish-2.jpg" alt="Healthy Recipes" class="class2">
                <div class="class2 card-content">
                    <h3 class="class2">Healthy Options</h3>
                    <p class="class2">Nutritious meals that are easy to prepare and good for your body.</p>
                </div>
            </div>

            <!-- Comfort Food Card -->
            <div class="class2 card">
                <img src="images/dish-3.jpg" alt="Comfort Food" class="class2">
                <div class="class2 card-content">
                    <h3 class="class2">Comfort Food</h3>
                    <p class="class2">Wholesome, filling dishes that will make you feel right at home.</p>
                </div>
            </div>

            <!-- Special Occasions Card -->
            <div class="class2 card">
                <img src="images/dish-4.jpg" alt="Special Occasions Recipes" class="class2">
                <div class="class2 card-content">
                    <h3 class="class2">Special Occasions</h3>
                    <p class="class2">Perfect recipes for birthdays, holidays, and other celebrations.</p>
                </div>
            </div>

            <center>
                <h2 class="class2 section-title">COOKING SKILLS</h2>
            </center>
            <!-- Types of Recipes -->
            <div class="class2 card">
                <img src="images/type.png" alt="Comfort Food" class="class2">
                <div class="class2 card-content">
                    <h3 class="class2">Types of Recipes</h3>
                    <ul>
                        <li><strong>Quick & Easy Recipes:</strong> For busy people who want a delicious meal in under 30 minutes.</li>
                        <li><strong>Healthy Options:</strong> Recipes for those looking to maintain a balanced diet.</li>
                        <li><strong>Comfort Food:</strong> Dishes that bring warmth and nostalgia.</li>
                        <li><strong>Special Occasion Recipes:</strong> Perfect for celebrations like birthdays, anniversaries, or holidays.</li>
                    </ul>
                </div>
            </div>

             <!-- Essential Kitchen Tools  -->
             <div class="class2 card">
                <img src="images/tools.jpg" alt="Comfort Food" class="class2">
                <div class="class2 card-content">
                    <h3 class="class2">Essential Kitchen Tools </h3>
                    <ul>
                        <li>Sharp knives, cutting boards, measuring cups/spoons, and mixing bowls.</li>
                        <li>Specialty tools for baking, grilling, or making pasta.</li>
                    </ul>
                </div>
            </div>

            <!-- Ingredient Substitutions  -->
            <div class="class2 card">
                <img src="images/ingredient.jpg" alt="Comfort Food" class="class2">
                <div class="class2 card-content">
                    <h3 class="class2">Ingredient Substitutions</h3>
                    <ul>
                        <li>Replace heavy cream with coconut milk for a dairy-free option.</li>
                        <li>Use flaxseed meal instead of eggs for vegan recipes.</li>
                        <li>Swap sugar for honey, maple syrup, or stevia for healthier sweetening.</li>
                </div>
            </div>

             <!-- Cooking Techniques  -->
            <div class="class2 card">
                <img src="images/img.jpg" alt="Comfort Food" class="class2">
                <div class="class2 card-content">
                    <h3 class="class2">Cooking </h3>
                    <ul>
                        <li><strong>Sautéing:</strong> Quickly cooking food in a small amount of oil over medium to high heat.</li>
                        <li><strong>Baking:</strong> Cooking food using dry heat, usually in an oven.</li>
                        <li><strong>Boiling:</strong> Cooking food in boiling water or other liquids to soften ingredients or cook them thoroughly.</li>
                        <li><strong>Grilling:</strong> Cooking food on a grill or open flame to create a smoky, charred flavor.</li>
                        <li><strong>Steaming:</strong> Using steam to cook food, retaining nutrients and moisture, ideal for vegetables and fish.</li>
                        <li><strong>Blending:</strong> Combining ingredients into a smooth consistency, common in soups and smoothies.</li>
                        <li><strong>Marinating:</strong> Soaking food in a seasoned liquid to enhance flavor and tenderness.</li>
                    </ul>
                </div>
            </div>

            <!--Good Portion -->
            <div class="class2 card">
                <img src="images/portion.jpg" alt="Comfort Food" class="class2">
                <div class="class2 card-content">
                    <h3 class="class2">Good Portion</h3>
                    <ul>
                        <li><strong>Individual Serving Size:</strong> Indicates the recommended quantity per person, e.g., one bowl of soup or one slice of pizza.</li>
                        <li><strong>Scaling Recipes:</strong> Adjusting the recipe for the number of servings, e.g., doubling the recipe for a family gathering or halving it for personal use.</li>
                        <li><strong>Nutritional Balance:</strong> Recipes often cater to balanced portions, including carbohydrates, proteins, and fats.</li>
                        <li><strong>Healthy Eating Habits:</strong> Encourages appropriate portions to avoid overeating while still providing satisfaction.</li>
                    </ul>
                </div>
            </div>

            <!--Food Pyramid -->
            <div class="class2 card">
                <img src="images/pyramid.jpg" alt="Comfort Food" class="class2">
                <div class="class2 card-content">
                    <h3 class="class2">Food Pyramid</h3>
                    <ul>
                        <li><strong>Bottom Level:</strong> Carbohydrates like rice, bread, or pasta—serve as the primary source of energy. Recipes often use these as a base.</li>
                        <li><strong>Second Level:</strong> Fruits and vegetables—rich in vitamins, minerals, and fiber. A recipe might include salads, stir-fried vegetables, or smoothies.</li>
                        <li><strong>Third Level:</strong> Protein sources like meat, fish, eggs, nuts, or legumes. Recipes balance plant-based and animal-based proteins.</li>
                        <li><strong>Top Level:</strong> Fats, oils, and sugars—used sparingly. Recipes include healthy fats like olive oil, and limit added sugar to promote health.</li>
                     </ul>
                        <p>Integrating the food pyramid ensures recipes promote well-rounded and nutritious meals.</p>
                </div>
            </div>

            <center>
                <h2 class="class2 section-title">COOKING TECHNIQUE</h2>
            </center>
        </div>
    </div>
</section>


    <footer>
        <p>&copy; 2024 Cooking Recipes</p>
    </footer>



    <style>
        body.class2 {
    font-family: 'Roboto', sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f9;
    color: #333;
}

.class2.recipe-section {
    padding: 60px 20px;
}

.class2.container {
    max-width: 1200px;
    margin: 0 auto;
    text-align: center;
}

.class2.section-title {
    font-size: 2.5em;
    color: #333;
    font-weight: bold;
    margin-bottom: 40px;
}

.class2.grid-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 20px;
}

.class2.card {
    background: #fff;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.class2.card:hover {
    transform: translateY(-10px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
}

.class2.card img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.class2.card-content {
    padding: 20px;
}

.class2.card-content h3 {
    font-size: 1.8em;
    color: #333;
    margin-bottom: 15px;
}

.class2.card-content p {
    font-size: 1em;
    color: #555;
    line-height: 1.5;
}
    </style>
</body>
</html>
