<?php
session_start();
include 'database.php'; // Database connection

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

// Initialize variables
$recipes = [];
$users_dropdown = [];
$edit_recipe = null;

// Fetch all recipes
$result = $conn->query("SELECT recipes.id, recipes.title, recipes.image, recipes.ingredients, recipes.instructions, users.username 
                        FROM recipes JOIN users ON recipes.user_id = users.id");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $recipes[] = $row;
    }
}

// Fetch users for dropdown
$users_result = $conn->query("SELECT id, username FROM users");
if ($users_result) {
    while ($row = $users_result->fetch_assoc()) {
        $users_dropdown[] = $row;
    }
}

// Handle recipe deletion
if (isset($_POST['delete_recipe'])) {
    $recipe_id = $_POST['recipe_id'] ?? '';
    if (!empty($recipe_id)) {
        $delete_stmt = $conn->prepare("DELETE FROM recipes WHERE id = ?");
        $delete_stmt->bind_param("i", $recipe_id);
        $delete_stmt->execute();
        header("Location: manage_recipes.php");
        exit();
    }
}

// Handle new recipe addition
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_recipe'])) {
    $title = $_POST['title'] ?? '';
    $ingredients = $_POST['ingredients'] ?? '';
    $instructions = $_POST['instructions'] ?? '';
    $user_id = $_POST['user_id'] ?? '';
    $image = '';

    // Validate input
    if (empty($title) || empty($ingredients) || empty($instructions) || empty($user_id)) {
        die("Error: All fields are required, including user selection.");
    }

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image = $target_file;
        } else {
            die("Error uploading image.");
        }
    }

    // Insert new recipe
    $add_stmt = $conn->prepare("INSERT INTO recipes (title, ingredients, instructions, user_id, image) VALUES (?, ?, ?, ?, ?)");
    $add_stmt->bind_param("sssis", $title, $ingredients, $instructions, $user_id, $image);
    $add_stmt->execute();
    header("Location: manage_recipes.php");
    exit();
}

// Handle editing a recipe
if (isset($_GET['edit_id'])) {
    $recipe_id = $_GET['edit_id'];
    $edit_stmt = $conn->prepare("SELECT * FROM recipes WHERE id = ?");
    $edit_stmt->bind_param("i", $recipe_id);
    $edit_stmt->execute();
    $edit_recipe = $edit_stmt->get_result()->fetch_assoc();
}

// Handle updating a recipe
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_recipe'])) {
    $recipe_id = $_POST['recipe_id'];
    $title = $_POST['title'];
    $ingredients = $_POST['ingredients'];
    $instructions = $_POST['instructions'];
    $user_id = $_POST['user_id'];
    $image = $edit_recipe['image'] ?? ''; // Keep the old image by default

    // Validate input
    if (empty($title) || empty($ingredients) || empty($instructions) || empty($user_id)) {
        die("Error: All fields are required, including user selection.");
    }

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image = $target_file;
        } else {
            die("Error uploading image.");
        }
    }

    // Update recipe
    $update_stmt = $conn->prepare("UPDATE recipes SET title = ?, ingredients = ?, instructions = ?, user_id = ?, image = ? WHERE id = ?");
    $update_stmt->bind_param("sssisi", $title, $ingredients, $instructions, $user_id, $image, $recipe_id);
    $update_stmt->execute();
    header("Location: manage_recipes.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Recipes</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>

    <div class="container">
        <h1>Manage Recipes</h1>

        <h2><?php echo $edit_recipe ? "Edit Recipe" : "Add New Recipe"; ?></h2>
        <form method="POST" action="" enctype="multipart/form-data">
            <input type="hidden" name="recipe_id" value="<?php echo $edit_recipe['id'] ?? ''; ?>">
            <input type="text" name="title" required placeholder="Recipe Title" value="<?php echo htmlspecialchars($edit_recipe['title'] ?? ''); ?>">
            <input type="file" name="image" accept="image/*" <?php echo $edit_recipe ? '' : 'required'; ?>>
            <textarea name="ingredients" required placeholder="Ingredients"><?php echo htmlspecialchars($edit_recipe['ingredients'] ?? ''); ?></textarea>
            <textarea name="instructions" required placeholder="Instructions"><?php echo htmlspecialchars($edit_recipe['instructions'] ?? ''); ?></textarea>
            <select name="user_id" required>
                <option value="">Select User</option>
                <?php foreach ($users_dropdown as $user): ?>
                    <option value="<?php echo $user['id']; ?>" 
                        <?php echo isset($edit_recipe['user_id']) && $edit_recipe['user_id'] == $user['id'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($user['username']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <input type="submit" name="<?php echo $edit_recipe ? 'update_recipe' : 'add_recipe'; ?>" value="<?php echo $edit_recipe ? 'Update Recipe' : 'Add Recipe'; ?>">
        </form>

        <h2>Existing Recipes</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Image</th>
                    <th>Ingredients</th>
                    <th>Instructions</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recipes as $recipe): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($recipe['id']); ?></td>
                        <td><?php echo htmlspecialchars($recipe['title']); ?></td>
                        <td>
                            <?php if ($recipe['image']): ?>
                                <img src="<?php echo htmlspecialchars($recipe['image']); ?>" alt="Recipe Image" class="recipe-image">
                            <?php else: ?>
                                No Image
                            <?php endif; ?>
                        </td>
                        <td><?php echo nl2br(htmlspecialchars($recipe['ingredients'])); ?></td>
                        <td><?php echo nl2br(htmlspecialchars($recipe['instructions'])); ?></td>
                        <td class="actions">
                            <form method="POST" action="" style="display:inline;">
                                <input type="hidden" name="recipe_id" value="<?php echo $recipe['id']; ?>">
                                <input type="submit" name="delete_recipe" value="Delete" onclick="return confirm('Are you sure you want to delete this recipe?');">
                            </form>
                            <a href="manage_recipes.php?edit_id=<?php echo $recipe['id']; ?>">Edit</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <a href="admin-dashboard.php" class="back-link">Back to Dashboard</a>
    </div>
</body>
</html>
