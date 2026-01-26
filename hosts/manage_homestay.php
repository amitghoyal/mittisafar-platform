<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include("../config/db_connect.php");

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'host') {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$host_id_query = $conn->prepare("SELECT host_id FROM hosts WHERE user_id = ?");
$host_id_query->bind_param("i", $user_id);
$host_id_query->execute();
$host_id_query->bind_result($host_id);
$host_id_query->fetch();
$host_id_query->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $facilities = json_encode($_POST['facilities']);

    $image_name = "";
    if ($_FILES['image']['error'] == 0) {
        $target_dir = "../uploads/";
        $image_name = time() . "_" . basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image_name;
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
    }

    $stmt = $conn->prepare("INSERT INTO homestays (host_id, name, description, price, facilities, image, status) 
                            VALUES (?, ?, ?, ?, ?, ?, 'pending')");
    $stmt->bind_param("isssss", $host_id, $name, $description, $price, $facilities, $image_name);

    if ($stmt->execute()) {
        $success = "Homestay added successfully!";
    } else {
        $error = "Failed to add homestay.";
    }
}

$homestays = $conn->query("SELECT * FROM homestays WHERE host_id = $host_id");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Homestays | MittiSafar</title>
    <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/vendor/bootstrap-icons/bootstrap-icons.css">
    <style>
        .homestay-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }
        .badge {
            font-size: 14px;
        }
    </style>
</head>
<body>

<?php include("../includes/host_header.php"); ?>

<div class="container mt-4">
    <h3>Manage Homestays</h3>

    <!-- Add Homestay Form -->
    <form action="" method="POST" enctype="multipart/form-data" class="p-4 bg-white rounded shadow mb-4">
        <h5>Add New Homestay</h5>

        <?php if (isset($success)) { ?>
            <div class="alert alert-success"><?= $success; ?></div>
        <?php } ?>

        <?php if (isset($error)) { ?>
            <div class="alert alert-danger"><?= $error; ?></div>
        <?php } ?>

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label>Price (₹ per night)</label>
            <input type="number" name="price" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Facilities</label>
            <input type="text" name="facilities[]" class="form-control" placeholder="e.g. WiFi, AC, Breakfast">
            <input type="text" name="facilities[]" class="form-control mt-2" placeholder="e.g. Pool, Parking">
        </div>
        <div class="mb-3">
            <label>Image</label>
            <input type="file" name="image" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Homestay</button>
    </form>

    <!-- Display Homestays -->
    <div class="row">
        <?php while ($row = $homestays->fetch_assoc()) { ?>
        <div class="col-md-4 mb-4">
            <div class="card homestay-card">
                <img src="../uploads/<?= $row['image']; ?>" alt="Homestay Image">
                <div class="card-body">
                    <h5><?= $row['name']; ?></h5>
                    <p><?= $row['description']; ?></p>
                    <p><strong>Price:</strong> ₹<?= $row['price']; ?> / night</p>
                    <p><strong>Facilities:</strong> <?= implode(', ', json_decode($row['facilities'], true)); ?></p>
                    <p><strong>Status:</strong>
                        <span class="badge bg-<?= $row['status'] == 'approved' ? 'success' : ($row['status'] == 'pending' ? 'warning' : 'danger'); ?>">
                            <?= ucfirst($row['status']); ?>
                        </span>
                    </p>
                    <a href="edit_homestay.php?id=<?= $row['homestay_id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                    <a href="delete_homestay.php?id=<?= $row['homestay_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this homestay?')">Delete</a>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>

<script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
