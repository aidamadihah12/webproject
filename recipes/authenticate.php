<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
include 'database.php'; // Make sure this file includes the database connection code

// Predefined admin credentials (assuming admin email is used for login)
$admin_email = "admin@example.com"; // Change to your admin email
$admin_password = "password"; // This should ideally be a hashed password but used here as plain text for simplicity

$error = '';

// Handle POST request for authentication
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get inputs
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Check if it's an admin login
    if ($email === $admin_email && $password === $admin_password) {
        $_SESSION['admin_logged_in'] = true; // Set admin session variable
        header("Location: admin-dashboard.php"); // Redirect to admin dashboard
        exit();
    } else {
        // For user login, check the database
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        if (!$stmt) {
            die("Statement preparation failed: " . $conn->error);
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc(); // Fetch user data

            // Verify the user's password
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_logged_in'] = true; // Set session variable for user
                header("Location: index.php"); // Redirect to user dashboard
                exit();
            } else {
                $error = "Invalid login credentials. Wrong password.";
            }
        } else {
            $error = "Invalid login credentials. User not found.";
        }
    }
}

// Check if user or admin is already logged in
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: admin-dashboard.php");
    exit();
} elseif (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true) {
    header("Location: index.php");
    exit();
}
?>

