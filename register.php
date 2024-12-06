<?php
require 'config.php';

// Function to generate a random salt
function generateSalt($length = 16) {
    return bin2hex(random_bytes($length));
}

// Function to hash the password with a salt
function hashPassword($password, $salt) {
    return hash('sha256', $password . $salt);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extract form data
    $user_name = filter_input(INPUT_POST, 'user_name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    // Generate a salt
    $salt = generateSalt();
    // Hash the password with the salt
    $passwordHash = hashPassword($password, $salt);

    // Include database configuration
    $servername = "localhost";
    $username = "root";
    $dbpassword = "";
    $dbname = "pHailing";

    // Create connection
    $conn = new mysqli($servername, $username, $dbpassword, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if user_name already exist
    $stmt_check = $conn->prepare("SELECT COUNT(*) FROM users WHERE user_name = ? ");
    $stmt_check->bind_param("s", $user_name);
    $stmt_check->execute();
    $stmt_check->bind_result($count);
    $stmt_check->fetch();
    $stmt_check->close();

    if ($count > 0) {
        echo "<script>alert('Username already exists. Registration failed.'); window.location.href='index.php';</script>";
        exit; 
    }
 
    // Prepare and bind parameters to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO users (user_name, email, password_hash, salt) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $user_name, $email, $passwordHash, $salt);

    // Execute the query
    if ($stmt->execute()) {
        // Registration successful
        echo "<script>alert('Registration successful.'); window.location.href='login.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close connection
    $stmt->close();
    $conn->close();

}
?>