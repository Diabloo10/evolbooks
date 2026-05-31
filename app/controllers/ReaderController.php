<?php

require_once "../app/core/Controller.php";
require_once "../app/core/Database.php";

class ReaderController extends Controller
{
    public function index($id)
    {
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }

        if(!isset($_SESSION['user_id']))
        {
            header("Location: /evol/public/auth/login");
            exit;
        }

        $db = new Database();
        $conn = $db->connect();

        $stmt = $conn->prepare("
            SELECT *
            FROM books
            WHERE id = ?
        ");

        $stmt->execute([$id]);

        $book = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$book){
            die("Book not found");
        }

        $this->view("reader/index", [
            "book" => $book
        ]);
    }
}