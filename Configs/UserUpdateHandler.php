<?php
require_once("DB_Config.php");
require_once("../Controllers/UserController.php");
require_once("../Models/UserModel.php");

session_start();

// At the start of UserUpdateHandler.php
error_log('Session User ID: ' . ($userId ?? 'Not Set'));

// Assuming you have the user's ID stored in the session
$userId = $_SESSION['userID'] ?? null;

if (!$userId) {
    // Handle the case where the user ID is not set in the session
    header("Location: ../Views/login.html");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // If it's a GET request, just redirect to the updateuser.html page
    header("Location: ../Views/updateuser.html");
    exit();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle the POST request when the user submits the update form
    $userId = $_POST['userID'] ?? null;
    $newUsername = $_POST['new-username'];
    $newPassword = $_POST['new-password'];
    $confirmPassword = $_POST['confirm-password'];


    $userModel = new UserModel($pdo);
    $userController = new UserController($userModel);

    try {
        if ($userController->updateUserPassword($userId, $newPassword, $confirmPassword)) {
            // Redirect to a success page or the login page on success
            header("Location: ../Views/login.html");
            exit();
        }
    } catch (Exception $e) {
        // Log the exception and redirect to an error page or show an error message
        error_log($e->getMessage());
        // Redirect to the update user page with an error message
        header("Location: ../Views/updateuser.html?error=" . urlencode($e->getMessage()));
        exit();
    }
}
?>
