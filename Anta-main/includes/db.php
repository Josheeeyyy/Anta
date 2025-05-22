<?php
// Database configuration
$host = 'localhost';
$dbname = 'anta_store';
$username = 'root';
$password = '';

// Create DSN
$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

// PDO options for better error handling and performance
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,  // Throw exceptions on errors
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,        // Fetch associative arrays
    PDO::ATTR_EMULATE_PREPARES   => false,                   // Use real prepared statements
];

try {
    // Create PDO instance
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    // Log error (optional) and exit safely
    error_log("Database connection error: " . $e->getMessage()); // Don't show full error to users in production
    exit('Database connection failed. Please try again later.');
}
?>
