<?php
session_start();
if (!isset($_SESSION['traveler_id'])) {
    header("Location: ../login.php");
    exit();
}

include '../config/db_connect.php';
include '../config/razorpay_config.php'; // Corrected file path

// ✅ Move `require` and `use` to the top
require '../vendor/autoload.php'; 
use Razorpay\Api\Api;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['book_experience'])) {
    $traveler_id = $_SESSION['traveler_id'];
    $experience_id = $_POST['experience_id'];

    // Fetch experience details
    $exp_query = "SELECT title, price FROM experiences WHERE experience_id = ?";
    $stmt = $conn->prepare($exp_query);
    $stmt->bind_param("i", $experience_id);
    $stmt->execute();
    $exp_result = $stmt->get_result();
    $exp_data = $exp_result->fetch_assoc();

    if (!$exp_data) {
        echo "<script>alert('Experience not found!'); window.location.href='explore_experiences.php';</script>";
        exit();
    }

    $experience_title = $exp_data['title'];
    $price = $exp_data['price'];
    $amount = $price * 118 / 100; // Adding 18% GST

    $api = new Api(RAZORPAY_KEY_ID, RAZORPAY_KEY_SECRET);

    try {
        // Create Razorpay Order
        $orderData = $api->order->create([
            'receipt' => 'EXP-' . time(),
            'amount' => $amount * 100, // Convert to paisa
            'currency' => 'INR',
            'payment_capture' => 1 // Auto capture
        ]);

        $razorpayOrderId = $orderData->id; // Corrected object reference

        // Store booking with "pending" status
        $insert_query = "INSERT INTO bookings (traveler_id, experience_id, amount, payment_status, razorpay_order_id) 
                         VALUES (?, ?, ?, 'pending', ?)";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("iiss", $traveler_id, $experience_id, $amount, $razorpayOrderId);
        $stmt->execute();

    } catch (Exception $e) {
        echo "<script>alert('Payment processing error: " . $e->getMessage() . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore Experiences</title>

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
        .card img { height: 200px; object-fit: cover; }
        .btn-primary { background-color: #D98F4E; border-color: #D98F4E; }
        .btn-primary:hover { background-color: #593434; }
    </style>
</head>
<body>

<?php include '../includes/traveler_header.php'; ?>

<div class="container mt-5">
    <h2 class="text-center">Explore Experiences</h2>
    <div class="row">
        <?php
        $query = "SELECT experience_id, title, description, price, image FROM experiences";
        $result = $conn->query($query);

        while ($row = $result->fetch_assoc()) {
            $images = json_decode($row['image'], true);
            if (empty($images)) {
                $images = ["default.jpg"];
            }

            echo '
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    <div id="carousel-'.$row['experience_id'].'" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">';
                            foreach ($images as $index => $img) {
                                $active = ($index === 0) ? 'active' : '';
                                echo '<div class="carousel-item '.$active.'">
                                        <img src="../uploads/'.$img.'" class="d-block w-100" alt="'.$row['title'].'">
                                      </div>';
                            }
            echo '      </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carousel-'.$row['experience_id'].'" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carousel-'.$row['experience_id'].'" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        </button>
                    </div>

                    <div class="card-body text-center">
                        <h5 class="card-title">'.$row['title'].'</h5>
                        <p class="card-text">'.substr($row['description'], 0, 80).'...</p>
                        <p class="fw-bold">₹'.$row['price'].'</p>
                        <form method="POST">
                            <input type="hidden" name="experience_id" value="'.$row['experience_id'].'">
                            <button type="button" class="btn btn-primary" onclick="payNow('.$row['experience_id'].', '.$row['price'].')">Book Now</button>
                        </form>
                    </div>
                </div>
            </div>';
        }
        ?>
    </div>
</div>

<?php include '../includes/footer.php'; ?>

<script>
function payNow(experienceId, price) {
    var options = {
        key: "<?php echo RAZORPAY_KEY_ID; ?>",
        amount: price * 118, // 18% GST
        currency: "INR",
        name: "MittiSafar",
        description: "Booking for Experience",
        handler: function (response) {
            window.location.href = 'verify_payment.php?payment_id=' + response.razorpay_payment_id + '&order_id=' + response.razorpay_order_id;
        }
    };
    var rzp1 = new Razorpay(options);
    rzp1.open();
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
