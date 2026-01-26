<?php
session_start();
if (!isset($_SESSION['traveler_id'])) {
    header("Location: ../login.php");
    exit();
}
include '../config/db_connect.php'; // Database connection
include '../config/razorpay_config.php';

// Fetch festival services
$query = "SELECT * FROM festival_services WHERE status = 'approved'";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Festival Services</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Favicons -->
    <link href="../assets/img/favicon.png" rel="icon">
    <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&family=Poppins:wght@300;400;700&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="../assets/css/main.css" rel="stylesheet">

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script> <!-- Razorpay Library -->

    <style>
        .container {
            margin-top: 40px;
        }
        .card {
            border-radius: 10px;
            transition: transform 0.3s ease-in-out;
        }
        .card:hover {
            transform: scale(1.03);
        }
        .btn-primary {
            background-color: #D98F4E;
            border-color: #D98F4E;
        }
        .btn-primary:hover {
            background-color: #593434;
            border-color: #593434;
        }
    </style>
</head>
<body>
<?php
include '../includes/traveler_header.php';
?>
<div class="container">

<h2 class="text-center mb-4">Book Festival Services</h2>

    <div class="row">
        <?php while ($service = mysqli_fetch_assoc($result)) { ?>
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm text-center">
                    <img src="../<?php echo json_decode($service['image'])[0]; ?>" class="card-img-top img-fluid" alt="<?php echo $service['title']; ?>" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $service['title']; ?></h5>
                        <p class="card-text"><?php echo $service['description']; ?></p>
                        <p><strong>Festival:</strong> <?php echo $service['festival_name']; ?></p>
                        <p><strong>Price:</strong> ₹<?php echo number_format($service['price'], 2); ?></p>
                        <button class="btn btn-primary book-btn w-100" 
                            data-bs-toggle="modal" 
                            data-bs-target="#bookingModal"
                            data-service-id="<?php echo $service['service_id']; ?>"
                            data-service-title="<?php echo $service['title']; ?>"
                            data-service-price="<?php echo $service['price']; ?>">
                            Book Now
                        </button>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

    <div class="row">
        <?php while ($service = mysqli_fetch_assoc($result)) { ?>
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    <img src="../<?php echo json_decode($service['image'])[0]; ?>" class="card-img-top" alt="<?php echo $service['title']; ?>">
                    <div class="card-body text-center">
                        <h5 class="card-title"><?php echo $service['title']; ?></h5>
                        <p class="card-text"><?php echo $service['description']; ?></p>
                        <p><strong>Festival:</strong> <?php echo $service['festival_name']; ?></p>
                        <p><strong>Price:</strong> ₹<?php echo number_format($service['price'], 2); ?></p>
                        <button class="btn btn-primary book-btn" data-bs-toggle="modal" 
                            data-bs-target="#bookingModal"
                            data-service-id="<?php echo $service['service_id']; ?>"
                            data-service-title="<?php echo $service['title']; ?>"
                            data-service-price="<?php echo $service['price']; ?>">
                            Book Now
                        </button>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<!-- Booking Modal -->
<div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bookingModalLabel">Book Festival Service</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="bookingForm" method="POST" action="process_festival_booking.php">
                    <input type="hidden" name="service_id" id="service_id">
                    <input type="hidden" name="traveler_id" value="<?php echo $_SESSION['traveler_id']; ?>">

                    <div class="mb-3">
                        <label class="form-label">Service</label>
                        <input type="text" class="form-control" id="service_title" readonly>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Price per Person (₹)</label>
                        <input type="text" class="form-control" id="service_price" readonly>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Booking Date</label>
                        <select class="form-control" name="booking_date" id="booking_date" required>
                            <option value="">Select a date</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Number of People</label>
                        <input type="number" class="form-control" name="num_people" id="num_people" min="1" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Total Price (₹)</label>
                        <input type="text" class="form-control" name="total_price" id="total_price" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">GST (18%)</label>
                        <input type="text" class="form-control" name="gst" id="gst" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Final Amount (₹)</label>
                        <input type="text" class="form-control" name="final_amount" id="final_amount" readonly>
                    </div>
                    <button type="button" class="btn btn-primary w-100" id="payWithRazorpay">Proceed to Payment</button>
                    </form>
            </div>
        </div>
    </div>
</div>
<!-- Bootstrap JS & jQuery -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    // Populate modal with service details and fetch available dates
    $(".book-btn").click(function () {
        let serviceId = $(this).data("service-id");
        let pricePerPerson = $(this).data("service-price");

        $("#service_id").val(serviceId);
        $("#service_title").val($(this).data("service-title"));
        $("#service_price").val(pricePerPerson);

        // Fetch available dates for this service
        $.ajax({
            url: "fetch_festival_availability.php",
            type: "POST",
            data: { service_id: serviceId },
            success: function (response) {
                let dates = JSON.parse(response);
                $("#booking_date").empty().append('<option value="">Select a date</option>');
                dates.forEach(date => {
                    $("#booking_date").append(`<option value="${date}">${date}</option>`);
                });
            }
        });

        // Reset Fields
        $("#num_people").val('');
        $("#total_price").val('');
        $("#gst").val('');
        $("#final_amount").val('');
    });

    // Calculate total price dynamically
    $("#num_people").on("input", function () {
        let numPeople = parseInt($(this).val()) || 0;
        let pricePerPerson = parseFloat($("#service_price").val());

        if (numPeople > 0) {
            let totalPrice = numPeople * pricePerPerson;
            let gstAmount = totalPrice * 0.18; // 18% GST
            let finalAmount = totalPrice + gstAmount;

            $("#total_price").val(totalPrice.toFixed(2));
            $("#gst").val(gstAmount.toFixed(2));
            $("#final_amount").val(finalAmount.toFixed(2));
        } else {
            $("#total_price").val('');
            $("#gst").val('');
            $("#final_amount").val('');
        }
    });

    // Handle booking submission via AJAX
    $("#bookingForm").submit(function (event) {
        event.preventDefault(); 

        $.ajax({
            url: "process_festival_booking.php", 
            type: "POST",
            data: $(this).serialize(),
            success: function (response) {
                alert(response);
                $("#bookingModal").modal("hide");
                $("#bookingForm")[0].reset();
            }
        });
    });
});
</script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
$(document).ready(function () {
    $("#payWithRazorpay").click(function () {
        let serviceId = $("#service_id").val();
        let travelerId = $("input[name='traveler_id']").val();
        let bookingDate = $("#booking_date").val();
        let numPeople = $("#num_people").val();
        let finalAmount = $("#final_amount").val();

        if (!bookingDate || numPeople <= 0) {
            alert("Please select a valid date and number of people.");
            return;
        }

        // Step 1: Create booking and then proceed to payment
        $.ajax({
            url: "process_festival_booking.php",
            type: "POST",
            data: {
                service_id: serviceId,
                traveler_id: travelerId,
                booking_date: bookingDate,
                num_people: numPeople,
                total_price: $("#total_price").val(),
                gst: $("#gst").val(),
                final_amount: finalAmount
            },
            dataType: "json",
            success: function (orderData) {
                if (orderData.status === "success") {
                    let bookingId = orderData.booking_id;  // Store the booking ID

                    $.ajax({
                        url: "create_razorpay_order.php",
                        type: "POST",
                        data: {
                            service_id: serviceId,
                            traveler_id: travelerId,
                            booking_date: bookingDate,
                            num_people: numPeople,
                            amount: finalAmount
                        },
                        dataType: "json", 
                        success: function (orderData) {
                            if (orderData.status === "success") {
                                let options = {
                                    "key": "<?php echo RAZORPAY_KEY_ID; ?>", 
                                    "amount": orderData.amount * 100,
                                    "currency": "INR",
                                    "name": "MittiSafar",
                                    "description": "Festival Service Booking",
                                    "order_id": orderData.order_id,
                                    "handler": function (response) {
                                        // After successful payment, verify the payment
                                        $.ajax({
                                            url: "verify_payment.php",
                                            type: "POST",
                                            data: {
                                                razorpay_payment_id: response.razorpay_payment_id,
                                                razorpay_order_id: response.razorpay_order_id,
                                                razorpay_signature: response.razorpay_signature,
                                                service_id: serviceId,
                                                traveler_id: travelerId,
                                                booking_date: bookingDate,
                                                num_people: numPeople,
                                                amount: finalAmount
                                            },
                                            dataType: "json"
                                        }).done(function (res) {
                                            if (res.status === "success") {
                                                alert("Payment Successful! Booking Confirmed.");
                                                window.location.reload();
                                            } else {
                                                alert("Booking confirmed, but there was an issue: " + res.message);
                                            }
                                        }).fail(function (xhr) {
                                            alert("Payment verification failed. Please contact support.");
                                            console.error("Verification Error:", xhr.responseText);
                                        });
                                    },
                                    "prefill": {
                                        "name": "<?php echo $_SESSION['user_name'] ?? ''; ?>",
                                        "email": "<?php echo $_SESSION['user_email'] ?? ''; ?>",
                                    },
                                    "theme": { "color": "#D98F4E" }
                                };

                                let rzp = new Razorpay(options);
                                rzp.open();
                            } else {
                                alert("Error creating Razorpay order: " + orderData.message);
                            }
                        },
                        error: function (xhr) {
                            alert("Failed to create order. Please try again.");
                            console.error("Order Creation Error:", xhr.responseText);
                        }
                    });
                } else {
                    alert("Error creating booking: " + orderData.message);
                }
            },
            error: function (xhr) {
                alert("Failed to create booking. Please try again.");
                console.error("Booking Creation Error:", xhr.responseText);
            }
        });
    });
});
</script>
<?php include('../includes/footer.php'); ?>
</body>
</html>
