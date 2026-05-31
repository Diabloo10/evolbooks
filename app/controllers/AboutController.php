<?php
require_once "../app/core/Controller.php";
require_once "../app/core/Database.php";

class AboutController extends Controller
{
    public function index()
    {
        $db = new Database();
        $conn = $db->connect();

        /* TOTAL BOOKS */

        $stmt = $conn->query("
            SELECT COUNT(*) 
            FROM books
        ");

        $totalBooks = $stmt->fetchColumn();


        /* TOTAL USERS */

        $stmt = $conn->query("
            SELECT COUNT(*) 
            FROM users
        ");

        $totalUsers = $stmt->fetchColumn();


        /* TOTAL LIKES */

        $stmt = $conn->query("
            SELECT COUNT(*) 
            FROM book_likes
        ");

        $totalLikes = $stmt->fetchColumn();


        /* TOTAL VIEWS */

        $stmt = $conn->query("
            SELECT COALESCE(SUM(view_count),0)
            FROM book_views
        ");

        $totalViews = $stmt->fetchColumn();


        /* FEATURED BOOK */

        $stmt = $conn->query("
            SELECT 
                b.*,
                COUNT(bl.id) AS total_likes

            FROM books b

            LEFT JOIN book_likes bl
            ON b.id = bl.book_id

            GROUP BY b.id

            ORDER BY total_likes DESC

            LIMIT 1
        ");

        $featuredBook = $stmt->fetch(PDO::FETCH_ASSOC);


        $this->view("about/index", [

            "totalBooks" => $totalBooks,
            "totalUsers" => $totalUsers,
            "totalLikes" => $totalLikes,
            "totalViews" => $totalViews,
            "featuredBook" => $featuredBook
        ]);
    }
}