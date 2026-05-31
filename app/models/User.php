<?php

require_once "../app/core/Database.php";

class User
{
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function register($name, $email, $username, $password)
    {
        $query = "INSERT INTO users (name,email,username,password) VALUES (:name,:email,:username,:password)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":name",$name);
        $stmt->bindParam(":email",$email);
        $stmt->bindParam(":username",$username);
        $stmt->bindParam(":password",$password);

        return $stmt->execute();
    }

    public function login($username)
    {
        $query = "SELECT * FROM users WHERE username = :username LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":username",$username);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}