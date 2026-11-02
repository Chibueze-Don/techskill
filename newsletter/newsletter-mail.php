<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

// Load Composer.
require_once __DIR__ . '/../vendor/autoload.php';

// Load environment variables from project root.
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad();

/**
 * Send a newsletter email to one recipient.
 *
 * @param string $email   Recipient email address.
 * @param string $name    Recipient name.
 * @param string $subject Email subject.
 * @param string $message Newsletter message.
 *
 * @return bool
 */
function send_newsletter_email(
    string $email,
    string $name,
    string $subject,
    string $message
): bool {

    $mail = new PHPMailer(true);

    try {

        // SMTP configuration.
        $mail->isSMTP();
        $mail->Host = $_ENV['MAIL_SERVER'];
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['MAIL_USERNAME'];
        $mail->Password = $_ENV['MAIL_PASSWORD'];
        $mail->Port = (int) $_ENV['MAIL_PORT'];

        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

        $mail->CharSet = 'UTF-8';

        // Sender.
        $mail->setFrom(
            $_ENV['MAIL_USERNAME'],
            $_ENV['APP_NAME'] ?? 'TechSkill'
        );

        // Recipient.
        $mail->addAddress($email, $name);

        // Message format.
        $mail->isHTML(true);

        $safeName = htmlspecialchars(
            $name,
            ENT_QUOTES | ENT_SUBSTITUTE,
            'UTF-8'
        );

        $safeSubject = htmlspecialchars(
            $subject,
            ENT_QUOTES | ENT_SUBSTITUTE,
            'UTF-8'
        );

        $safeMessage = nl2br(
            htmlspecialchars(
                $message,
                ENT_QUOTES | ENT_SUBSTITUTE,
                'UTF-8'
            )
        );

        $year = date('Y');

        $mail->Subject = $subject;

        $mail->Body = "
            <!DOCTYPE html>
            <html>
            <body style='font-family:Arial,sans-serif;
                         line-height:1.6;color:#333;'>

                <div style='max-width:650px;margin:auto;padding:25px;'>

                    <h2>{$safeSubject}</h2>

                    <p>Hello <strong>{$safeName}</strong>,</p>

                    <div>{$safeMessage}</div>

                    <hr>

                    <p>Regards,<br>
                    <strong>TechSkill Team</strong></p>

                    <p style='text-align:center;font-size:12px;color:#777;'>
                        &copy; {$year} TechSkill. All rights reserved.
                    </p>

                </div>

            </body>
            </html>
        ";

        $mail->AltBody =
            "Hello {$name},\n\n{$message}\n\nRegards,\nTechSkill Team";

        $mail->send();

        return true;

    } catch (\Throwable $e) {

        error_log(
            'Newsletter email error: ' .
            get_class($e) . ': ' . $e->getMessage()
        );

        error_log('PHPMailer error: ' . $mail->ErrorInfo);

        return false;
    }
}