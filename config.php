<?php
// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "pHailing";  

// // Create connection
// $conn = new mysqli($servername, $username, $password);

// // Check connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

// Get the JAWSDB_URL from Heroku environment variable
$db_url = parse_url(getenv('JAWSDB_URL'));

// Extract the database connection details
$servername = $db_url['host']; // Database host
$username = $db_url['user'];   // Database username
$password = $db_url['pass'];   // Database password
$dbname = ltrim($db_url['path'], '/'); // Database name (remove the leading "/")

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

// else {
//     echo "Connected successfully";
// }

// Create database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    // Database created
} else {
    die("Error creating database: " . $conn->error);
}

// Select the database
$conn->select_db($dbname);

// Create users table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_name VARCHAR(255) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,  
    password_hash VARCHAR(255) NOT NULL,
    salt VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$conn->query($sql);  

// Create hazards table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS hazards (
    id INT AUTO_INCREMENT PRIMARY KEY,
    staff_name VARCHAR(255) NOT NULL,
    position VARCHAR(255) NOT NULL,
    activity_category VARCHAR(255) NOT NULL,
    hazard_category VARCHAR(255) NOT NULL,
    hazard VARCHAR(255) NOT NULL,    
    likelihood INT NOT NULL,
    severity INT NOT NULL,
    risk_level INT NOT NULL,
    control_measures TEXT,    
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    action TEXT,
    existing_control_measures TEXT,
    user_name VARCHAR(255), 
    FOREIGN KEY (user_name) REFERENCES users(user_name)  
)";

if ($conn->query($sql) === TRUE) {
    // Table created
} else {
    die("Error creating table: " . $conn->error);
}

// Do not close the connection here
?>
