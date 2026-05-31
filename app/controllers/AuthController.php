<?php

require_once "../app/core/Controller.php";
require_once "../app/models/User.php";

class AuthController extends Controller
{

public function login()
{
    if(session_status() === PHP_SESSION_NONE){
        session_start();
    }

    // If already logged in
    if(isset($_SESSION['user_id'])){
        if($_SESSION['role'] === 'admin'){
            header("Location: /evol/public/admin/dashboard");
        }else{
            header("Location: /evol/public/");
        }
        exit;
    }

    if($_SERVER['REQUEST_METHOD'] == "POST")
    {

        $db = new Database();
        $conn = $db->connect();

        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        if(empty($username) || empty($password))
        {
            $error = "All fields are required";
            $this->view("auth/login", ['error'=>$error]);
            return;
        }

        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$user)
        {
            $error = "Incorrect username";
            $this->view("auth/login", ['error'=>$error]);
            return;
        }

        if(!password_verify($password, $user['password']))
        {
            $error = "Incorrect password";
            $this->view("auth/login", ['error'=>$error]);
            return;
        }

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        if($user['role'] === 'admin'){
            header("Location: /evol/public/admin/dashboard");
        }else{
            header("Location: /evol/public/");
        }

        exit;
    }

    $this->view("auth/login");
}



public function register()
{
    if(session_status() === PHP_SESSION_NONE){
        session_start();
    }

    // Prevent logged users from accessing register
    if(isset($_SESSION['user_id'])){
        header("Location: /evol/public/");
        exit;
    }

    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        $db = new Database();
        $conn = $db->connect();

        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        if(empty($name) || empty($email) || empty($username) || empty($password))
        {
            $error = "All fields are required";
            $this->view("auth/register", ['error'=>$error]);
            return;
        }

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);

        if($stmt->rowCount() > 0)
        {
            $error = "Email already registered";
            $this->view("auth/register", ['error'=>$error]);
            return;
        }

        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);

        if($stmt->rowCount() > 0)
        {
            $error = "Username already taken";
            $this->view("auth/register", ['error'=>$error]);
            return;
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare(
            "INSERT INTO users (name,email,username,password)
             VALUES (?,?,?,?)"
        );

        $stmt->execute([$name,$email,$username,$hashedPassword]);

        header("Location: /evol/public/auth/login");
        exit;
    }

    $this->view("auth/register");
}



public function logout()
{
    if(session_status() === PHP_SESSION_NONE){
        session_start();
    }

    $_SESSION = [];

    session_destroy();

    header("Location: /evol/public/auth/login");
    exit;
}



}