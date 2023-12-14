<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Skyward Aviation</title>
</head>
<body>
<?php
if (empty($_GET['username']) || empty($_GET['password'])) {
    exit("<p> You must enter values in all fields! Click your browser's Back button to return to the previous page.</p>");
}
$Username = $_GET['username'];
$Password = $_GET['password'];

// Connecting to the database with PDO
require_once("DB_Config.php");

$TableName = "Users";

$sql = "SELECT * FROM $TableName 
        WHERE username = :username 
        AND password = :password";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':username', $Username);
$stmt->bindParam(':password', $Password);
$stmt->execute();

if (!$row = $stmt->fetch()) {
    echo "Invalid username or password. You will be redirected to the login page in 5 seconds.";
    echo "<script>
        setTimeout(function() {
            window.location.href = 'Login Page.html';
        }, 5000); // 5000 milliseconds = 5 seconds
    </script>";
    exit();
} else {
    // This block executes when the login is successful
    $UserID = $row['UserID'];
}

// Close the connection and free the resources used by the PDO object
$pdo = null;
?>

<h2> Login Successful</h2>
<h3>You will be automatically redirected to Main Page or Update your credentials you will have 8 seconds</h3>
<button type="button"  onclick="location.href='UpdateUser.html';">Update User Info</button>


<!-- Send the User to forecast.html -->
<script>
    setTimeout(function() {
        window.location.href = 'forecast.html?UserID=<?=$UserID?>';
    }, 8000); // 8000 milliseconds = 8 seconds
</script>

</body>
</html>