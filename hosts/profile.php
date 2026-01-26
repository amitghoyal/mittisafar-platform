<?php
session_start();
include("../config/db_connect.php"); // Database connection

if (!isset($_SESSION['user_id'])) {
    die("Access Denied. Please <a href='login.php'>Login</a> first.");
}

$user_id = $_SESSION['user_id'];
$host_id = isset($_SESSION['host_id']) ? $_SESSION['host_id'] : null;

// Fetch user details
$query = "SELECT * FROM users WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user_result = $stmt->get_result();
$user = $user_result->fetch_assoc();

if (!$user) {
    die("User not found.");
}

// Fetch host details if available
$host = null;
if ($host_id) {
    $query = "SELECT * FROM hosts WHERE host_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $host_id);
    $stmt->execute();
    $host_result = $stmt->get_result();
    $host = $host_result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Host Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/main.css">
    <style>
        .profile-container { max-width: 900px; margin: 50px auto; display: flex; gap: 20px; }
        .profile-sidebar { width: 35%; text-align: center; padding: 20px; background: #f8f9fa; border-radius: 10px; }
        .profile-content { width: 65%; padding: 20px; background: white; border-radius: 10px; box-shadow: 0px 4px 10px rgba(0,0,0,0.1); }
        .profile-pic { width: 150px; height: 150px; border-radius: 50%; object-fit: cover; margin-bottom: 15px; }
        .edit-btn { margin-top: 15px; }
    </style>
</head>
<body class="bg-light">
<?php include("../includes/host_header.php"); ?>

<div class="container profile-container">
    <!-- Sidebar Profile -->
    <div class="profile-sidebar">
        <?php if (!empty($user['profile_pic'])): ?>
            <img src="../<?= htmlspecialchars($user['profile_pic']); ?>" class="profile-pic">
        <?php else: ?>
            <img src="https://via.placeholder.com/150" class="profile-pic">
        <?php endif; ?>
        <h4><?= htmlspecialchars($user['first_name'] . " " . $user['last_name']); ?></h4>
        <p class="text-muted">Host</p>
        <a href="update_profile.php" class="btn btn-primary edit-btn">Edit Profile</a>
    </div>

    <!-- Profile Details -->
    <div class="profile-content">
        <h5>Personal Details</h5>
        <p><strong>Email:</strong> <?= htmlspecialchars($user['email']); ?></p>
        <p><strong>Phone:</strong> <?= htmlspecialchars($user['phone']); ?></p>
        <hr>
        
        <?php if ($host): ?>
            <h5>Host Information</h5>
            <p><strong>State:</strong> <?= htmlspecialchars($host['state'] ?? "Not Provided"); ?></p>
            <p><strong>District:</strong> <?= htmlspecialchars($host['district'] ?? "Not Provided"); ?></p>
            <p><strong>Village:</strong> <?= htmlspecialchars($host['village'] ?? "Not Provided"); ?></p>
            <p><strong>Pincode:</strong> <?= htmlspecialchars($host['pincode'] ?? "Not Provided"); ?></p>
            <p><strong>Languages Spoken:</strong> <?= htmlspecialchars($host['languages_spoken'] ?? "Not Provided"); ?></p>
        <?php endif; ?>
    </div>
</div>

<?php include("../includes/footer.php"); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
