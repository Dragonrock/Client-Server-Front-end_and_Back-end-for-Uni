<?php
$host = 'localhost';
$port = '5432'; // Change this to the port number your PostgreSQL server is running on
$dbname = 'projectDB';
$username = 'postgres';
$password = '  ';

try {
    $conn = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die();
}

return $conn; // Return the database connection
?>