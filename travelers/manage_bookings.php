<?php
session_start();
if (!isset($_SESSION['traveler_id'])) {
    header("Location: ../login.php");
    exit();
}
include '../config/db_connect.php'; // Database connection

$traveler_id = $_SESSION['traveler_id'];

// Fetch traveler's bookings
$query = "SELECT fb.*, fs.title, fs.festival_name, fs.price, fs.image FROM festival_bookings fb 
          JOIN festival_services fs ON fb.service_id = fs.service_id
          WHERE fb.traveler_id = ? ORDER BY fb.created_at DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $traveler_id);
$stmt->execute();
$result = $stmt->get_result();
$bookings = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Bookings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/main.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<?php include '../includes/traveler_header.php'; ?>

<div class="container mt-4">
    <h2 class="text-center mb-4">My Bookings</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Service</th>
                <th>Festival</th>
                <th>Date</th>
                <th>People</th>
                <th>Total Price (₹)</th>
                <th>Status</th>
                <th>Payment</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($bookings as $booking): ?>
            <tr>
                <td><?php echo htmlspecialchars($booking['title']); ?></td>
                <td><?php echo htmlspecialchars($booking['festival_name']); ?></td>
                <td><?php echo $booking['selected_date']; ?></td>
                <td><?php echo $booking['num_people']; ?></td>
                <td>₹<?php echo number_format($booking['final_amount'], 2); ?></td>
                <td><?php echo ucfirst($booking['status']); ?></td>
                <td><?php echo ucfirst($booking['payment_status']); ?></td>
                <td>
                    <?php if ($booking['status'] === 'pending'): ?>
                        <button class="btn btn-danger cancel-booking" data-id="<?php echo $booking['booking_id']; ?>">Cancel</button>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
$(document).on("click", ".cancel-booking", function () {
    if (!confirm("Are you sure you want to cancel this booking?")) return;
    let bookingId = $(this).data("id");

    $.ajax({
        url: "cancel_festival_booking.php",
        type: "POST",
        data: { booking_id: bookingId },
        success: function (response) {
            alert(response);
            location.reload();
        }
    });
});
</script>

<?php include('../includes/footer.php'); ?>
</body>
</html>
