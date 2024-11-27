<?php
// Database connection parameters
$host = 'localhost';  // Database host (usually 'localhost')
$dbname = 'web_appeal_db';  // Your database name
$username = 'root';  // Database username
$password = '';  // Database password

try {
    // Establish the database connection using PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // If the connection fails, output an error message
    echo "Connection failed: " . $e->getMessage();
    exit();
}
?>
