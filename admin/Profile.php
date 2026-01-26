<?php
session_start();
include("../config/db_connect.php"); // Database connection

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    die("Access Denied. Please <a href='../login.php'>Login</a> first.");
}

$user_id = $_SESSION['user_id'];

// Fetch Admin Details
$query = "SELECT * FROM users WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user_result = $stmt->get_result();
$user = $user_result->fetch_assoc();

if (!$user) {
    die("Admin not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/main.css">
    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .profile-container {
            max-width: 900px;
            margin: 60px auto;
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            padding: 30px;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
        }

        .profile-sidebar {
            flex: 1 1 280px;
            text-align: center;
            padding: 20px;
        }

        .profile-content {
            flex: 2 1 500px;
            padding: 10px 20px;
        }

        .profile-pic {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 15px;
            border: 4px solid #e2e6ea;
        }

        .profile-content h5 {
            font-weight: bold;
            margin-bottom: 20px;
            color: #343a40;
        }

        .profile-content p {
            font-size: 16px;
            margin: 6px 0;
            color: #495057;
        }

        .profile-content p strong {
            color: #212529;
        }

        .text-muted {
            color: #6c757d !important;
        }
    </style>
</head>
<body>
<?php include("../includes/admin_header.php"); ?>

<div class="container profile-container shadow-sm">
    <!-- Sidebar -->
    <div class="profile-sidebar">
        <?php if (!empty($user['profile_pic'])): ?>
            <img src="../<?= htmlspecialchars($user['profile_pic']); ?>" class="profile-pic" alt="Profile Picture">
        <?php else: ?>
            <img src="https://via.placeholder.com/150" class="profile-pic" alt="Default Profile">
        <?php endif; ?>
        <h4 class="mt-2"><?= htmlspecialchars($user['first_name'] . " " . $user['last_name']); ?></h4>
        <p class="text-muted mb-0">Administrator</p>
    </div>

    <!-- Main Profile Info -->
    <div class="profile-content">
        <h5>Personal Details</h5>
        <p><strong>Email:</strong> <?= htmlspecialchars($user['email']); ?></p>
        <p><strong>Phone:</strong> <?= htmlspecialchars($user['phone']); ?></p>
        <p><strong>Username:</strong> <?= htmlspecialchars($user['username']); ?></p>
        <p><strong>Date of Birth:</strong> <?= htmlspecialchars($user['date_of_birth']); ?></p>
        <p><strong>Gender:</strong> <?= htmlspecialchars($user['gender']); ?></p>
        <p><strong>Nationality:</strong> <?= htmlspecialchars($user['nationality']); ?></p>
    </div>
</div>

<?php include("../includes/footer.php"); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
