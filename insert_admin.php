<?php
require_once 'config/db_connect.php'; // Include your database connection file

// Admin details
$first_name = "Amit";
$last_name = "Sharma";
$username = "admin_amit";
$email = "amit@example.com";
$phone = "9876543210";
$password = "Admin@123"; // Plaintext password (will be hashed)
$dob = "1990-01-01"; // Change as needed
$gender = "Male";
$nationality = "Indian";
$user_type = "admin";
$status = "active";

// Hash the password
$hashed_password = password_hash($password, PASSWORD_BCRYPT);

// SQL query to insert Amit as admin
$sql = "INSERT INTO users (first_name, last_name, username, email, phone, password, date_of_birth, gender, nationality, user_type, status) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("sssssssssss", $first_name, $last_name, $username, $email, $phone, $hashed_password, $dob, $gender, $nationality, $user_type, $status);
    
    if ($stmt->execute()) {
        echo "Amit has been successfully added as an admin!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Error in preparing statement.";
}

// Close connection
$conn->close();
?>
