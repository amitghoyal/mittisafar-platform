<?php
include '../config/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['service_id'])) {
    $service_id = intval($_POST['service_id']);

    // Fetch availability JSON from the database
    $query = "SELECT availability FROM festival_services WHERE service_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $service_id);
    $stmt->execute();
    $stmt->bind_result($availability_json);
    $stmt->fetch();
    $stmt->close();

    if ($availability_json) {
        $available_dates = json_decode($availability_json, true);
        echo json_encode($available_dates);
    } else {
        echo json_encode([]);
    }
} else {
    echo json_encode([]);
}
?>
