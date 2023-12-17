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
}
?>