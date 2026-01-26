<?php
include 'config/db_connect.php';

$response = ["status" => "", "message" => ""];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $subject = trim($_POST["subject"]);
    $message = trim($_POST["message"]);

    $errors = [];

    if (empty($name) || !preg_match("/^[a-zA-Z ]*$/", $name)) {
        $errors[] = "Invalid Name.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }
    if (!preg_match("/^[0-9]{10,15}$/", $phone)) {
        $errors[] = "Invalid phone number.";
    }
    if (strlen($message) < 10) {
        $errors[] = "Message must be at least 10 characters.";
    }

    if (!empty($errors)) {
        $response["status"] = "error";
        $response["message"] = implode("<br>", $errors);
    } else {
        $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, phone, subject, message) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $email, $phone, $subject, $message);
        $stmt->execute();
        $response["status"] = "success";
        $response["message"] = "Your message has been sent successfully!";
    }
}

echo json_encode($response);
?>
