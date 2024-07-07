<?php
require_once "./config/database.php";

if (isset($_GET['code'])) {
    $verification_code = $_GET['code'];

    $sql = "SELECT id FROM users WHERE verification_code = :verification_code";
    if ($stmt = $pdo->prepare($sql)) {
        $stmt->bindParam(":verification_code", $param_verification_code, PDO::PARAM_STR);
        $param_verification_code = $verification_code;

        if ($stmt->execute()) {
            if ($stmt->rowCount() == 1) {
                $sql = "UPDATE users SET email_verified = 1 WHERE verification_code = :verification_code";
                if ($stmt = $pdo->prepare($sql)) {
                    $stmt->bindParam(":verification_code", $param_verification_code, PDO::PARAM_STR);
                    $param_verification_code = $verification_code;

                    if ($stmt->execute()) {
                        echo "Email verified successfully!";
                    } else {
                        echo "Something went wrong. Please try again later.";
                    }
                }
            } else {
                echo "Invalid verification code.";
            }
        } else {
            echo "Something went wrong. Please try again later.";
        }
    }
    unset($stmt);
}
unset($pdo);
?>
