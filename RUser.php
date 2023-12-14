<?php
// Check the user input first
if (empty($_POST['password']) || empty($_POST['confirm-password']) || empty($_POST['new-username'])) {
    exit("<p>You must enter values in all fields! Click your browser's Back button to return to the previous page.</p>");
} else if ($_POST["password"] != $_POST["confirm-password"]) {
    exit("<p>The passwords do not match! Click your browser's Back button to return to the previous page.</p>");
}

// Connecting to the database with PDO
require_once("DB_Config.php");

$TableName = "Users";
$Username = $_POST['new-username'];
$Password = $_POST['password'];

// Check if the username already exists
$sql = "SELECT * FROM $TableName WHERE username = :username";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':username', $Username);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    echo "<p>The Username address you entered is already registered! You will be redirected in 5 seconds.</p>";
    echo "<script>
        setTimeout(function() {
            window.location.href = 'register.html';
        }, 5000); // 5000 milliseconds = 5 seconds
    </script>";
    exit();
}

// Insert into new user data to the table
$sql = "INSERT INTO $TableName (username, password) VALUES (:username, :password)";
$insertStmt = $pdo->prepare($sql);
$insertStmt->bindParam(':username', $Username);
$insertStmt->bindParam(':password', $Password);
$insertStmt->execute();

// Retrieve the UserID
$sql = "SELECT UserID FROM $TableName WHERE username = :username";
$query = $pdo->prepare($sql);
$query->bindParam(':username', $Username);
$query->execute();
$row = $query->fetch();
$UserID = $row['UserID'];

// Close the connection and free resources
$pdo = null;

// Redirect to the login page
header("Location: Login Page.html");
exit();
?>