<?php
session_start();
include("../config/db_connect.php");

if (!isset($_SESSION['user_id'])) {
    die("Access Denied.");
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $profile_pic = "";

    // Handle Profile Picture Upload
    if (!empty($_FILES['profile_pic']['name'])) {
        $target_dir = "../uploads";
        $file_name = basename($_FILES["profile_pic"]["name"]);
        $target_file = $target_dir . time() . "_" . $file_name;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        $valid_extensions = array("jpg", "jpeg", "png", "gif");
        if (in_array($imageFileType, $valid_extensions)) {
            if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_file)) {
                $profile_pic = str_replace("../", "", $target_file);
            }
        }
    }

    // Update user details
    if (!empty($profile_pic)) {
        $query = "UPDATE users SET first_name=?, last_name=?, email=?, phone=?, profile_pic=? WHERE user_id=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssssi", $first_name, $last_name, $email, $phone, $profile_pic, $user_id);
    } else {
        $query = "UPDATE users SET first_name=?, last_name=?, email=?, phone=? WHERE user_id=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssi", $first_name, $last_name, $email, $phone, $user_id);
    }
    
    if ($stmt->execute()) {
        $_SESSION['success'] = "Profile updated successfully!";
    } else {
        $_SESSION['error'] = "Failed to update profile.";
    }
}

header("Location: profile.php");
exit();
?>
