<?php
session_start();
include '../config/db_connect.php';

// Restrict Access
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

// Fetch Total Counts
$total_hosts = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM hosts"))['total'];
$total_travelers = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM travelers"))['total'];
$total_experiences = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM experiences" ))['total'];
$total_bookings = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM festival_bookings"))['total'];
$total_revenue = 0;

// Calculate Revenue from Festival Bookings
$total_revenue = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT SUM(final_amount) AS total FROM festival_bookings 
    WHERE payment_status='paid'
"))['total'];
$total_revenue = $total_revenue ? $total_revenue : 0;

// Fetch Pending Hosts
$pending_hosts = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM hosts WHERE verification_status='pending'"))['total'];

// Fetch Recent Bookings
$recent_bookings = mysqli_query($conn, "
    SELECT b.booking_id, u.first_name, u.last_name, e.title, b.status
    FROM bookings b
    JOIN travelers t ON b.traveler_id = t.traveler_id
    JOIN users u ON t.user_id = u.user_id
    JOIN experiences e ON b.experience_id = e.experience_id
    ORDER BY b.booking_date DESC
    LIMIT 5
");

// Fetch Recent Hosts
$recent_hosts = mysqli_query($conn, "
    SELECT u.user_id, u.first_name, u.last_name, h.verification_status
    FROM hosts h
    JOIN users u ON h.user_id = u.user_id
    ORDER BY h.created_at DESC
    LIMIT 5
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard | MittiSafar</title>
    <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/vendor/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/main.css">
</head>
<body>

<?php include '../includes/admin_header.php'; ?>
<div class="container mt-4">
<?php if (isset($_SESSION['success_message'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= $_SESSION['success_message']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php unset($_SESSION['success_message']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error_message'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= $_SESSION['error_message']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php unset($_SESSION['error_message']); ?>
<?php endif; ?>

    <h3>Admin Dashboard</h3>
    
    <div class="row">
        <div class="col-md-3">
            <div class="card text-center shadow">
                <div class="card-body">
                    <i class="bi bi-people text-primary" style="font-size: 2rem;"></i>
                    <h5>Total Hosts</h5>
                    <h3><?= $total_hosts; ?></h3>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card text-center shadow">
                <div class="card-body">
                    <i class="bi bi-person text-success" style="font-size: 2rem;"></i>
                    <h5>Total Travelers</h5>
                    <h3><?= $total_travelers; ?></h3>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card text-center shadow">
                <div class="card-body">
                    <i class="bi bi-map text-warning" style="font-size: 2rem;"></i>
                    <h5>Total Experiences</h5>
                    <h3><?= $total_experiences; ?></h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center shadow">
                <div class="card-body">
                    <i class="bi bi-calendar-check text-info" style="font-size: 2rem;"></i>
                    <h5>Total Bookings</h5>
                    <h3><?= $total_bookings; ?></h3>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mt-3">
            <div class="card text-center shadow">
                <div class="card-body">
                    <i class="bi bi-currency-rupee text-primary" style="font-size: 2rem;"></i>
                    <h5>Total Revenue</h5>
                    <h3>₹<?= number_format($total_revenue, 2); ?></h3>
                </div>
            </div>
        </div>
    </div>
    
    <h4 class="mt-5">Latest Bookings</h4>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Traveler</th>
                <th>Experience</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($recent_bookings)): ?>
                <tr>
                    <td><?= $row['first_name'] . ' ' . $row['last_name']; ?></td>
                    <td><?= $row['title']; ?></td>
                    <td><span class="badge bg-success"><?= ucfirst($row['status']); ?></span></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    
    <h4 class="mt-4">Recently Registered Hosts</h4>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Host Name</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($recent_hosts)): ?>
                <tr>
                    <td><?= $row['first_name'] . ' ' . $row['last_name']; ?></td>
                    <td><span class="badge bg-warning"><?= ucfirst($row['verification_status']); ?></span></td>
                    <td>
                        <?php if ($row['verification_status'] == 'pending'): ?>
                            <a href="approve_host.php?id=<?= htmlspecialchars($row['user_id']); ?>" class="btn btn-success btn-sm">Approve</a>
                            <a href="reject_host.php?id=<?= htmlspecialchars($row['user_id']); ?>" class="btn btn-danger btn-sm">Reject</a>
                        <?php else: ?>
                            <span class="badge bg-secondary">Reviewed</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<?php include '../includes/footer.php'; ?>
<script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
