<?php

session_start();

// Add your existing administrator authentication check here.
// Do not expose this email-sending endpoint publicly.

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

require_once __DIR__ . '/newsletter-mail.php';

$name = trim($_POST['client_name'] ?? '');
$email = trim($_POST['client_email'] ?? '');
$subject = trim($_POST['subject'] ?? '');
$message = trim($_POST['message'] ?? '');

// Validate required fields.
if (
    $name === '' ||
    $email === '' ||
    $subject === '' ||
    $message === ''
) {
    exit('All fields are required.');
}

// Validate lengths.
if (
    mb_strlen($name) > 150 ||
    strlen($email) > 254 ||
    mb_strlen($subject) > 200 ||
    mb_strlen($message) > 20000
) {
    exit('One or more fields exceed the allowed length.');
}

// Validate email address.
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    exit('Please enter a valid email address.');
}

// Prevent header injection.
if (
    preg_match('/[\r\n]/', $name) ||
    preg_match('/[\r\n]/', $subject)
) {
    exit('Invalid name or subject.');
}

// Send email.
if (send_newsletter_email($email, $name, $subject, $message)) {

    echo '<h3>Newsletter email submitted successfully.</h3>';
    echo '<p>The email service accepted the message for sending.</p>';
    echo '<a href="index.php">Send another email</a>';

} else {

    http_response_code(500);

    echo '<h3>Unable to send newsletter.</h3>';
    echo '<p>Check the server error log for details.</p>';
    echo '<a href="index.php">Try again</a>';
}