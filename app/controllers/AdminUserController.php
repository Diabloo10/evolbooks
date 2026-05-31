<?php

require_once "../app/core/Controller.php";
require_once "../app/core/Database.php";

class AdminUserController extends Controller
{
    /* SHOW USERS */
    public function index()
    {
        session_start();

        /* ADMIN ONLY */
        if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
            header("Location: /evol/public/");
            exit;
        }

        $db = new Database();
        $conn = $db->connect();

        $stmt = $conn->query("
            SELECT id, name, username, email, role
            FROM users
            ORDER BY created_at DESC
        ");

        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->view("admin/users/index", [
            "users"=>$users
        ]);
    }

    /* DELETE USER */
    public function delete($id)
    {
        session_start();

        if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
            header("Location: /evol/public/");
            exit;
        }

        $db = new Database();
        $conn = $db->connect();

        /* ❌ PREVENT ADMIN DELETE */
        $stmt = $conn->prepare("
            SELECT role FROM users WHERE id = ?
        ");

        $stmt->execute([$id]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if($user && $user['role'] == 'admin'){
            header("Location: /evol/public/adminUser");
            exit;
        }

        /* DELETE USER */
        $stmt = $conn->prepare("
            DELETE FROM users WHERE id = ?
        ");

        $stmt->execute([$id]);

        header("Location: /evol/public/adminUser");
        exit;
    }
}