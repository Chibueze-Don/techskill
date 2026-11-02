<?php
ini_set("display_errors", 1);

use Dotenv\Dotenv; // imports dotenv class namespace;

use PHPMailer\PHPMailer\PHPMailer; // imports phpmailer class;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// import composer autoload file:
require_once __DIR__ . DIRECTORY_SEPARATOR . "../vendor/autoload.php";

// PARSE .env variables and load environemnt variables;
$dotenv = Dotenv::createImmutable(__DIR__ . "/../");
$dotenv->load();

$mail = new PHPMailer(true); // instantiate phpmailer class/create phpmailer instance;

$mail->SMTPDebug = 0; // SMTP::DEBUG_SERVER; // enable display error information
$mail->isSMTP(); // use smtp connection;
$mail->isHTML(true); // use html in content
$mail->Username = $_ENV['MAIL_USERNAME'];
$mail->Password = $_ENV['MAIL_PASSWORD'];
$mail->Host = $_ENV['MAIL_SERVER'];
$mail->Port = $_ENV['MAIL_PORT'];
$mail->setFrom($_ENV['MAIL_USERNAME'], $_ENV['APP_NAME']);
$mail->SMTPAuth = true;
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

function send_mail_otp($email, $otp, $name)
{
   try{

    global $mail;

    // $otp = mt_rand(100000, 999999); // generate 6 digits OTP(one-time password);
    // $email = $_ENV['MAIL_USERNAME'];
    $year = date('Y');

    $mail->clearAddresses();

    $mail->addAddress($email, $name);

    $mail->Subject = "Confirm account email";

    $mail->Body = "<div style='padding: 2rem 1rem; background-color: darkorchid; border-radius: 1rem; font-size: 1.2rem;'> <div style='border-radius: 1rem; padding: 1rem; font-size: 1.2rem; background: aliceblue;'> <h1 style='text-align:center; padding: 0.7rem 0rem; font-size: 1.5rem;'>WELCOME</h1> <p>Hello <b>{$name}</b>,<p> <p>we are glad to have you onboard, use the OTP(One-Time Password) code below to verify that it is you. DO NOT SHARE YOUR OTP WITH ANYBODY!</p> <p style='text-align:center;'><span style='letter-spacing: 4px; font-weight:bold;'>{$otp}</span></p> <hr> <p><b>Disclaimer:</b> This is a machine auto-generated email, intended for {$email}. if you have received this without triggering any action or feel this to be in an error, kindly ignore or deleted this message.</p> <p>Regards, <br> <strong>TechSkill Team</strong></p> <p style='text-align: center; padding-top: 1rem;'> &copy; {$year}. Powered By <a href='localhost/techskill/'>TechSkill ltd</a></p> </div> </div>";

    $mail->AltBody = "Your Account Confirmation OTP code is: {$otp}. \n please do not share with anyone";

    $mail->send();

    return true;

   }catch(Exception $mail_error){

     return false;
   }


}

// send_mailotp();


        

       
       