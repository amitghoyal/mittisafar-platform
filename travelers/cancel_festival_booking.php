<?php
session_start();
include '../config/db_connect.php';

if (!isset($_SESSION['traveler_id'])) {
    echo json_encode(["status" => "error", "message" => "Unauthorized access."]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['booking_id'])) {
    $booking_id = intval($_POST['booking_id']);
    $traveler_id = $_SESSION['traveler_id'];

    // Check if the booking exists and belongs to the traveler
    $query = "SELECT status FROM festival_bookings WHERE booking_id = ? AND traveler_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $booking_id, $traveler_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $booking = $result->fetch_assoc();
        if ($booking['status'] === 'pending') {
            // Update the booking status to cancelled
            $update_query = "UPDATE festival_bookings SET status = 'cancelled' WHERE booking_id = ?";
            $update_stmt = $conn->prepare($update_query);
            $update_stmt->bind_param("i", $booking_id);
            if ($update_stmt->execute()) {
                echo json_encode(["status" => "success", "message" => "Booking cancelled successfully."]);
            } else {
                echo json_encode(["status" => "error", "message" => "Failed to cancel booking."]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Only pending bookings can be cancelled."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Booking not found."]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request."]);
}
