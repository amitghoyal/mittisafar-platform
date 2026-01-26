<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include database connection
include("../config/db_connect.php");

// Redirect if user is not a host
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'host') {
    header("Location: ../login.php");
    exit();
}

// Fetch host details securely
$user_id = $_SESSION['user_id'];
$query = $conn->prepare("SELECT first_name FROM users WHERE user_id = ?");
$query->bind_param("i", $user_id);
$query->execute();
$query->bind_result($first_name);
$query->fetch();
$query->close();

// Updated statistics query using festival_bookings and festival_services
$sql = "SELECT 
            (SELECT COUNT(*) FROM festival_bookings fb 
             JOIN festival_services fs ON fb.service_id = fs.service_id 
             JOIN hosts h ON fs.host_id = h.host_id 
             WHERE h.user_id = ?) AS total_bookings,
             
            (SELECT COUNT(*) FROM festival_bookings fb 
             JOIN festival_services fs ON fb.service_id = fs.service_id 
             JOIN hosts h ON fs.host_id = h.host_id 
             WHERE h.user_id = ? AND fb.status = 'pending') AS pending_bookings,
             
            (SELECT COUNT(*) FROM festival_bookings fb 
             JOIN festival_services fs ON fb.service_id = fs.service_id 
             JOIN hosts h ON fs.host_id = h.host_id 
             WHERE h.user_id = ? AND fb.status = 'confirmed') AS completed_bookings,
             
            (SELECT COUNT(*) FROM festival_services fs 
             JOIN hosts h ON fs.host_id = h.host_id 
             WHERE h.user_id = ?) AS total_services";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iiii", $user_id, $user_id, $user_id, $user_id);
$stmt->execute();
$stmt->bind_result($total_bookings, $pending_bookings, $completed_bookings, $total_experiences);
$stmt->fetch();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Host Dashboard | MittiSafar</title>
    <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/vendor/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/main.css">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f9f9f9; }
        .dashboard-header { 
            background: linear-gradient(135deg, #d98f4e, #ffb366); 
            color: white; padding: 30px; border-radius: 10px; 
            text-align: center; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); 
            animation: fadeIn 1s ease-in-out; 
        }
        .dashboard-card { 
            border-radius: 10px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); 
            transition: transform 0.3s ease-in-out; background: white; 
            padding: 20px; text-align: center; 
        }
        .dashboard-card:hover { transform: translateY(-8px); }
        .icon-lg { font-size: 3rem; margin-bottom: 10px; }
        .special-section { 
            margin-top: 30px; padding: 20px; background: #fff5e6; 
            border-radius: 10px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); 
            text-align: center; 
        }
        .quick-actions {
            display: flex; justify-content: center; gap: 20px; margin-top: 20px;
        }
        .quick-actions a {
            padding: 12px 20px; font-size: 16px; font-weight: bold; 
            color: white; border-radius: 5px; text-decoration: none; 
            transition: background 0.3s ease-in-out;
        }
        .btn-add-experience { background: #28a745; }
        .btn-view-bookings { background: #007bff; }
        .btn-add-experience:hover { background: #218838; }
        .btn-view-bookings:hover { background: #0056b3; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body>

<?php include("../includes/host_header.php"); ?>

<div class="container mt-4">
    <div class="dashboard-header">
        <h2>Welcome, <?= ucfirst(htmlspecialchars($first_name)); ?>! 🌿</h2>
        <p>Your journey of hosting rural experiences begins here. Let’s create unforgettable memories for travelers!</p>
    </div>

    <!-- Quick Actions -->
    <div class="quick-actions">
        <a href="add_experience.php" class="btn-add-experience">➕ Add Experience</a>
        <a href="view_bookings.php" class="btn-view-bookings">📅 View Bookings</a>
    </div>

    <!-- Statistics -->
    <div class="row mt-4">
        <div class="col-md-3">
            <div class="dashboard-card">
                <i class="bi bi-journal-check icon-lg text-primary"></i>
                <h5>Total Bookings</h5>
                <h3><?= htmlspecialchars($total_bookings); ?></h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="dashboard-card">
                <i class="bi bi-hourglass-split icon-lg text-warning"></i>
                <h5>Pending Bookings</h5>
                <h3><?= htmlspecialchars($pending_bookings); ?></h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="dashboard-card">
                <i class="bi bi-calendar-check icon-lg text-success"></i>
                <h5>Confirmed Bookings</h5>
                <h3><?= htmlspecialchars($completed_bookings); ?></h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="dashboard-card">
                <i class="bi bi-star-fill icon-lg text-danger"></i>
                <h5>Total Experiences</h5>
                <h3><?= htmlspecialchars($total_experiences); ?></h3>
            </div>
        </div>
    </div>

    <div class="special-section">
        <p>"The best way to find yourself is to lose yourself in the service of others." – Mahatma Gandhi</p>
        <p>Stay inspired and keep creating amazing experiences for travelers seeking authenticity!</p>
    </div>
</div>
<br>
<?php include("../includes/footer.php"); ?>

<script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
