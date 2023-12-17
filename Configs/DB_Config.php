<?php
$host = "localhost";
$dbName = "WeatherOrNot_DB";
$user = "root";
$pass = "root";

try {
    // Connect to MySQL without a specific database
    $pdo = new PDO("mysql:host=$host", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the database exists
    $dbExists = $pdo->query("SELECT COUNT(*) FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$dbName'")->fetchColumn();

    if (!$dbExists) {
        // Create the database if it doesn't exist
        $pdo->exec("CREATE DATABASE `$dbName`");
        $pdo->exec("USE `$dbName`");
        // You can also add here any table creation or initial setup

    } else {
        // If the database exists, just use it
        $pdo->exec("USE `$dbName`");
    }

} catch (PDOException $e) {
    die("DB ERROR: ". $e->getMessage());
}
?>
