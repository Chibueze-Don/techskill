<?php

use Dotenv\Dotenv;

require_once __DIR__ . "/../vendor/autoload.php";

$dotenv = Dotenv::createImmutable(__DIR__ . "/../");

$dotenv->load();


try{

$dsn = "mysql:host = {$_ENV['DB_HOST']}; dbname = {$_ENV['DB_NAME']}; charset = utf8_mb4";

$DB = new PDO($dsn, $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);

$DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$DB->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

$DB->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

$DB->exec("USE techskill");

if(session_status() === PHP_SESSION_NONE)
    {
        session_start();
    }

}catch(PDOException $pdo_error){

    http_response_code(500);
  die('connection failed');

}