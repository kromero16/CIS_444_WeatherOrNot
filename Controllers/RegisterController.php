<?php
require_once("../Models/UserModel.php");

class RegisterController {
    private $userModel;

    public function __construct(UserModel $userModel) {
        $this->userModel = $userModel;
    }

    public function register() {
        // Error handling for empty fields or password mismatch
        if (empty($_POST['password']) || empty($_POST['confirm-password']) || empty($_POST['new-username'])) {
            $error = 'empty-fields';
            header("Location: ../Views/register.html?error=$error");
            exit();
        } else if ($_POST["password"] != $_POST["confirm-password"]) {
            $error = 'password-mismatch';
            header("Location: ../Views/register.html?error=$error");
            exit();
        }

        $username = $_POST['new-username'];
        $password = $_POST['password'];

        // Check if username already exists
        if ($this->userModel->doesUsernameExist($username)) {
            $error = 'username-exists';
            header("Location: ../Views/register.html?error=$error");
            exit();
        }

        // Hash the password before storing it
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Create the user
        if ($this->userModel->createUser($username, $hashedPassword)) {
            // Redirect to login page on successful registration
            header("Location: ../Views/login.html");
            exit();
        } else {
            // Handle registration failure
            $error = 'registration-failed';
            header("Location: ../Views/register.html?error=$error");
            exit();
        }
    }
}

?>
