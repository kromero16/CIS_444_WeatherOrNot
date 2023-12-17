<?php
require_once("../Configs/DB_Config.php");

class UserModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function doesUsernameExist($username) {
        $sql = "SELECT * FROM Users WHERE username = :username";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function createUser($username, $password) {
        $sql = "INSERT INTO Users (username, password) VALUES (:username, :password)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        return $stmt->execute();
    }

}
?>
