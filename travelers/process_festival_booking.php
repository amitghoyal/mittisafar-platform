<?php
session_start();
include '../config/db_connect.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $traveler_id = $_SESSION['traveler_id'] ?? null;
    $service_id = $_POST['service_id'] ?? null;
    $booking_date = $_POST['booking_date'] ?? null;
    $num_people = $_POST['num_people'] ?? 1;
    $total_price = $_POST['total_price'] ?? 0;
    $gst = $_POST['gst'] ?? 0;
    $final_amount = $_POST['final_amount'] ?? 0;

    if (!$traveler_id || !$service_id || !$booking_date || $num_people <= 0 || $final_amount <= 0) {
        echo json_encode(["status" => "error", "message" => "Invalid booking details."]);
        exit();
    }

    // Check if the service exists and is approved
    $service_query = "SELECT * FROM festival_services WHERE service_id = ? AND status = 'approved'";
    $stmt = $conn->prepare($service_query);
    $stmt->bind_param('i', $service_id);
    $stmt->execute();
    $service_result = $stmt->get_result();

    if ($service_result->num_rows === 0) {
        echo json_encode(["status" => "error", "message" => "Service not found or not available."]);
        exit();
    }

    // Insert booking as pending before payment
    $insert_query = "INSERT INTO festival_bookings (traveler_id, service_id, selected_date, num_people, total_price, gst, final_amount, status) VALUES (?, ?, ?, ?, ?, ?, ?, 'pending')";
    $stmt = $conn->prepare($insert_query);
    $stmt->bind_param('iisdddd', $traveler_id, $service_id, $booking_date, $num_people, $total_price, $gst, $final_amount);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $booking_id = $stmt->insert_id;
        echo json_encode(["status" => "success", "booking_id" => $booking_id]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to create booking."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}
?>
