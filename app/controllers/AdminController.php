<?php

require_once "../app/core/Controller.php";
require_once "../app/core/Database.php";

class AdminController extends Controller
{
    public function dashboard()
    {
        Middleware::admin();

        $db = new Database();
        $conn = $db->connect();

        /* =========================
           PAGINATION
        ========================= */

        $page =
        isset($_GET['page'])
        ? (int)$_GET['page']
        : 1;

        if($page < 1){
            $page = 1;
        }

        $limit = 5;

        $offset = ($page - 1) * $limit;


        /* =========================
           TOTAL BOOKS
        ========================= */

        $stmt = $conn->query("
            SELECT COUNT(*) FROM books
        ");

        $totalBooks =
        $stmt->fetchColumn();


        /* =========================
           TOTAL USERS
        ========================= */

        $stmt = $conn->query("
            SELECT COUNT(*) FROM users
        ");

        $totalUsers =
        $stmt->fetchColumn();


        /* =========================
           TOTAL LIKES
        ========================= */

        $stmt = $conn->query("
            SELECT COUNT(*) FROM book_likes
        ");

        $totalLikes =
        $stmt->fetchColumn();


        /* =========================
           TOTAL VIEWS
        ========================= */

        $stmt = $conn->query("
            SELECT COALESCE(SUM(view_count),0)
            FROM book_views
        ");

        $totalViews =
        $stmt->fetchColumn();


        /* =========================
           TOTAL CONTACTS
        ========================= */

        $stmt = $conn->query("
            SELECT COUNT(*) FROM contacts
        ");

        $totalMessages =
        $stmt->fetchColumn();


        /* =========================
           TOTAL TRENDING BOOKS
        ========================= */

        $stmt = $conn->query("
            SELECT COUNT(*) FROM books
        ");

        $totalTrendingBooks =
        $stmt->fetchColumn();

        $totalPages =
        ceil($totalTrendingBooks / $limit);


        /* =========================
           TRENDING BOOKS
        ========================= */

        $stmt = $conn->query("
            SELECT
                b.*,

                COUNT(DISTINCT bl.id)
                AS like_count,

                COALESCE(
                    SUM(DISTINCT bv.view_count),
                    0
                ) AS view_count

            FROM books b

            LEFT JOIN book_likes bl
            ON b.id = bl.book_id

            LEFT JOIN book_views bv
            ON b.id = bv.book_id

            GROUP BY b.id

            ORDER BY view_count DESC

            LIMIT $limit OFFSET $offset
        ");

        $trendingBooks =
        $stmt->fetchAll(PDO::FETCH_ASSOC);


        /* =========================
           RECENT USERS
        ========================= */

        $stmt = $conn->query("
            SELECT *
            FROM users
            ORDER BY id DESC
            LIMIT 8
        ");

        $recentUsers =
        $stmt->fetchAll(PDO::FETCH_ASSOC);


        /* =========================
           RECENT CONTACTS
        ========================= */

        $stmt = $conn->query("
           SELECT 
            contacts.*,
            users.name,
            users.email

        FROM contacts

        LEFT JOIN users
        ON contacts.user_id = users.id

        ORDER BY contacts.id DESC
        LIMIT 5
        ");

        $contacts =
        $stmt->fetchAll(PDO::FETCH_ASSOC);


        /* =========================
           TOP VIEWED BOOKS CHART
        ========================= */

        $stmt = $conn->query("
            SELECT 
                b.title,

                COALESCE(
                    SUM(bv.view_count),
                    0
                ) AS total_views

            FROM books b

            LEFT JOIN book_views bv
            ON b.id = bv.book_id

            GROUP BY b.id

            ORDER BY total_views DESC

            LIMIT 5
        ");

        $topViewedBooks =
        $stmt->fetchAll(PDO::FETCH_ASSOC);


        /* =========================
           TOP LIKED BOOKS CHART
        ========================= */

        $stmt = $conn->query("
            SELECT 
                b.title,

                COUNT(bl.id)
                AS total_likes

            FROM books b

            LEFT JOIN book_likes bl
            ON b.id = bl.book_id

            GROUP BY b.id

            ORDER BY total_likes DESC

            LIMIT 5
        ");

        $topLikedBooks =
        $stmt->fetchAll(PDO::FETCH_ASSOC);


        /* =========================
           LOAD VIEW
        ========================= */

        $this->view("admin/dashboard", [

            "totalBooks" => $totalBooks,
            "totalUsers" => $totalUsers,
            "totalLikes" => $totalLikes,
            "totalViews" => $totalViews,
            "totalMessages" => $totalMessages,

            "trendingBooks" => $trendingBooks,
            "recentUsers" => $recentUsers,
            "contacts" => $contacts,

            "topViewedBooks" => $topViewedBooks,
            "topLikedBooks" => $topLikedBooks,

            "page" => $page,
            "totalPages" => $totalPages
        ]);
    }
}