<?php
$servername = "localhost";
$username = "root";
$password = "Pennabadi@95";
$dbname = "portfolio";

try {
    $conn = new mysqli($servername, $username, $password);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // Create database
    $sql = "CREATE DATABASE IF NOT EXISTS $dbname";
    if ($conn->query($sql) === TRUE) {
        echo "Database created successfully\n";
    }
    
    // Select database
    $conn->select_db($dbname);
    
    // Create table
    $sql = "CREATE TABLE IF NOT EXISTS contacts (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL,
        phone VARCHAR(20) NOT NULL,
        message TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    if ($conn->query($sql) === TRUE) {
        echo "Table created successfully\n";
    }
    
    $conn->close();
    echo "Database setup completed successfully!";
    
} catch (Exception $e) {
    echo "An error occurred during setup. Please check your database configuration.";
}
?> 