<?php

require_once "../app/core/Controller.php";
require_once "../app/core/Database.php";

class ProfileController extends Controller
{
    public function index()
    {
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }

        /* LOGIN CHECK */

        if(!isset($_SESSION['user_id']))
        {
            header("Location: /evol/public/auth/login");
            exit;
        }

        $db = new Database();
        $conn = $db->connect();

        $userId = $_SESSION['user_id'];


        /* =========================
           LIKED BOOKS
        ========================= */

        $stmt = $conn->prepare("
            SELECT b.*
            FROM book_likes bl
            JOIN books b
                ON b.id = bl.book_id
            WHERE bl.user_id = ?
            ORDER BY bl.id DESC
        ");

        $stmt->execute([$userId]);

        $likedBooks = $stmt->fetchAll(PDO::FETCH_ASSOC);


        /* =========================
           RECENTLY VIEWED BOOKS
        ========================= */

        $stmt = $conn->prepare("
            SELECT b.*, bv.last_viewed_at
            FROM book_views bv
            JOIN books b
                ON b.id = bv.book_id
            WHERE bv.user_id = ?
            ORDER BY bv.last_viewed_at DESC
            LIMIT 6
        ");

        $stmt->execute([$userId]);

        $recentBooks = $stmt->fetchAll(PDO::FETCH_ASSOC);


        /* =========================
           TOTAL LIKED BOOKS
        ========================= */

        $stmt = $conn->prepare("
            SELECT COUNT(*)
            FROM book_likes
            WHERE user_id = ?
        ");

        $stmt->execute([$userId]);

        $likedCount = $stmt->fetchColumn();


        /* =========================
           TOTAL VIEWED BOOKS
        ========================= */

        $stmt = $conn->prepare("
            SELECT COUNT(*)
            FROM book_views
            WHERE user_id = ?
        ");

        $stmt->execute([$userId]);

        $viewedCount = $stmt->fetchColumn();


        /* =========================
           TOTAL READS / VIEWS
        ========================= */

        $stmt = $conn->prepare("
            SELECT SUM(view_count)
            FROM book_views
            WHERE user_id = ?
        ");

        $stmt->execute([$userId]);

        $totalViews = $stmt->fetchColumn();

        if(!$totalViews){
            $totalViews = 0;
        }


        /* =========================
           FAVORITE GENRE
        ========================= */

        $stmt = $conn->prepare("
            SELECT g.name, COUNT(*) AS total

            FROM book_likes bl

            JOIN book_genres bg
                ON bg.book_id = bl.book_id

            JOIN genres g
                ON g.id = bg.genre_id

            WHERE bl.user_id = ?

            GROUP BY g.id

            ORDER BY total DESC

            LIMIT 1
        ");

        $stmt->execute([$userId]);

        $favGenre = $stmt->fetch(PDO::FETCH_ASSOC);


        /* =========================
           LOAD PROFILE VIEW
        ========================= */

        $this->view("profile/index", [

            "likedBooks" => $likedBooks,

            "recentBooks" => $recentBooks,

            "likedCount" => $likedCount,

            "viewedCount" => $viewedCount,

            "totalViews" => $totalViews,

            "favGenre" => $favGenre

        ]);
    }
}
?>