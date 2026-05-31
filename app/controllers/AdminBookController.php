<?php

require_once "../app/core/Controller.php";
require_once "../app/core/Database.php";

class AdminBookController extends Controller
{

    public function index()
    {
        Middleware::admin();

        $db = new Database();
        $conn = $db->connect();

        $stmt = $conn->prepare("
            SELECT 
                books.*,
                GROUP_CONCAT(genres.name SEPARATOR ', ') AS genres
            FROM books
            LEFT JOIN book_genres 
                ON books.id = book_genres.book_id
            LEFT JOIN genres 
                ON genres.id = book_genres.genre_id
            GROUP BY books.id
            ORDER BY books.created_at DESC
        ");

        $stmt->execute();

        $books = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->view("admin/books/index", ["books"=>$books]);
    }

    // add book

    public function create()
    {
        Middleware::admin();

        $db = new Database();
        $conn = $db->connect(); 

    // fetch genres for checkbox list
    $stmt = $conn->query("SELECT * FROM genres");
    $genres = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if($_SERVER['REQUEST_METHOD'] === 'POST')
    {

        $title = $_POST['title'];
        $author = $_POST['author'];
        $isbn = $_POST['isbn'];
        $language = $_POST['language'];
        $description = $_POST['description'];
        $selectedGenres = $_POST['genres'];

        /* ---------- Cover Upload ---------- */

        $coverName = $_FILES['cover_image']['name'];
        $coverTmp = $_FILES['cover_image']['tmp_name'];

        move_uploaded_file($coverTmp, "../storage/uploads/".$coverName);

        /* ---------- PDF Upload ---------- */

        $pdfName = $_FILES['pdf_file']['name'];
        $pdfTmp = $_FILES['pdf_file']['tmp_name'];

        move_uploaded_file($pdfTmp, "../storage/books/".$pdfName);

        /* ---------- Insert Book ---------- */

        $stmt = $conn->prepare("
            INSERT INTO books
            (title,author,isbn,language,description,cover_image,pdf_file,created_by)
            VALUES (?,?,?,?,?,?,?,?)
        ");

        $stmt->execute([
            $title,
            $author,
            $isbn,
            $language,
            $description,
            $coverName,
            $pdfName,
            $_SESSION['user_id']
        ]);

        $bookId = $conn->lastInsertId();

        /* ---------- Insert Genres ---------- */

        foreach($selectedGenres as $genreId){

            $stmt = $conn->prepare("
                INSERT INTO book_genres (book_id,genre_id)
                VALUES (?,?)
            ");

            $stmt->execute([$bookId,$genreId]);
        }

        header("Location: /evol/public/adminbook/index");
        exit;
    }

    $this->view("admin/books/create", ['genres'=>$genres]);
}

// edit book

public function edit($id)
{
    Middleware::admin();

    $db = new Database();
    $conn = $db->connect();

    /* -------- GET BOOK -------- */

    $stmt = $conn->prepare("SELECT * FROM books WHERE id=?");
    $stmt->execute([$id]);

    $book = $stmt->fetch(PDO::FETCH_ASSOC);

    /* -------- GET GENRES -------- */

    $stmt = $conn->query("SELECT * FROM genres");
    $genres = $stmt->fetchAll(PDO::FETCH_ASSOC);

    /* -------- CURRENT GENRES -------- */

    $stmt = $conn->prepare("SELECT genre_id FROM book_genres WHERE book_id=?");
    $stmt->execute([$id]);

    $bookGenres = $stmt->fetchAll(PDO::FETCH_COLUMN);

    if($_SERVER['REQUEST_METHOD'] === "POST")
    {

        $title = $_POST['title'];
        $author = $_POST['author'];
        $isbn = $_POST['isbn'];
        $language = $_POST['language'];
        $description = $_POST['description'];

        /* ---------- COVER UPDATE ---------- */

        if(!empty($_FILES['cover_image']['name']))
        {
            $cover = $_FILES['cover_image']['name'];
            $tmp = $_FILES['cover_image']['tmp_name'];

            move_uploaded_file($tmp,"../storage/uploads/".$cover);
        }
        else
        {
            $cover = $book['cover_image'];
        }

        /* ---------- PDF UPDATE ---------- */

        if(!empty($_FILES['pdf_file']['name']))
        {
            $pdf = $_FILES['pdf_file']['name'];
            $tmp = $_FILES['pdf_file']['tmp_name'];

            move_uploaded_file($tmp,"../storage/books/".$pdf);
        }
        else
        {
            $pdf = $book['pdf_file'];
        }

        /* ---------- UPDATE BOOK ---------- */

        $stmt = $conn->prepare("
            UPDATE books
            SET title=?,author=?,isbn=?,language=?,description=?,cover_image=?,pdf_file=?
            WHERE id=?
        ");

        $stmt->execute([
            $title,
            $author,
            $isbn,
            $language,
            $description,
            $cover,
            $pdf,
            $id
        ]);

        /* ---------- UPDATE GENRES ---------- */

        $conn->prepare("DELETE FROM book_genres WHERE book_id=?")->execute([$id]);

        if(isset($_POST['genres']))
        {
            foreach($_POST['genres'] as $genreId)
            {
                $stmt = $conn->prepare("
                    INSERT INTO book_genres (book_id,genre_id)
                    VALUES (?,?)
                ");

                $stmt->execute([$id,$genreId]);
            }
        }

        header("Location: /evol/public/adminbook");
        exit;
    }

    $this->view("admin/books/edit",[
        "book"=>$book,
        "genres"=>$genres,
        "bookGenres"=>$bookGenres
    ]);
}

// delete everything 

public function delete($id)
{
       Middleware::admin();

    $db = new Database();
    $conn = $db->connect();

    /* Get book first to delete files */

    $stmt = $conn->prepare("SELECT cover_image,pdf_file FROM books WHERE id=?");
    $stmt->execute([$id]);

    $book = $stmt->fetch(PDO::FETCH_ASSOC);

    if($book)
    {
        /* Delete cover image */

        if(!empty($book['cover_image']))
        {
            $coverPath = "../storage/uploads/".$book['cover_image'];

            if(file_exists($coverPath)){
                unlink($coverPath);
            }
        }

        /* Delete PDF */

        if(!empty($book['pdf_file']))
        {
            $pdfPath = "../storage/books/".$book['pdf_file'];

            if(file_exists($pdfPath)){
                unlink($pdfPath);
            }
        }

        /* Delete from database */

        $stmt = $conn->prepare("DELETE FROM books WHERE id=?");
        $stmt->execute([$id]);
    }

    header("Location: /evol/public/adminbook");
    exit;
}

}