<?php

ini_set('display_errors', 1);

if($_SERVER['REQUEST_METHOD'] === "POST")
    {
        require_once __DIR__ . "/../config/dbconnection.php";

        if(isset($_POST['name'], $_POST['email'], $_POST['password']))
            {
                $name = trim($_POST['name']);
                $email = trim($_POST['email']);
                $password = trim($_POST['password']);

                if(!empty($name) && !empty($email) && !empty($password))
                    {
                        // check existing user email;

                        $chk_email = $DB->prepare("SELECT id FROM users WHERE email = :email");

                        $chk_email->bindParam(":email", $email, PDO::PARAM_STR);
                        $chk_email->execute();

                        if(!$chk_email->rowCount() > 0)
                            {

                        $otp = mt_rand(100000, 999999);

                        $stmt = $DB->prepare("INSERT INTO users SET `name` = :name, email = :email, `password` = :password, otp_code = :otp");

                        $password = password_hash($password, PASSWORD_DEFAULT);

                        $stmt->bindParam(":name", $name);
                        $stmt->bindParam(":email", $email);
                        $stmt->bindParam(":password", $password);
                        $stmt->bindParam(":otp", $otp);

                        $stmt->execute();

                        if($stmt->rowCount() > 0)
                            {
                              
                        require_once __DIR__ . "/../mail/email-otp.php";

                        if(send_mail_otp($email, $otp, $name))
                            {
                                echo "<script>window.location = './verify-email.php';</script>";
                            }

                            }

                            }else{
                                $msg = '<p class="alert alert-warning">email address in use</p>';
                            }
                    }

            }else{
                $msg = '<p class="alert alert-danger">fill all required fields!</p>';
            }


    }



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup - TechSkill</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
</head>
<body class="bg-light align-content-center" style="min-height: 100vh;">
    <form action="" method="post" class="col-11 col-md-4 m-auto">
        <div class="text-center">
            <h3 class="display-1 fw-bold">
                Sign up
            </h3>
            <p class="lead">
                Create a membership account on TechSkill Base
            </p>
        </div>

        <?= $msg ?? ''; ?>

        <div class="card card-body shadow py-4">
            <div class="mb-3">
                <label for="name" class="lead">Enter name</label>
                <input type="text" class="form-control" name="name" id="name">
            </div>
            <div class="mb-3">
                <label for="email" class="lead">Enter email</label>
                <input type="email" class="form-control" name="email" id="email">
            </div>
            <div class="mb-3">
                <label for="password" class="d-flex justify-content-between align-items-center"> <span class="lead">Enter password</span> <span id="pin"  class="text-primary">show</span> </label>
                <input type="password" class="form-control" name="password" id="password">
            </div>
            <div class="mb-3">
                <div class="form-check">
                    <input type="checkbox" required class="form-check-input">
                    <label for="" class="form-check-label">
                        By submitting this form, you agree to have read our terms and <a href="">privacy</a> policy
                    </label>
                </div>
                
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-dark d-block w-100 py-2">Create account</button>
            </div>
            <div class="mb-3">
                Already a member? Continue to <a href="" class="">Login</a>
            </div>
        </div>
    </form>


    <script>
        let password = document.querySelector('#password');
        let pin = document.querySelector('#pin');

        pin.addEventListener('click', ()=>{
            // let val = password.value;

            if(password.type === "password"){
                password.type = 'text';
                pin.textContent = 'hide';
            }else{
                password.type = 'password';
                pin.textContent = 'show';
            }

        })
    </script>
    
</body>
</html>