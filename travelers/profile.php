<?php
session_start();
include("../config/db_connect.php"); // Database connection

if (!isset($_SESSION['user_id'])) {
    die("Access Denied. Please <a href='login.php'>Login</a> first.");
}

$user_id = $_SESSION['user_id'];

// Fetch user details
$query = "SELECT * FROM users WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user_result = $stmt->get_result();
$user = $user_result->fetch_assoc();

// Fetch traveler details
$traveler = null;
if ($user['user_type'] === 'traveler') {
    $query = "SELECT * FROM travelers WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $traveler_result = $stmt->get_result();
    $traveler = $traveler_result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Traveler Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/vendor/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/main.css">
    <style>
        body { background-color: #f8f9fa; }
        .profile-container { max-width: 900px; margin: 50px auto; }
        .profile-card { border-radius: 20px; box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2); padding: 20px; }
        .profile-pic { width: 150px; height: 150px; border-radius: 50%; border: 4px solid #ddd; object-fit: cover; }
        .btn-edit { background: #ff758c; border: none; color: white; padding: 10px 20px; }
        .btn-edit:hover { background: #ff527b; }
    </style>
</head>
<body>
<?php include("../includes/traveler_header.php"); ?>

<div class="container profile-container">
    <div class="card profile-card">
        <div class="row">
            <div class="col-md-4 text-center">
                <img src="../<?= htmlspecialchars($user['profile_pic'] ?? 'default.png'); ?>" class="profile-pic">
                <h3 class="mt-3"> <?= htmlspecialchars($user['first_name'] . " " . $user['last_name']); ?> </h3>
                <p class="text-muted">Traveler</p>
                <button class="btn btn-edit mt-3" data-bs-toggle="modal" data-bs-target="#editProfileModal">Edit Profile</button>
            </div>
            <div class="col-md-8">
                <h5>Contact Information</h5>
                <p><strong>Email:</strong> <?= htmlspecialchars($user['email']); ?></p>
                <p><strong>Phone:</strong> <?= htmlspecialchars($user['phone']); ?></p>
                <h5 class="mt-4">Traveler Details</h5>
                <p><strong>Emergency Contact:</strong> <?= htmlspecialchars($traveler['emergency_contact'] ?? "Not Provided"); ?></p>
                <p><strong>Travel Preferences:</strong>
                    <?php
                    if (!empty($traveler['travel_preferences'])) {
                        $preferences = json_decode($traveler['travel_preferences'], true);
                        if (!empty($preferences) && is_array($preferences)) {
                            echo "<ul>";
                            foreach ($preferences as $preference) {
                                echo "<li>" . htmlspecialchars($preference) . "</li>";
                            }
                            echo "</ul>";
                        }
                    } else {
                        echo "Not Provided";
                    }
                    ?>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="update_profile.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="user_id" value="<?= $user_id; ?>">
                    <label>First Name:</label>
                    <input type="text" name="first_name" class="form-control" value="<?= htmlspecialchars($user['first_name']); ?>" required>
                    <label>Last Name:</label>
                    <input type="text" name="last_name" class="form-control" value="<?= htmlspecialchars($user['last_name']); ?>" required>
                    <label>Email:</label>
                    <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']); ?>" required>
                    <label>Phone:</label>
                    <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($user['phone']); ?>" required>
                    <label>Profile Picture:</label>
                    <input type="file" name="profile_pic" class="form-control">
                    <button type="submit" class="btn btn-success mt-3">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php include("../includes/footer.php"); ?>
</body>
</html>
