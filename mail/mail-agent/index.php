<?php
ini_set("display_errors", 1); // enables display of debug information

use Dotenv\Dotenv;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . "/../../vendor/autoload.php";

$dotenv = Dotenv::createImmutable(__DIR__ . "/../../");
$dotenv->load();

$mail = new PHPMailer(true);

$mail->SMTPDebug = 0; // SMTP::DEBUG_SERVER;

$mail->isSMTP();

$mail->isHTML(true);

$mail->SMTPAuth = true;

$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

if($_SERVER['REQUEST_METHOD'] === "POST")
    {
        $username = isset($_POST['username']) ? htmlspecialchars(trim($_POST['username'])) : '';

        $email = isset($_POST['email']) ? htmlspecialchars(trim($_POST['email'])) : '';

        $subject = isset($_POST['subject']) ? htmlspecialchars(trim($_POST['subject'])) : '';

        $message = isset($_POST['message']) ? htmlspecialchars(trim($_POST['message'])) : '';

        if(!empty($username) && !empty($email) && !empty($subject) && !empty($message))
            {

        try{

        $mail->Host = $_ENV['MAIL_SERVER'];
        // clear temporal recieient address
        $mail->clearAddresses();

        $mail->Username = $_ENV['MAIL_USERNAME'];
        $mail->Password = $_ENV['MAIL_PASSWORD'];
        $mail->Port = 587;

        $mail->setFrom($_ENV['MAIL_USERNAME'], 'TECHSKILL');
        $mail->addAddress($email, $username);

        $mail->Subject = "<div>$subject</div>";

        $mail->Body = $message;

        $mail->AltBody = strip_tags($message);

        $mail->send();

        }catch(Exception $error)
        {

        }
            }

    

    }



    // VCS = Version Control System {GIT/GITHUB} | HOSTING

    // LARAVEL;


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mailer - TechSkill</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container">
   <form action="" method="post">
     <div class="row pt-5">
        <div class="col-11 col-lg-6">
            <h2>Client Detail</h2>
            <div class="">
                <div class="mb-4">
                    <input type="text" class="form-control" placeholder="Username" name="username">
                </div>
                <div class="mb-4">
                    <input type="text" placeholder="Email address" class="form-control" name="email">
                </div>
                <div class=""></div>
            </div>
        </div>
        <div class="col-11 col-lg-6">
            <div class="py-1 my-3 px-2 fs-2 border-start border-4 border-warning btn-outline-primary">Message Panel</div>
            <input type="text" name="subject" placeholder="Subject/Title" class="form-control mb-4">
            <textarea name="message" placeholder="Enter message here" id="" class="mb-4 form-control" rows="5"></textarea>

            <input type="submit" value="Send newsletter" class="btn btn-dark d-block w-100 py-3">
        </div>
    </div>
   </form>
</div>
   

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>