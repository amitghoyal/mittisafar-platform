<?php
session_start();
require 'config/db_connect.php';
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    $stmt = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($user_id);
        $stmt->fetch();

        $otp = rand(100000, 999999);
        $otp_expiration = date("Y-m-d H:i:s", strtotime("+10 minutes"));

        // Store OTP in the password_reset_tokens table
        $insert = $conn->prepare("INSERT INTO password_reset_tokens (email, otp, expires_at) VALUES (?, ?, ?)");
        $insert->bind_param("sss", $email, $otp, $otp_expiration);
        $insert->execute();

        // Save to session
        $_SESSION['otp'] = $otp;
        $_SESSION['otp_expiration'] = $otp_expiration;
        $_SESSION['email'] = $email;

        // Send email
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'mittisafar@gmail.com';
            $mail->Password = 'fbrx jpcb kbxz nsgy';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            $mail->setFrom('mittisafar@gmail.com', 'MittiSafar');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = "🔐 Your OTP for Password Reset - MittiSafar";

            $mail->Body = "
                <html>
                <head>
                    <style>
                        body { font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px; text-align: center; }
                        .container { background: #ffffff; padding: 20px; border-radius: 10px; max-width: 500px; margin: auto; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); }
                        .otp { font-size: 24px; font-weight: bold; color: #4CAF50; margin: 20px 0; }
                        .button { display: inline-block; padding: 10px 20px; font-size: 18px; color: white; background-color: #4CAF50; text-decoration: none; border-radius: 5px; }
                        .footer { font-size: 12px; color: #777; margin-top: 20px; }
                    </style>
                </head>
                <body>
                    <div class='container'>
                        <h2>Reset Your Password</h2>
                        <p>Hello,</p>
                        <p>Your One-Time Password (OTP) for resetting your MittiSafar account password is:</p>
                        <div class='otp'>$otp</div>
                        <p>This OTP will expire in <b>10 minutes</b>. Do not share it with anyone.</p>
                        <p>If you did not request this, please ignore this email.</p>
                        <p class='footer'>© 2025 MittiSafar. All rights reserved.</p>
                    </div>
                </body>
                </html>
            ";

            $mail->AltBody = "Your OTP for password reset is: $otp. This OTP will expire in 10 minutes.";
            $mail->send();

            $_SESSION['otp_success'] = "OTP sent successfully to your email.";
            header("Location: verify_otp.php");
            exit();

        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

    } else {
        echo "Email not found or not a traveler.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>
