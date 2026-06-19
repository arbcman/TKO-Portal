<?php
// db.php - Secure database connection file

$host    = 'localhost';
$db_name = 'TKO-Portal_db';
$username = 'root';
$password = ''; // Default XAMPP MySQL password is empty

try {
    // Create a new PDO connection instance
    $pdo = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8mb4", $username, $password);
    
    // Set error mode to exception so we can catch database errors easily
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Set default fetch mode to associative array (makes data easier to read in loops)
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // If the connection fails, stop execution and show the error message
    die("Database Connection Error: " . $e->getMessage());
}
?>