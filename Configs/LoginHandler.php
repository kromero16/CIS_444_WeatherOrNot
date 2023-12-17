<?php
require_once("DB_Config.php");
require_once("../Controllers/LoginController.php");
require_once("../Models/UserModel.php");

$userModel = new UserModel($pdo);
$loginController = new LoginController($userModel);

if (isset($_POST['username']) && isset($_POST['password'])) {
    $loginController->login($_POST['username'], $_POST['password']);
}
