<?php
require_once("../Configs/DB_Config.php");

//These DB calls need exception handling to avoid leaking DB details

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

    public function validateCredentials($username, $password) {
        $sql = "SELECT * FROM Users WHERE username = :username";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        
        if ($stmt->rowCount() == 1) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            return password_verify($password, $user['password']); // Verify the password against the hash
        }
        
        return false; // If the user doesn't exist or multiple users returned
    }

    public function getUserId($username) {
        $sql = "SELECT UserID FROM Users WHERE username = :username"; // Assuming 'id' is the column name for user ID
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        
        if ($stmt->rowCount() == 1) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            return $user['UserID']; // Return the user ID
        }
        
        return null; // If the user doesn't exist or an error occurred
    }

    public function updateUserPassword($userId, $newPassword) {
        $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
        $sql = "UPDATE Users SET password = :newPassword WHERE id = :userId";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':newPassword', $newPasswordHash);
        $stmt->bindParam(':userId', $userId);
        return $stmt->execute();
    }

}

?>
