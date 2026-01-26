<?php
session_start();
include '../config/db_connect.php';

// Check if host is logged in
if (!isset($_SESSION['host_id'])) {
    echo json_encode(["status" => "error", "message" => "Unauthorized access."]);
    exit();
}

$host_id = $_SESSION['host_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $booking_id = $_POST['booking_id'] ?? '';
    $new_status = $_POST['status'] ?? '';
    
    if (empty($booking_id) || !in_array($new_status, ['pending', 'confirmed', 'cancelled'])) {
        echo json_encode(["status" => "error", "message" => "Invalid request."]);
        exit();
    }
    
    // Verify that the booking belongs to a service offered by this host
    $query = "SELECT fb.booking_id FROM festival_bookings fb
              INNER JOIN festival_services fs ON fb.service_id = fs.service_id
              WHERE fb.booking_id = ? AND fs.host_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ii', $booking_id, $host_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        echo json_encode(["status" => "error", "message" => "Unauthorized action."]);
        exit();
    }
    
    // Update the booking status
    $update_query = "UPDATE festival_bookings SET status = ? WHERE booking_id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param('si', $new_status, $booking_id);
    
    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Booking status updated successfully."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to update booking status."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}
