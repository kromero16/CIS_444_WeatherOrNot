<?php
require_once("DB_Config.php");
require_once("../Models/UserModel.php");
require_once("../Controllers/RegisterController.php");

// Initialize the model with the database connection
$userModel = new UserModel($pdo);

// Initialize the controller with the model
$registerController = new RegisterController($userModel);

// Handle the registration process
$registerController->register();
?>
