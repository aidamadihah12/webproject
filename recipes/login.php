<?php
include 'authenticate.php'; // This handles session management and authentication logic
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Login</title>
</head>
<body>
    <div class="class1">
        <div class="container">
            <div class="box form-box">
                <h2>Login Form</h2>
                <form action="login.php" method="POST"> <!-- change action to the current page -->
                    <div class="field input">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" autocomplete="off" required>
                    </div>

                    <div class="field input">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" autocomplete="off" required>
                    </div>

                    <div class="field">
                        <input type="submit" class="btn" name="submit" value="Login">
                    </div>
                    <div class="links">
                        Don't have an account? <a href="register_form.php">Sign Up Now</a>
                    </div>

                    <div class="field">
                        <label>
                            <input type="checkbox" name="remember" <?= isset($_POST['remember']) ? 'checked' : '' ?>> Remember me
                        </label>
                    </div>

                    <!-- Display the error message dynamically -->
                    <?php if (!empty($error)): ?>
                    <p style="color: red;"><?= htmlspecialchars($error) ?></p>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
</body>
</html>