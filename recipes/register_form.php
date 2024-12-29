<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="class1">
        <div class="container"> <!-- Fixed the "cotainer" typo -->
            <div class="box form-box">
                <h2>Register</h2>
                <form action="register.php" method="POST"> <!-- Specify the action for the registration logic -->
                    <div class="field input">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" autocomplete="off" required> <!-- Changed to type="email" -->
                    </div>

                    <div class="field input">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" autocomplete="off" required>
                    </div>
    
                    <div class="field input">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" autocomplete="off" required>
                    </div>
    
                    <div class="field">
                        <input type="submit" class="btn" name="submit" value="Register" required>
                    </div>
                    <div class="links">
                        Already registered? <a href="login.php">Login here</a>
                    </div>
    
                    <div class="field"> <!-- Added a div for better structure -->
                        <label>
                            <input type="checkbox" name="remember" <?= isset($_POST['remember']) ? 'checked' : '' ?>> Remember me <!-- Fixed checkbox syntax -->
                        </label>
                    </div>
    
                    <!-- Dynamic error message display -->
                    <?php if (!empty($error)): ?>
                    <p style="color: red;"><?= htmlspecialchars($error) ?></p>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
</body>
</html>