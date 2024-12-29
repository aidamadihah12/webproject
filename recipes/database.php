<?php
$servername = "localhost"; // Your server name
$username = "root";        // Your MySQL username
$password = "";            // Your MySQL password (usually blank for XAMPP)
$dbname = "recipe";       // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>