<?php
session_start();
include '../config/db_connect.php';

// Ensure only admin can access
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

// Check if ID is provided
if (isset($_GET['id'])) {
    $host_id = intval($_GET['id']);

    // Update host verification status
    $update_query = "UPDATE hosts SET verification_status='approved' WHERE user_id=$host_id";
    if (mysqli_query($conn, $update_query)) {
        $_SESSION['success_message'] = "Host approved successfully!";
    } else {
        $_SESSION['error_message'] = "Failed to approve host. Please try again.";
    }
}

// Redirect back to the admin dashboard
header("Location: admin_panel.php");
exit();
?>
