<?php
include '../config/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['service_id'])) {
    $service_id = $_POST['service_id'];

    // Fetch service details
    $query = "SELECT availability, max_group_size FROM festival_services WHERE service_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $service_id);
    $stmt->execute();
    $stmt->bind_result($availability_json, $max_group_size);
    $stmt->fetch();
    $stmt->close();

    if ($availability_json) {
        $available_dates = json_decode($availability_json, true);
        $filtered_dates = [];

        foreach ($available_dates as $date) {
            // Count existing bookings for this date
            $booking_query = "SELECT SUM(num_people) FROM festival_bookings WHERE service_id = ? AND selected_date	= ?";
            $stmt = $conn->prepare($booking_query);
            $stmt->bind_param("is", $service_id, $date);
            $stmt->execute();
            $stmt->bind_result($total_booked);
            $stmt->fetch();
            $stmt->close();

            $total_booked = $total_booked ?? 0;
            $remaining_slots = $max_group_size - $total_booked;

            // If slots are available, add to available dates list
            if ($remaining_slots > 0) {
                $filtered_dates[] = ["date" => $date, "remaining_slots" => $remaining_slots];
            }
        }

        // Return filtered available dates
        echo json_encode($filtered_dates);
    } else {
        echo json_encode([]);
    }
} else {
    echo json_encode([]);
}
?>
