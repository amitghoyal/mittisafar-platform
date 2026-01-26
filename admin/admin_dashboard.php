<?php
session_start();
include '../config/db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

// Fetch Total Users
$result = mysqli_query($conn, "SELECT COUNT(user_id) AS total_users FROM users WHERE user_type IN ('traveler','host')");
$total_users = mysqli_fetch_assoc($result)['total_users'];

// Fetch Total Experiences
$result = mysqli_query($conn, "SELECT COUNT(experience_id) AS total_experiences FROM experiences");
$total_experiences = mysqli_fetch_assoc($result)['total_experiences'];

// Fetch Total Homestays
$result = mysqli_query($conn, "SELECT COUNT(homestay_id) AS total_homestays FROM homestays");
$total_homestays = mysqli_fetch_assoc($result)['total_homestays'];

// Fetch Total Revenue
$result = mysqli_query($conn, "SELECT SUM(amount) AS total_revenue FROM payments WHERE payment_status = 'completed'");
$total_revenue = mysqli_fetch_assoc($result)['total_revenue'] ?? 0;

// Fetch Pending Hosts Approval
$result = mysqli_query($conn, "SELECT COUNT(host_id) AS pending_hosts FROM hosts WHERE verification_status = 'pending'");
$pending_hosts = mysqli_fetch_assoc($result)['pending_hosts'];

// Fetch Total Bookings
$result = mysqli_query($conn, "SELECT COUNT(booking_id) AS total_bookings FROM bookings");
$total_bookings = mysqli_fetch_assoc($result)['total_bookings'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - MittiSafar</title>
    <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/vendor/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/main.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }
        .card:hover {
            transform: translateY(-10px);
        }
        .card-title {
            font-weight: bold;
            color: #593434;
        }
        .card-icon {
            font-size: 3rem;
            color: #D98F4E;
        }
        .quote-card {
            background-image: url('../assets/img/bg-travel.jpg');
            background-size: cover;
            background-position: center;
            color: white;
            text-shadow: 2px 2px 10px rgba(0,0,0,0.5);
            border-radius: 15px;
        }
        .quote-text {
            font-size: 22px;
            font-weight: bold;
        }
        .animate-count {
            font-size: 30px;
            font-weight: bold;
            color: #593434;
        }
    </style>
</head>
<body>

<?php include '../includes/admin_header.php'; ?>

<div class="container mt-4">
    <h3 class="text-center mb-4">💼 Admin Dashboard - MittiSafar</h3>

    <div class="row g-4">

        <!-- Total Users -->
        <div class="col-md-4">
            <div class="card p-3">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">👥 Total Users</h5>
                        <p class="animate-count" data-target="<?= $total_users; ?>">0</p>
                    </div>
                    <i class="bi bi-people card-icon"></i>
                </div>
            </div>
        </div>

        <!-- Total Experiences -->
        <div class="col-md-4">
            <div class="card p-3">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">🌄 Total Experiences</h5>
                        <p class="animate-count" data-target="<?= $total_experiences; ?>">0</p>
                    </div>
                    <i class="bi bi-map card-icon"></i>
                </div>
            </div>
        </div>

        <!-- Total Homestays -->
        <div class="col-md-4">
            <div class="card p-3">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">🏠 Total Homestays</h5>
                        <p class="animate-count" data-target="<?= $total_homestays; ?>">0</p>
                    </div>
                    <i class="bi bi-house-door card-icon"></i>
                </div>
            </div>
        </div>

        <!-- Total Revenue -->
        <div class="col-md-4">
            <div class="card p-3">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">💸 Total Revenue</h5>
                        <p class="animate-count">₹<?= number_format($total_revenue, 2); ?></p>
                    </div>
                    <i class="bi bi-currency-rupee card-icon"></i>
                </div>
            </div>
        </div>

        <!-- Pending Hosts -->
        <div class="col-md-4">
            <div class="card p-3">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">⏳ Pending Hosts</h5>
                        <p class="animate-count" data-target="<?= $pending_hosts; ?>">0</p>
                    </div>
                    <i class="bi bi-person-check card-icon"></i>
                </div>
            </div>
        </div>

        <!-- Total Bookings -->
        <div class="col-md-4">
            <div class="card p-3">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">📅 Total Bookings</h5>
                        <p class="animate-count" data-target="<?= $total_bookings; ?>">0</p>
                    </div>
                    <i class="bi bi-bookmark-check card-icon"></i>
                </div>
            </div>
        </div>

        <!-- Beautiful Travel Quote -->
        <div class="col-12">
            <div class="card p-5 text-center quote-card">
                <h3 class="quote-text">
                    "Travel makes one modest. You see what a tiny place you occupy in the world." 🌍
                </h3>
                <p>- Gustave Flaubert</p>
            </div>
        </div>

    </div>
</div>

<script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script>
// Animate Counter
const counters = document.querySelectorAll('.animate-count');
counters.forEach(counter => {
    counter.innerText = '0';
    const target = +counter.getAttribute('data-target');
    
    const updateCount = () => {
        const count = +counter.innerText;
        const increment = target / 50;
        if(count < target) {
            counter.innerText = Math.ceil(count + increment);
            setTimeout(updateCount, 20);
        }
    }
    updateCount();
});
</script>
</body>
</html>
