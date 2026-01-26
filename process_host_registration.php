<?php
require 'config/db_connect.php'; // Include database connection

$error_messages = []; // Array to store multiple error messages

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone_number']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Secure password hashing
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $state = trim($_POST['state']);
    $district = trim($_POST['district']);
    $village = trim($_POST['village']);
    $pincode = trim($_POST['pincode']);
    $profile_photo = "";

    // Check if email, phone, or username is already in use
    $check_query = "SELECT username, email, phone FROM users WHERE email = ? OR phone = ? OR username = ?";
    if ($stmt = $conn->prepare($check_query)) {
        $stmt->bind_param("sss", $email, $phone, $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($existing_username, $existing_email, $existing_phone);
            while ($stmt->fetch()) {
                if ($existing_email == $email) {
                    $error_messages[] = "Email '$email' is already registered.";
                }
                if ($existing_phone == $phone) {
                    $error_messages[] = "Phone number '$phone' is already registered.";
                }
                if ($existing_username == $username) {
                    $error_messages[] = "Username '$username' is already taken.";
                }
            }
        }
        $stmt->close();
    }

    // If there are errors, redirect back with the messages
    if (!empty($error_messages)) {
        header("Location: register_host.php?error=" . urlencode(implode(" ", $error_messages)));
        exit();
    }

    // Profile Photo Upload Handling
    if (!empty($_FILES["profile_photo"]["name"])) {
        $target_dir = "uploads/";
        $file_name = time() . "_" . basename($_FILES["profile_photo"]["name"]);
        $target_file = $target_dir . $file_name;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = ['jpg', 'jpeg', 'png'];

        // Validate file type and size before moving
        if (in_array($imageFileType, $allowed_types) && $_FILES["profile_photo"]["size"] < 2500000) {
            if (move_uploaded_file($_FILES["profile_photo"]["tmp_name"], $target_file)) {
                $profile_photo = $target_file;
            } else {
                $error_messages[] = "Error uploading profile photo.";
            }
        } else {
            $error_messages[] = "Invalid file type or file size too large.";
        }
    }

    // If any error exists, redirect back
    if (!empty($error_messages)) {
        header("Location: register_host.php?error=" . urlencode(implode(" ", $error_messages)));
        exit();
    }

    // Insert into `users` table
    $user_query = "INSERT INTO users (first_name, last_name, username, email, phone, password, date_of_birth, gender, profile_pic, user_type) 
                   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'host')";

    if ($stmt = $conn->prepare($user_query)) {
        $stmt->bind_param("sssssssss", $first_name, $last_name, $username, $email, $phone, $password, $dob, $gender, $profile_photo);
        if ($stmt->execute()) {
            $user_id = $stmt->insert_id; // Get newly inserted user_id

            // Insert into `hosts` table
            $bio = NULL;
            $languages_spoken = NULL;
            $skills = json_encode([]); // Empty JSON array
            $specialties = NULL;
            $experience_years = 0;
            $availability = json_encode([]); // Empty JSON array
            $homestay_available = "no";
            $verification_status = "pending";

            $host_query = "INSERT INTO hosts (user_id, state, district, village, pincode, bio, languages_spoken, skills, specialties, experience_years, availability, homestay_available, verification_status) 
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            if ($stmt2 = $conn->prepare($host_query)) {
                $stmt2->bind_param("issssssssisss", $user_id, $state, $district, $village, $pincode, $bio, $languages_spoken, $skills, $specialties, $experience_years, $availability, $homestay_available, $verification_status);
                if ($stmt2->execute()) {
                    header('Location: login.php?success=Registration successful! Please log in.');
                    exit();
                } else {
                    $error_messages[] = "Error in host registration.";
                }
                $stmt2->close();
            }
        } else {
            $error_messages[] = "Error in user registration.";
        }
        $stmt->close();
    }

    // If any error exists, redirect back
    if (!empty($error_messages)) {
        header("Location: register_host.php?error=" . urlencode(implode(" ", $error_messages)));
        exit();
    }
}
$conn->close();
?>
