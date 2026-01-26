<?php
session_start();
if (!isset($_SESSION['traveler_id'])) {
    echo json_encode(["status" => "error", "message" => "Unauthorized access. Please log in."]);
    exit();
}

include '../config/db_connect.php';

$traveler_id = $_SESSION['traveler_id'];
$booking_id = $_POST['booking_id'] ?? null;

if (!$booking_id) {
    echo json_encode(["status" => "error", "message" => "Invalid request. Booking ID missing."]);
    exit();
}

// Check if the booking exists and belongs to the logged-in traveler
$query = "SELECT * FROM festival_bookings WHERE booking_id = ? AND traveler_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $booking_id, $traveler_id);
$stmt->execute();
$result = $stmt->get_result();
$booking = $result->fetch_assoc();

if (!$booking) {
    echo json_encode(["status" => "error", "message" => "Booking not found or you do not have permission to cancel."]);
    exit();
}

// Check if the booking can be cancelled (only pending or confirmed bookings)
if ($booking['status'] === 'cancelled') {
    echo json_encode(["status" => "error", "message" => "Booking is already cancelled."]);
    exit();
}

if ($booking['payment_status'] === 'paid') {
    // Refund process (if applicable) can be added here.
}

// Update booking status to 'cancelled'
$update_query = "UPDATE festival_bookings SET status = 'cancelled' WHERE booking_id = ?";
$update_stmt = $conn->prepare($update_query);
$update_stmt->bind_param("i", $booking_id);
if ($update_stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Booking cancelled successfully."]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to cancel booking. Please try again."]);
}

$stmt->close();
$update_stmt->close();
$conn->close();
?>
