<?php
session_start(); // Start the session at the beginning of the script.

require_once("DB_Config.php");

// Check the user input first.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['new-password']) || empty($_POST['confirm-password']) || empty($_POST['new-username'])) {
        exit("<p>You must enter values in all fields! Click your browser's Back button to return to the previous page.</p>");
    } elseif ($_POST['new-password'] != $_POST['confirm-password']) {
        exit("<p>The passwords do not match! Click your browser's Back button to return to the previous page.</p>");
    }
} else {
    // If not POST request, redirect to the login page.
    header("Location: Login Page.html");
    exit();
}

$NewUsername = $_POST['new-username'];
//$NewPassword = password_hash($_POST['new-password'], PASSWORD_DEFAULT); // Hashing the new password.
$NewPassword = $_POST['new-password']; // Hashing the new password.

// Update user data in the database.
$sql = "UPDATE Users SET username = :newusername, password = :newpassword";

try {
    $updateStmt = $pdo->prepare($sql);
    $updateStmt->bindParam(':newusername', $NewUsername);
    $updateStmt->bindParam(':newpassword', $NewPassword);
    $updateStmt->execute();
} catch (PDOException $e) {
    exit("<p>An error occurred: " . $e->getMessage() . "</p>");
}

// Close the connection and free resources.
$pdo = null;

// Redirect to the login page.
header("Location: Login Page.html");
exit();
?>