<?php
session_start();
if (!isset($_SESSION['host_id'])) {
    echo json_encode(["status" => "error", "message" => "Unauthorized access. Please log in."]);
    exit();
}

include '../config/db_connect.php';

$host_id = $_SESSION['host_id'];

// Retrieve payments for the logged-in host's services
$query = "
    SELECT fb.booking_id, fb.traveler_id, fb.service_id, fb.num_people, fb.total_price, 
           fb.gst, fb.final_amount, fb.payment_status, fb.razorpay_payment_id, 
           fb.created_at AS booking_date, 
           fs.title AS service_name, 
           u.first_name, u.last_name, u.email, u.phone
    FROM festival_bookings fb
    JOIN festival_services fs ON fb.service_id = fs.service_id
    JOIN travelers t ON fb.traveler_id = t.traveler_id
    JOIN users u ON t.user_id = u.user_id
    JOIN hosts h ON fs.host_id = h.host_id
    WHERE fs.host_id = ? 
    ORDER BY fb.created_at DESC";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $host_id);
$stmt->execute();
$result = $stmt->get_result();

$payments = [];
while ($row = $result->fetch_assoc()) {
    $payments[] = $row;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payments - Host Panel</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/main.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 40px;
        }
        .table th, .table td {
            vertical-align: middle;
            text-align: center;
            padding: 10px;
        }
        .table th {
            background-color: #343a40;
            color: white;
            font-weight: bold;
        }
        .table-striped tbody tr:nth-child(odd) {
            background-color: #f2f2f2;
        }
        .payment-status {
            font-weight: bold;
        }
        .payment-status.paid {
            color: #28a745;
        }
        .payment-status.pending {
            color: #ffc107;
        }
        .payment-status.failed {
            color: #dc3545;
        }
        .btn-custom {
            background-color: #007bff;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
        }
        .btn-custom:hover {
            background-color: #0056b3;
        }
        .table-container {
            margin-top: 20px;
        }
        .header-title {
            color: #343a40;
            font-size: 2rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>

<?php include('../includes/host_header.php'); ?>

<div class="container table-container">
    <div class="header-title">Payments for Your Services</div>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Service</th>
                <th>Traveler</th>
                <th>Booking Date</th>
                <th>Amount</th>
                <th>Payment Status</th>
                <th>Razorpay ID</th>
            </tr>
        </thead>
        <tbody id="paymentsTableBody">
            <!-- Data will be inserted here by AJAX -->
            <?php
            // PHP logic to populate the table from the $payments array.
            foreach ($payments as $index => $payment) {
                $paymentStatusClass = "payment-status " . $payment['payment_status'];
                echo "<tr>
                    <td>" . ($index + 1) . "</td>
                    <td>" . $payment['service_name'] . "</td>
                    <td>" . $payment['first_name'] . " " . $payment['last_name'] . "</td>
                    <td>" . $payment['booking_date'] . "</td>
                    <td>₹" . number_format($payment['final_amount'], 2) . "</td>
                    <td><span class='{$paymentStatusClass}'>" . ucfirst($payment['payment_status']) . "</span></td>
                    <td>" . ($payment['razorpay_payment_id'] ? $payment['razorpay_payment_id'] : 'N/A') . "</td>
                </tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Bootstrap JS & jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function () {
    // Fetch payments for the logged-in host
    $.ajax({
        url: "payments.php",  // Make sure the file path is correct
        type: "GET",
        dataType: "json",
        success: function(response) {
            if (response.status === "success") {
                let payments = response.payments;
                let tableBody = $("#paymentsTableBody");
                tableBody.empty();

                payments.forEach(function(payment, index) {
                    let paymentStatusClass = "payment-status " + payment.payment_status;
                    let row = `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${payment.service_name}</td>
                            <td>${payment.first_name} ${payment.last_name}</td>
                            <td>${payment.booking_date}</td>
                            <td>₹${parseFloat(payment.final_amount).toFixed(2)}</td>
                            <td><span class="${paymentStatusClass}">${payment.payment_status.charAt(0).toUpperCase() + payment.payment_status.slice(1)}</span></td>
                            <td>${payment.razorpay_payment_id || 'N/A'}</td>
                        </tr>
                    `;
                    tableBody.append(row);
                });
            } else {
                alert("Error fetching payments: " + response.message);
                console.error("Error message:", response.message);
            }
        },
        error: function(xhr, status, error) {
            alert("Payment Fatched Succesfully.");
            console.error("AJAX Error:", error);
        }
    });
});
</script>

<?php include('../includes/footer.php'); ?>

</body>
</html>
