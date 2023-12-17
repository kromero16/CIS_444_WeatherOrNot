<?php
require_once("DB_Config.php");
require_once("../Controllers/UserController.php");
require_once("../Models/UserModel.php");

session_start();

// Assuming you have the user's ID stored in the session
$userId = $_SESSION['userID'] ?? null;

if (!$userId) {
    // Handle the case where the user ID is not set in the session
    header("Location: ../Views/login.html");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // If it's a GET request, just redirect to the updateuser.php page
    header("Location: ../Views/updateuser.php");
    exit();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newUsername = $_POST['new-username'] ?? null;
    $newPassword = $_POST['new-password'] ?? null;
    $confirmPassword = $_POST['confirm-password'] ?? null;

    $userModel = new UserModel($pdo);
    $userController = new UserController($userModel);

    try {
        $updateSuccess = false;

        // Update username if provided
        if ($newUsername) {
            $updateSuccess = $userController->updateUsername($userId, $newUsername);
        }

        // Update password if provided
        if ($newPassword) {
            $updateSuccess = $userController->updateUserPassword($userId, $newPassword, $confirmPassword);
        }

        if ($updateSuccess) {
            // Redirect to a success page or the login page on success
            header("Location: ../Views/login.html?update=success");
            exit();
        } else {
            throw new Exception("Update failed.");
        }
    } catch (Exception $e) {
        // Log the exception and redirect to an error page or show an error message
        error_log($e->getMessage());
        // Redirect to the update user page with an error message
        header("Location: ../Views/updateuser.php?error=" . urlencode($e->getMessage()));
        exit();
    }
}
?>
