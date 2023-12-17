<?php
require_once("../Models/UserModel.php");

class UserController {
    private $userModel;

    public function __construct(UserModel $userModel) {
        $this->userModel = $userModel;
    }

    public function updateUserPassword($userId, $newPassword, $confirmPassword) {
        if ($newPassword !== $confirmPassword) {
            throw new Exception("Passwords do not match.");
        }

        return $this->userModel->updateUserPassword($userId, $newPassword);
    }

    public function updateUsername($userId, $newUsername) {
        if (!$newUsername) {
            throw new Exception("Username cannot be empty.");
        }

        // Check if the new username already exists
        if ($this->userModel->doesUsernameExist($newUsername)) {
            throw new Exception("Username already exists.");
        }

        return $this->userModel->updateUsername($userId, $newUsername);
    }
}
?>