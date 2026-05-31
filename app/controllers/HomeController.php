<?php

require_once "../app/core/Controller.php";
require_once "../app/core/Database.php";

class HomeController extends Controller
{
    public function index()
    {
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }

        $db = new Database();
        $conn = $db->connect();

        /* =========================
           BOOKS WITH:
           - genres
           - likes
           - views
        ========================= */

        $stmt = $conn->query("
            SELECT 
                b.*,

                GROUP_CONCAT(DISTINCT g.name) AS genres,

                COUNT(DISTINCT bl.id) AS like_count,

                COALESCE(SUM(DISTINCT bv.view_count),0) AS view_count

            FROM books b

            LEFT JOIN book_genres bg
            ON b.id = bg.book_id

            LEFT JOIN genres g
            ON g.id = bg.genre_id

            LEFT JOIN book_likes bl
            ON b.id = bl.book_id

            LEFT JOIN book_views bv
            ON b.id = bv.book_id

            GROUP BY b.id

            ORDER BY b.created_at DESC

            LIMIT 8
        ");

        $books = $stmt->fetchAll(PDO::FETCH_ASSOC);


        /* =========================
           FEATURED BOOK
           MOST LIKED
        ========================= */

        $stmt = $conn->query("
            SELECT 
                b.*,

                COUNT(DISTINCT bl.id) AS like_count,

                COALESCE(SUM(DISTINCT bv.view_count),0) AS view_count,

                GROUP_CONCAT(DISTINCT g.name) AS genres

            FROM books b

            LEFT JOIN book_likes bl
            ON b.id = bl.book_id

            LEFT JOIN book_views bv
            ON b.id = bv.book_id

            LEFT JOIN book_genres bg
            ON b.id = bg.book_id

            LEFT JOIN genres g
            ON g.id = bg.genre_id

            GROUP BY b.id

            ORDER BY like_count DESC

            LIMIT 1
        ");

        $featured = $stmt->fetch(PDO::FETCH_ASSOC);


        $this->view("home/index", [
            "books" => $books,
            "featured" => $featured
        ]);
    }
}