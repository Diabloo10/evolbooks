<?php

require_once "../app/core/Controller.php";
require_once "../app/core/Database.php";

class AdminContactController extends Controller
{
   public function index()
{
    Middleware::admin();

    $db = new Database();
    $conn = $db->connect();

    $stmt = $conn->query("
        SELECT 
            contacts.*,
            users.name,
            users.email

        FROM contacts

        LEFT JOIN users
        ON contacts.user_id = users.id

        ORDER BY contacts.id DESC
    ");

    $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $this->view("admin/contact/index", [
        "contacts" => $contacts
    ]);
}

    /* DELETE MESSAGE */

    public function delete($id)
    {
        Middleware::admin();

        $db = new Database();
        $conn = $db->connect();

        $stmt = $conn->prepare("
            DELETE FROM contacts
            WHERE id = ?
        ");

        $stmt->execute([$id]);

        header("Location: /evol/public/admincontact/index");
        exit;
    }
}