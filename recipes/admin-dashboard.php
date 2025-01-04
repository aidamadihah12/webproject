<?php
session_start();
include 'database.php'; // Your database connection

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

// Fetch users from the database
$users = [];
$result = $conn->query("SELECT * FROM users");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

// Fetch total users, recipes, and admins dynamically
$totalUsersQuery = $conn->query("SELECT COUNT(*) AS total FROM users");
$totalUsers = $totalUsersQuery->fetch_assoc()['total'];

$totalRecipesQuery = $conn->query("SELECT COUNT(*) AS total FROM recipes");
$totalRecipes = $totalRecipesQuery->fetch_assoc()['total'];

$totalAdminsQuery = $conn->query("SELECT COUNT(*) AS total FROM users WHERE role = 'admin'");
$totalAdmins = $totalAdminsQuery->fetch_assoc()['total'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="style1.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>

<header class="navbar">
    <div class="logo">Admin </div>
    <nav>
        <a href="admin-dashboard.php">Home</a>
        <a href="manage_users.php">Manage Users</a>
        <a href="manage_recipes.php">Manage Recipes</a>
        <a href="admin-logout.php">Logout</a>
    </nav>
</header>

<div class="container">

    <h1>Art Of Cooking</h1>

    <div class="stats">
        <div class="card">
            <h3>Total Users</h3>
            <p><?php echo $totalUsers; ?></p>
        </div>
        <div class="card">
            <h3>Total Recipes</h3>
            <p><?php echo $totalRecipes; ?></p>
        </div>
        <div class="card">
            <h3>Total Admins</h3>
            <p><?php echo $totalAdmins; ?></p>
        </div>
    </div>

    <div>
        <h2>Recent Activities</h2>
        <div class="recent-activities">
            <ul>
                <li>Admin add new recipe</li>
                <li>farah add new recipe </li>
                <li>Recipe "Nasi lemak" was published.</li>
            </ul>
        </div>
    </div>

    <h2>Registered Users</h2>
    <table>
        <thead>
            <tr>
                <th>User ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo htmlspecialchars($user['id']); ?></td>
                <td><?php echo htmlspecialchars($user['username']); ?></td>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
                <td><?php echo htmlspecialchars($user['role']); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="chart-container" style="margin-top: 50px;">
        <canvas id="userChart"></canvas>
    </div>

</div>

<script>
    const ctx = document.getElementById('userChart').getContext('2d');
    const userChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Total Users', 'Total Recipes', 'Total Admins'],
            datasets: [{
                label: 'Counts',
                data: [<?php echo $totalUsers; ?>, <?php echo $totalRecipes; ?>, <?php echo $totalAdmins; ?>],
                backgroundColor: ['#FF5733', '#4CAF50', '#f39c12'],
                borderColor: ['#FF5733', '#4CAF50', '#f39c12'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        });
</script>

<div>
    <center>
        <section class="admin-dashboard">
            <div class="admin-dashboard-images">
                <img src="images/dish-3.jpg" style="width: 150px; height: auto;">
                <img src="images/img.jpg" style="width: 150px; height: auto;">
                <img src="images/dish-1.jpg" style="width: 150px; height: auto;">
                <img src="images/dish-2.jpg" style="width: 150px; height: auto;">
                <img src="images/Meatballs.jpg" style="width: 150px; height: auto;">
                <img src="images/Tortilla-Omelette.jpg" style="width: 150px; height: auto;">
                <img src="images/dish-4.jpg" style="width: 150px; height: auto;">
                <img src="images/pasta.webp" style="width: 150px; height: auto;">
            </div>
        </section>
    </center>
</div>

<style>
    .admin-dashboard-images img {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .admin-dashboard-images img:hover {
        transform: scale(1.1); /* Slightly enlarges the image */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3); /* Adds a shadow for emphasis */
    }
</style>

<footer>
    <p>&copy; <?php echo date("Y"); ?> Cooking Recipes</p>
</footer>

</body>
</html>
