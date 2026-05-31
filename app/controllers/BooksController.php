
<?php 
class BooksController extends Controller
{

public function index()
{

Middleware::auth();

$db = new Database();
$conn = $db->connect();

$stmt = $conn->query("SELECT * FROM books ORDER BY created_at DESC");

$books = $stmt->fetchAll(PDO::FETCH_ASSOC);

$this->view("books/index", ["books"=>$books]);

}

public function show($id)
{
    if(session_status() === PHP_SESSION_NONE){
        session_start();
    }

    $db = new Database();
    $conn = $db->connect();

    /* 🔥 TRACK VIEW */

    if(isset($_SESSION['user_id']))
{
    $stmt = $conn->prepare("
        SELECT view_count, last_viewed_at
        FROM book_views
        WHERE user_id = ? AND book_id = ?
    ");

    $stmt->execute([$_SESSION['user_id'], $id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if($row)
    {
        $lastView = strtotime($row['last_viewed_at']);
        $now = time();

        /* 5 minutes cooldown */

        if(($now - $lastView) > 300)
        {
            $stmt = $conn->prepare("
                UPDATE book_views
                SET view_count = view_count + 1,
                    last_viewed_at = NOW()
                WHERE user_id = ? AND book_id = ?
            ");

            $stmt->execute([$_SESSION['user_id'], $id]);
        }
    }
    else
    {
        $stmt = $conn->prepare("
            INSERT INTO book_views (user_id, book_id, view_count, last_viewed_at)
            VALUES (?, ?, 1, NOW())
        ");

        $stmt->execute([$_SESSION['user_id'], $id]);
    }
}

    /* GET BOOK */

    $stmt = $conn->prepare("SELECT * FROM books WHERE id = ?");
    $stmt->execute([$id]);

    $book = $stmt->fetch(PDO::FETCH_ASSOC);

    /* GET GENRES */

    $stmt = $conn->prepare("
        SELECT g.name
        FROM genres g
        JOIN book_genres bg ON g.id = bg.genre_id
        WHERE bg.book_id = ?
    ");

    $stmt->execute([$id]);

    $genres = $stmt->fetchAll(PDO::FETCH_COLUMN);

    /* 🔥 RECOMMENDED BOOKS */

$stmt = $conn->prepare("
    SELECT b.*, SUM(bv2.view_count) AS score
    FROM book_views bv1
    JOIN book_views bv2 
        ON bv1.user_id = bv2.user_id
    JOIN books b 
        ON b.id = bv2.book_id
    WHERE bv1.book_id = ?
    AND bv2.book_id != ?
    GROUP BY b.id
    ORDER BY score DESC
    LIMIT 4
");
 


$stmt->execute([$id, $id]);

$recommended = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* LIKE COUNT */

$stmt = $conn->prepare("
    SELECT COUNT(*) FROM book_likes WHERE book_id = ?
");

$stmt->execute([$id]);

$likeCount = $stmt->fetchColumn();

/* CHECK USER LIKED */

$userLiked = false;

if(isset($_SESSION['user_id']))
{
    $stmt = $conn->prepare("
        SELECT * FROM book_likes 
        WHERE user_id = ? AND book_id = ?
    ");

    $stmt->execute([$_SESSION['user_id'], $id]);

    $userLiked = $stmt->rowCount() > 0;
}

   $this->view("books/show", [
    "book" => $book,
    "genres" => $genres,
    "recommended" => $recommended,
    "likeCount" => $likeCount,
    "userLiked" => $userLiked
  ]);
}

public function like($id)
{
    if(session_status() === PHP_SESSION_NONE){
        session_start();
    }

    if(!isset($_SESSION['user_id']))
    {
        echo json_encode(["error" => "login required"]);
        return;
    }

    $db = new Database();
    $conn = $db->connect();

    $user_id = $_SESSION['user_id'];

    /* CHECK */

    $stmt = $conn->prepare("
        SELECT id FROM book_likes 
        WHERE user_id = ? AND book_id = ?
    ");
    $stmt->execute([$user_id, $id]);

    if($stmt->fetch())
    {
        /* UNLIKE */
        $stmt = $conn->prepare("
            DELETE FROM book_likes 
            WHERE user_id = ? AND book_id = ?
        ");
        $stmt->execute([$user_id, $id]);

        $liked = false;
    }
    else
    {
        /* LIKE */
        $stmt = $conn->prepare("
            INSERT INTO book_likes (user_id, book_id)
            VALUES (?, ?)
        ");
        $stmt->execute([$user_id, $id]);

        $liked = true;
    }

    /* GET NEW COUNT */

    $stmt = $conn->prepare("
        SELECT COUNT(*) FROM book_likes WHERE book_id = ?
    ");
    $stmt->execute([$id]);

    $count = $stmt->fetchColumn();

    echo json_encode([
        "liked" => $liked,
        "count" => $count
    ]);
}

}


?>
