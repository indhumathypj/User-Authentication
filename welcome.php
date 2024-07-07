<?php

session_start();
require_once "./config/database.php";

$cookie_data = $_COOKIE['remember_me'];
list($cookie_username, $cookie_token) = explode(':', $cookie_data);

if (!empty($cookie_username) && !empty($cookie_token)) {
    
    $sql = "SELECT id, username, remember_token FROM users WHERE username = :username AND remember_token = :token";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':username', $cookie_username, PDO::PARAM_STR);
    $stmt->bindParam(':token', $cookie_token, PDO::PARAM_STR);
    if ($stmt->execute() && $stmt->rowCount() == 1) {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $cookie_username;
    } else {
        setcookie('remember_me', '', time() - 3600, '/');
    }
}else{
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: login.php");
        exit;
    }
}
include './views/welcome.php';
?>
 