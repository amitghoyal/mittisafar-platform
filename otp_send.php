<?php
session_start();
require 'config/db_connect.php'; // connection
require 'PHPMailer/PHPMailerAutoload.php';

$email = $_POST['email'];
$check = $conn->prepare("SELECT * FROM users WHERE email = ?");
$check->bind_param("s", $email);
$check->execute();
$result = $check->get_result();

if ($result->num_rows > 0) {
    echo "exists";
    exit;
}

$otp = rand(100000, 999999);
$_SESSION['otp'] = $otp;
$_SESSION['otp_email'] = $email;

$mail = new PHPMailer;
$mail->isSMTP();
$mail->Host = ''; // update
$mail->SMTPAuth = true;
$mail->Username = 'your@example.com'; // update
$mail->Password = 'password'; // update
$mail->SMTPSecure = 'tls';
$mail->Port = 587;

$mail->setFrom('your@example.com', 'Mittisafar');
$mail->addAddress($email);
$mail->Subject = 'Your OTP for Email Verification';
$mail->Body    = "Your OTP is: $otp";

if (!$mail->send()) {
    echo 'error';
} else {
    echo 'sent';
}
?>
