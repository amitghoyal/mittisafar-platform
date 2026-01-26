<?php
session_start();
if (!isset($_SESSION['host_id'])) {
    header("Location: ../login.php");
    exit();
}
include '../config/db_connect.php';

$host_id = $_SESSION['host_id'];
$query = "SELECT fb.*, fs.title AS service_title, t.user_id, u.first_name, u.last_name, u.email, u.phone 
          FROM festival_bookings fb
          JOIN festival_services fs ON fb.service_id = fs.service_id
          JOIN travelers t ON fb.traveler_id = t.traveler_id
          JOIN users u ON t.user_id = u.user_id
          WHERE fs.host_id = ?
          ORDER BY fb.created_at DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $host_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Bookings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include '../includes/host_header.php'; ?>
<div class="container mt-4">
    <h2 class="text-center mb-4">Manage Bookings</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Traveler</th>
                <th>Service</th>
                <th>Booking Date</th>
                <th>People</th>
                <th>Total Price</th>
                <th>Payment Status</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['first_name'] . ' ' . $row['last_name'] . "<br>" . $row['email'] . "<br>" . $row['phone']; ?></td>
                    <td><?php echo $row['service_title']; ?></td>
                    <td><?php echo $row['selected_date']; ?></td>
                    <td><?php echo $row['num_people']; ?></td>
                    <td>₹<?php echo number_format($row['final_amount'], 2); ?></td>
                    <td><?php echo ucfirst($row['payment_status']); ?></td>
                    <td>
                        <form method="POST" action="update_booking_status.php">
                            <input type="hidden" name="booking_id" value="<?php echo $row['booking_id']; ?>">
                            <select name="status" class="form-select">
                                <option value="pending" <?php echo ($row['status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                                <option value="confirmed" <?php echo ($row['status'] == 'confirmed') ? 'selected' : ''; ?>>Confirmed</option>
                                <option value="cancelled" <?php echo ($row['status'] == 'cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                            </select>
                            <button type="submit" class="btn btn-primary btn-sm mt-2">Update</button>
                        </form>
                    </td>
                    <td>
                        <?php if ($row['status'] != 'cancelled') { ?>
                            <form method="POST" action="cancel_festival_booking.php" onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                                <input type="hidden" name="booking_id" value="<?php echo $row['booking_id']; ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Cancel</button>
                            </form>
                        <?php } else { echo "Cancelled"; } ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<?php include '../includes/footer.php'; ?>
</body>
</html>
