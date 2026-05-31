<?php 
/** @var array $mail */
?>

<?php

require_once "../app/core/Controller.php";
require_once "../app/core/Database.php";
require_once "../vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ContactController extends Controller
{
    public function index()
    {
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }

        if(!isset($_SESSION['user_id'])){
            header("Location: /evol/public/auth/login");
            exit;
        }

        $db = new Database();
        $conn = $db->connect();

        $stmt = $conn->prepare("
            SELECT name, username, email
            FROM users
            WHERE id = ?
        ");

        $stmt->execute([
            $_SESSION['user_id']
        ]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->view("contact/index", [
            "user" => $user
        ]);
    }

    public function store()
    {
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }

        $db = new Database();
        $conn = $db->connect();

        /* SAVE MESSAGE */

        $stmt = $conn->prepare("
            INSERT INTO contacts
            (
                user_id,
                subject,
                phone,
                message
            )
            VALUES
            (
                ?,
                ?,
                ?,
                ?
            )
        ");

        $stmt->execute([

            $_SESSION['user_id'],

            $_POST['subject'],

            $_POST['phone'],

            $_POST['message']
        ]);



        /* GET USER DETAILS */

        $stmt = $conn->prepare("
            SELECT name,email
            FROM users
            WHERE id = ?
        ");

        $stmt->execute([
            $_SESSION['user_id']
        ]);

        $user =
        $stmt->fetch(PDO::FETCH_ASSOC);



        /* SEND EMAIL */

        try{

            $mail = new PHPMailer(true);

            $mail->isSMTP();

            $mail->Host =
            'smtp.gmail.com';

            $mail->SMTPAuth = true;

            $mail->Username =
            'gaemisgaemandalsofun@gmail.com';

            $mail->Password =
            'oput gllk akxe szkm';

            $mail->SMTPSecure =
            PHPMailer::ENCRYPTION_STARTTLS;

            $mail->Port = 587;

            $mail->setFrom(
                'gaemisgaemandalsofun@gmail.com',
                'EvolBooks'
            );

            $mail->addAddress(
                $user['email'],
                $user['name']
            );

            $mail->isHTML(true);

            $mail->Subject =
            'Thank You For Contacting EvolBooks';

            $mail->Body = "

            <div style='font-family:Segoe UI,sans-serif;
                        max-width:600px;
                        margin:auto;'>

                <h2 style='color:#22c55e'>
                    Thank You For Contacting EvolBooks 
                </h2>

                <p>
                    Hello <strong>{$user['name']}</strong>,
                </p>

                <p>
                    We have successfully received your message.
                </p>

                <p>
                    Thank you for reaching out to EvolBooks.
                </p>

                <p>
                    EvolBooks is a modern online reading platform
                    where readers can discover, explore,
                    and enjoy books from various genres.
                </p>

                <p>
                    Our support team will carefully review
                    your request and respond within
                    <strong>24 hours</strong>.
                </p>

                <p>
                    We appreciate your interest and look
                    forward to helping you.
                </p>

                <br>

                <p>
                    Regards,<br>
                    <strong>EvolBooks Team</strong>
                </p>

            </div>

            ";

            $mail->send();

        }
        catch(Exception $e){

            error_log(
                // $mail->ErrorInfo
                 'PHPMailer Error: ' . $e->getMessage()
            );
        }


        /* SUCCESS POPUP */

        $_SESSION['contact_success'] = true;

        header(
            "Location: /evol/public/contact"
        );

        exit;
    }
}