<?php
// Start session to clear
session_start();
session_destroy(); // Destroy the session
header("Location: login.php"); // Redirect to the login page
exit();