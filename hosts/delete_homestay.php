<?php
include("../config/db_connect.php");

if (isset($_GET['id'])) {
    $homestay_id = $_GET['id'];

    // Delete homestay from the database
    $stmt = $conn->prepare("DELETE FROM homestays WHERE homestay_id = ?");
    $stmt->bind_param("i", $homestay_id);

    if ($stmt->execute()) {
        header("Location: manage_homestays.php?success=Homestay deleted successfully.");
    } else {
        header("Location: manage_homestays.php?error=Failed to delete homestay.");
    }
}
?>
