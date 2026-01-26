<?php
session_start();
require 'config/db_connect.php'; // Include database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and sanitize input values
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone_number'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $date_of_birth = trim($_POST['dob'] ?? '');
    $gender = trim($_POST['gender'] ?? '');
    $nationality = trim($_POST['nationality'] ?? '');
    $emergency_contact = trim($_POST['emergency_contact'] ?? '');
    $profile_photo = $_FILES['profile_photo'] ?? null;

    // Validate required fields
    if (
        empty($first_name) || empty($last_name) || empty($username) || empty($email) ||
        empty($phone) || empty($password) || empty($date_of_birth) || empty($gender) ||
        empty($nationality) || empty($emergency_contact) || !$profile_photo
    ) {
        $_SESSION['error'] = "All required fields must be filled, including profile photo.";
        header("Location: register_traveler.php");
        exit();
    }

    // Validate profile photo
    $upload_dir = 'uploads/profile_photos/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    $photo_path = null;
    if ($profile_photo && $profile_photo['error'] === UPLOAD_ERR_OK) {
        $allowed_types = ['image/jpeg', 'image/png'];
        if (in_array($profile_photo['type'], $allowed_types) && $profile_photo['size'] <= 2.5 * 1024 * 1024) {
            $ext = pathinfo($profile_photo['name'], PATHINFO_EXTENSION);
            $photo_filename = uniqid('profile_', true) . '.' . $ext;
            $photo_path = $upload_dir . $photo_filename;
            move_uploaded_file($profile_photo['tmp_name'], $photo_path);
        } else {
            $_SESSION['error'] = "Invalid profile photo. Must be JPG/PNG and under 2.5 MB.";
            header("Location: register_traveler.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "Profile photo upload failed.";
        header("Location: register_traveler.php");
        exit();
    }

    // Check for duplicate username, email, or phone number
    $check_query = "SELECT * FROM users WHERE username = ? OR email = ? OR phone = ?";
    $stmt = mysqli_prepare($conn, $check_query);
    mysqli_stmt_bind_param($stmt, "sss", $username, $email, $phone);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $existing_user = mysqli_fetch_assoc($result);
        if ($existing_user['username'] === $username) {
            $_SESSION['error'] = "Username is already in use.";
        } elseif ($existing_user['email'] === $email) {
            $_SESSION['error'] = "Email is already in use.";
        } elseif ($existing_user['phone'] === $phone) {
            $_SESSION['error'] = "Phone number is already in use.";
        }
        if ($photo_path && file_exists($photo_path)) {
            unlink($photo_path); // Remove uploaded file if duplicate found
        }
        header("Location: register_traveler.php");
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Start transaction
    mysqli_begin_transaction($conn);

    try {
        // Insert into users table with profile_pic
        $user_query = "INSERT INTO users (first_name, last_name, username, email, phone, password, date_of_birth, gender, nationality, user_type, profile_pic) 
                       VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'traveler', ?)";
        $stmt = mysqli_prepare($conn, $user_query);
        mysqli_stmt_bind_param($stmt, "ssssssssss", $first_name, $last_name, $username, $email, $phone, $hashed_password, $date_of_birth, $gender, $nationality, $photo_path);
        mysqli_stmt_execute($stmt);

        // Get the inserted user ID
        $user_id = mysqli_insert_id($conn);

        // Insert into travelers table
        $traveler_query = "INSERT INTO travelers (user_id, emergency_contact) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $traveler_query);
        mysqli_stmt_bind_param($stmt, "is", $user_id, $emergency_contact);
        mysqli_stmt_execute($stmt);

        // Commit transaction
        mysqli_commit($conn);

        $_SESSION['success'] = "Registration successful! Please log in.";
        header("Location: login.php");
        exit();
    } catch (Exception $e) {
        mysqli_rollback($conn);
        if ($photo_path && file_exists($photo_path)) {
            unlink($photo_path); // Remove photo on failure
        }
        $_SESSION['error'] = "Registration failed: " . mysqli_error($conn);
        header("Location: register_traveler.php");
        exit();
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    $_SESSION['error'] = "Invalid request.";
    header("Location: register_traveler.php");
    exit();
}
?>
