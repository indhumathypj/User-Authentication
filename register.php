<?php

require_once "./config/database.php";
require './vendor/autoload.php'; // Include PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require './vendor/phpmailer/phpmailer/src/Exception.php';
require './vendor/phpmailer/phpmailer/src/PHPMAILER.php';
require './vendor/phpmailer/phpmailer/src/SMTP.php';
 

$username = $password = $email = "";
$username_err = $password_err = $email_err = "";
 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    // Validate username
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username.";
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))) {
        $username_err = "Username can only contain letters, numbers, and underscores.";
    } else {
        
        $sql = "SELECT id FROM users WHERE username = :username";
        
        if ($stmt = $pdo->prepare($sql)) {
            
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            
            
            $param_username = trim($_POST["username"]);
            
           
            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    $username_err = "This username is already taken.";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            
            unset($stmt);
        }
    }
    
    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter an email.";
    } elseif (!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
        $email_err = "Please enter a valid email.";
    } else {
        $email = trim($_POST["email"]);
    }
    
    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";    
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have at least 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }
    
    
    if (empty($username_err) && empty($password_err) && empty($email_err)) {
        
        
        $verification_code = md5(uniqid(rand(), true));

       
        $sql = "INSERT INTO users (username, email, password, verification_code) VALUES (:username, :email, :password, :verification_code)";

        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
            $stmt->bindParam(":verification_code", $param_verification_code, PDO::PARAM_STR);
            $param_username = $username;
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_verification_code = $verification_code;

            if ($stmt->execute()) {
                // Send verification email
                $mail = new PHPMailer(true);
                try {
                    
                    //$mail->SMTPDebug = 0;  
                    $mail->isSMTP();                                            
                    $mail->Host       = 'live.smtp.mailtrap.io';                    
                    $mail->SMTPAuth   = true;                                   
                    $mail->Username   = 'api';                                  // SMTP username
                    $mail->Password   = '3f127b106e03fab67b201374a027b412';     // SMTP password
                    $mail->SMTPSecure = 'tls';         
                    $mail->Port       = 587;                                    

                    //Recipients
                    $mail->setFrom('mailtrap@demomailtrap.com', 'Mailer');
                    $mail->addAddress("indhumathypj@gmail.com", "Indhu");     
                   // $mail->addAddress($email, $username); 
                    
                    $mail->isHTML(true);                                 
                    $mail->Subject = 'Email Verification';
                    $mail->Body    = 'Please click this link to verify your email: <a href="http://localhost/authentication/verify.php?code=' . $verification_code . '">Verify Email</a>';

                    $mail->send();
                    echo 'Verification email has been sent.';

                   
                    header("location: ./views/email_sent.php");
                } catch (Exception $e) {
                    print_r($mail);
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            
            unset($stmt);
        }
    }
    
    unset($pdo);
}
include './views/register.php';
?>
