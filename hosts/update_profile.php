<?php
session_start();
include("../config/db_connect.php"); // Database connection

if (!isset($_SESSION['user_id']) || !isset($_SESSION['host_id'])) {
    die("Access Denied. Please <a href='login.php'>Login</a> first.");
}

$user_id = $_SESSION['user_id'];
$host_id = $_SESSION['host_id'];

// Fetch user details
$query = "SELECT * FROM users WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

// Fetch host details
$query = "SELECT * FROM hosts WHERE host_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $host_id);
$stmt->execute();
$host = $stmt->get_result()->fetch_assoc();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $bio = $_POST['bio'];
    $state = $_POST['state'];
    $district = $_POST['district'];
    $village = $_POST['village'];
    $pincode = $_POST['pincode'];
    $languages_spoken = $_POST['languages_spoken'];
    $experience_years = $_POST['experience_years'];
    $homestay_available = $_POST['homestay_available'];

    // Handle Image Upload
    if (!empty($_FILES["profile_pic"]["name"])) {
        $target_dir = "../uploads/";
        $imageFileType = strtolower(pathinfo($_FILES["profile_pic"]["name"], PATHINFO_EXTENSION));
        $new_filename = "uploads/".time()."." . $imageFileType;
        $target_file = $target_dir . $new_filename;

        // Validate file type
        $allowed_types = ["jpg", "jpeg", "png"];
        if (!in_array($imageFileType, $allowed_types)) {
            echo "Only JPG, JPEG, and PNG files are allowed.";
            exit;
        }

        // Move uploaded file
        if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_file)) {
            // Update user profile pic in DB
            $query = "UPDATE users SET profile_pic = ? WHERE user_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("si", $target_file, $user_id);
            $stmt->execute();
        } else {
            echo "Error uploading image.";
        }
    }

    // Update user details
    $query = "UPDATE users SET first_name = ?, last_name = ?, email = ?, phone = ? WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssi", $first_name, $last_name, $email, $phone, $user_id);
    $stmt->execute();

    // Update host details
    $query = "UPDATE hosts SET bio = ?, state = ?, district = ?, village = ?, pincode = ?, languages_spoken = ?, experience_years = ?, homestay_available = ? WHERE host_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssssii", $bio, $state, $district, $village, $pincode, $languages_spoken, $experience_years, $homestay_available, $host_id);
    $stmt->execute();

    echo "<script>alert('Profile Updated Successfully!'); window.location.href='profile.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Host Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/vendor/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/main.css">
</head>
<body class="bg-light">
<?php include("../includes/host_header.php"); ?>

<div class="container mt-5">
    <div class="card">
        <div class="card-header bg-primary text-white text-center">
            <h2>Edit Host Profile</h2>
        </div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <!-- Profile Picture -->
                <div class="text-center mb-3">
                    <img src="<?= !empty($user['profile_pic']) ? "../" . $user['profile_pic'] : 'https://via.placeholder.com/130'; ?>" class="rounded-circle" width="130">
                    <input type="file" name="profile_pic" class="form-control mt-2">
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label>First Name</label>
                        <input type="text" name="first_name" class="form-control" value="<?= htmlspecialchars($user['first_name']); ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label>Last Name</label>
                        <input type="text" name="last_name" class="form-control" value="<?= htmlspecialchars($user['last_name']); ?>" required>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']); ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label>Phone</label>
                        <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($user['phone']); ?>" required>
                    </div>
                </div>

                <div class="mt-3">
                    <label>Bio</label>
                    <textarea name="bio" class="form-control" rows="3"><?= htmlspecialchars($host['bio']); ?></textarea>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <label>State</label>
                        <input type="text" name="state" class="form-control" value="<?= htmlspecialchars($host['state']); ?>">
                    </div>
                    <div class="col-md-6">
                        <label>District</label>
                        <input type="text" name="district" class="form-control" value="<?= htmlspecialchars($host['district']); ?>">
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <label>Village</label>
                        <input type="text" name="village" class="form-control" value="<?= htmlspecialchars($host['village']); ?>">
                    </div>
                    <div class="col-md-6">
                        <label>Pincode</label>
                        <input type="text" name="pincode" class="form-control" value="<?= htmlspecialchars($host['pincode']); ?>">
                    </div>
                </div>

                <div class="mt-3">
                    <label>Languages Spoken</label>
                    <input type="text" name="languages_spoken" class="form-control" value="<?= htmlspecialchars($host['languages_spoken']); ?>">
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <label>Experience (Years)</label>
                        <input type="number" name="experience_years" class="form-control" value="<?= htmlspecialchars($host['experience_years']); ?>">
                    </div>
                    <div class="col-md-6">
                        <label>Homestay Available</label>
                        <select name="homestay_available" class="form-control">
                            <option value="1" <?= $host['homestay_available'] ? "selected" : ""; ?>>Yes</option>
                            <option value="0" <?= !$host['homestay_available'] ? "selected" : ""; ?>>No</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-success mt-3 w-100">Update Profile</button>
            </form>
        </div>
    </div>
</div>

<?php include("../includes/footer.php"); ?>
</body>
</html>
