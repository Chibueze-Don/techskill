<?php
session_start();
// if(!isset($_SESSION['user'])) header("Location: ./login.php");

$content = ' <div class="mb-3 border border-1 border-secondary rounded p-4 bg-light bg-opacity-25">
            <h3 class="fw-bold">Verify Your Email</h3>
            <p class="lead">Thank you for comming onboard. a confirmation email have been sent to your email, kindly check your inbox!</p>
        </div>';

if($_SERVER['REQUEST_METHOD'] === "POST")
    {
        $otp = isset($_POST['otp']) ? filter_var(trim($_POST['otp']), FILTER_VALIDATE_INT) : '';

        if(!empty($otp))
            {
                require_once __DIR__ . "/../config/dbconnection.php";

                $stmt = $DB->prepare("SELECT otp_code FROM users WHERE email = :email");
                $email = isset($_SESSION['user']) ? $_SESSION['user'] : null;

                $stmt->bindParam(":email", $email, PDO::PARAM_STR);

                $stmt->execute();

                if($stmt->rowCount() > 0)
                    {

                $content = ' <div class="mb-3 border border-1 border-secondary rounded p-4 bg-light bg-success bg-opacity-25">
            <h3 class="fw-bold">Email Verified!</h3>
            <p class="lead">Thank you for comming onboard. you will be redirect in 5 seconds, otherwise click <a href="./login.php">Here</a> to redirect</p>
        </div>';
                    }
            }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
</head>
<body class="bg-light align-content-center" style="min-height: 100vh;">
    <div class="col-11 col-md-4 m-auto">
       <?= $content ?? ''; ?>
        <div class="">
            <form action="" method="post" id="form">
                <input type="text" class="form-control shadow text-center py-3" 
                placeholder=" -    -    -    -    -    - " name="otp-code" id="otp" 
                pattern="[0-9]" maxlength="6">
            </form>
        </div>
    </div>

    <script>
   let otp = document.querySelector('#otp');


   otp.addEventListener('input', function(){
    if(otp.value.trim().length === 6 && !isNaN(otp.value.trim())){
        document.querySelector('#form').submit(); 
    }
   })
    </script>
</body>
</html>