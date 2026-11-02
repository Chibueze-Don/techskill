<?php
session_start();

// Add your existing administrator authentication check here.
// Do not allow the public to send arbitrary emails through this form.
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>TechSkill Newsletter</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 30px 15px;
            background: #f3f4f6;
            font-family: Arial, sans-serif;
        }

        .newsletter-container {
            max-width: 650px;
            margin: 30px auto;
            padding: 30px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        }

        h1 {
            margin-top: 0;
            color: #333;
            text-align: center;
        }

        label {
            display: block;
            margin-top: 18px;
            margin-bottom: 7px;
            font-weight: bold;
        }

        input,
        textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 15px;
        }

        textarea {
            min-height: 180px;
            resize: vertical;
        }

        button {
            width: 100%;
            margin-top: 24px;
            padding: 14px;
            background: #6b21a8;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background: #581c87;
        }

        @media (max-width: 480px) {
            .newsletter-container {
                padding: 20px;
            }
        }
    </style>
</head>

<body>

<div class="newsletter-container">

    <h1>TechSkill Newsletter</h1>

    <form action="send.php" method="POST">

        <label for="client_name">Client Name</label>
        <input
            type="text"
            id="client_name"
            name="client_name"
            maxlength="150"
            required
        >

        <label for="client_email">Client Email Address</label>
        <input
            type="email"
            id="client_email"
            name="client_email"
            maxlength="254"
            required
        >

        <label for="subject">Subject / Title</label>
        <input
            type="text"
            id="subject"
            name="subject"
            maxlength="200"
            required
        >

        <label for="message">Message</label>
        <textarea
            id="message"
            name="message"
            maxlength="20000"
            required
        ></textarea>

        <button type="submit">Send Email</button>

    </form>

</div>

</body>
</html>
```
