<?php
session_start();
if (!isset($_SESSION['userID'])) {
    // Redirect to login page if not logged in
    header('Location: login.html');
    exit();
}
?>

<form action="../Configs/UserUpdateHandler.php" method="post">
    <input type="hidden" name="userID" value="<?php echo $_SESSION['userID']; ?>">
    New Username: <input type="text" name="new-username">
    New Password: <input type="password" name="new-password">
    Confirm Password: <input type="password" name="confirm-password">
    <input type="submit" value="Update">
</form>
