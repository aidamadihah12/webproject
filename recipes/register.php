<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capturing input safely
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $username = filter_var(trim($_POST['username']), FILTER_SANITIZE_STRING); // Change `name` to `username`
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Secure hashing

    // Validate email and username
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }

    // Database connection
    $conn = new mysqli("localhost", "root", "", "recipe");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL statement without the role
    $stmt = $conn->prepare("INSERT INTO users (email, username, password) VALUES (?, ?, ?)");
    if ($stmt) {
        // Bind parameters (role removed)
        $stmt->bind_param("sss", $email, $username, $password);

        // Execute the statement
        if ($stmt->execute()) {
            echo "Registration successful! <a href='login.php'>Login here</a>";
        } else {
            echo "Error during registration: " . htmlspecialchars($stmt->error);
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error preparing statement: " . htmlspecialchars($conn->error);
    }

    // Close the database connection
    $conn->close();
}
?>