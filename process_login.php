<?php
session_start();
include 'config/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Fetch user from the database
    $query = "SELECT user_id, username, password, user_type FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        // Verify the password
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_type'] = $user['user_type'];

            // If the user is a traveler, get the traveler_id
            if ($user['user_type'] == 'traveler') {
                $travelerQuery = "SELECT traveler_id FROM travelers WHERE user_id = ?";
                $travelerStmt = mysqli_prepare($conn, $travelerQuery);
                mysqli_stmt_bind_param($travelerStmt, "i", $user['user_id']);
                mysqli_stmt_execute($travelerStmt);
                $travelerResult = mysqli_stmt_get_result($travelerStmt);
                $traveler = mysqli_fetch_assoc($travelerResult);

                if ($traveler) {
                    $_SESSION['traveler_id'] = $traveler['traveler_id']; // Store traveler ID in session
                }
                header("Location: travelers/traveler_panel.php");
                exit();
            } 
            // If the user is an admin
            elseif ($user['user_type'] == 'admin') {
                header("Location: admin/admin_panel.php");
                exit();
            } 
            // If the user is a host, get the host_id
            elseif ($user['user_type'] == 'host') {
                $hostQuery = "SELECT host_id FROM hosts WHERE user_id = ?";
                $hostStmt = mysqli_prepare($conn, $hostQuery);
                mysqli_stmt_bind_param($hostStmt, "i", $user['user_id']);
                mysqli_stmt_execute($hostStmt);
                $hostResult = mysqli_stmt_get_result($hostStmt);
                $host = mysqli_fetch_assoc($hostResult);

                if ($host) {
                    $_SESSION['host_id'] = $host['host_id']; // Store host ID in session
                }
                header("Location: hosts/host_dashboard.php");
                exit();
            }
        } else {
            $_SESSION['error'] = "⚠ Incorrect password. Please try again.";
            header("Location: login.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "⚠ Username does not exist. Please register first.";
        header("Location: login.php");
        exit();
    }
}
?>
