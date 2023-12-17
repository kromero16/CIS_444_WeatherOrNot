<?php
require_once("../Models/UserModel.php");

class LoginController {
    private $userModel;

    public function __construct(UserModel $userModel) {
        $this->userModel = $userModel;
    }

    public function login($username, $password) {
        if ($this->userModel->validateCredentials($username, $password)) {
            // Login successful, redirect to forecast page with user ID
            $userId = $this->userModel->getUserId($username);
            header("Location: ../Views/forecast.html?UserID={$userId}");
            exit();
        } else {
            // Invalid credentials, redirect to login with error
            header("Location: ../Views/login.html?error=invalid");
            exit();
        }
    }
}
?>