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

// Handle form submission
$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $group_size = $_POST['group_size'];
    $is_festival = $_POST['is_festival'];
    $availability = json_encode($_POST['availability']);
    $homestay_available = $_POST['homestay_available'];

    // Handle Image Upload
    $image_name = "";
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "../uploads/";
        $image_name = time() . "_" . basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image_name;
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
    }

    // Insert into database
    $host_id_query = $conn->prepare("SELECT host_id FROM hosts WHERE user_id = ?");
    $host_id_query->bind_param("i", $_SESSION['user_id']);
    $host_id_query->execute();
    $host_id_result = $host_id_query->get_result();
    $host_id = $host_id_result->fetch_assoc()['host_id'];

    $stmt = $conn->prepare("INSERT INTO experiences (host_id, title, description, category, is_festival, price, group_size, availability, image, homestay_available, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending')");
    $stmt->bind_param("issssissss", $host_id, $title, $description, $category, $is_festival, $price, $group_size, $availability, $image_name, $homestay_available);

    if ($stmt->execute()) {
        $success = "Experience added successfully! ✅";
    } else {
        $error = "Something went wrong. Please try again.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Experience | MittiSafar</title>
    <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/vendor/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/main.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f5f5;
        }
        .form-control {
            border-radius: 5px;
        }
        .btn-primary {
            background-color: #d98f4e;
            border-color: #d98f4e;
        }
        .btn-primary:hover {
            background-color: #593434;
            border-color: #593434;
        }
        .preview-image {
            max-width: 150px;
            border-radius: 5px;
        }
        .hidden {
            display: none;
        }
    </style>
</head>
<body>

<?php include("../includes/host_header.php"); ?>

<div class="container mt-4">
    <h3>Add New Experience</h3>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error; ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success; ?></div>
    <?php endif; ?>

    <form action="" method="POST" enctype="multipart/form-data" class="p-4 shadow bg-white rounded">
        <!-- Title -->
        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <!-- Description -->
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control" rows="4" required></textarea>
        </div>

        <!-- Category -->
        <div class="mb-3">
            <label>Category</label>
            <select name="category" class="form-control" required>
                <option value="Cooking">Cooking</option>
                <option value="Farming">Farming</option>
                <option value="Handicrafts">Handicrafts</option>
                <option value="Trekking">Trekking</option>
                <option value="Cultural Performance">Cultural Performance</option>
            </select>
        </div>

        <!-- Price -->
        <div class="mb-3">
            <label>Price (₹)</label>
            <input type="number" name="price" class="form-control" required>
        </div>

        <!-- Group Size -->
        <div class="mb-3">
            <label>Group Size</label>
            <input type="number" name="group_size" class="form-control" required>
        </div>

        <!-- Festival-Based Experience -->
        <div class="mb-3">
            <label>Is this a Festival-Based Experience?</label>
            <select name="is_festival" class="form-control" required onchange="toggleFestivalSection(this.value)">
                <option value="no">No</option>
                <option value="yes">Yes</option>
            </select>
        </div>

        <div class="mb-3 hidden" id="festival-section">
            <label>Festival Name</label>
            <input type="text" name="festival_name" class="form-control">
        </div>

        <!-- Availability -->
        <div class="mb-3">
            <label>Availability Dates</label>
            <input type="text" name="availability[]" class="form-control" placeholder="e.g. 10-12 March, 15-18 April">
        </div>

        <!-- Homestay Availability -->
        <div class="mb-3">
            <label>Homestay Available?</label>
            <select name="homestay_available" class="form-control">
                <option value="no">No</option>
                <option value="yes">Yes</option>
            </select>
        </div>

        <!-- Image Upload -->
        <div class="mb-3">
            <label>Upload Experience Image</label>
            <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImage(event)">
            <br>
            <img id="image-preview" class="preview-image hidden">
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Add Experience</button>
    </form>
</div>

<br>
<?php include("../includes/footer.php"); ?>

<script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script>
function toggleFestivalSection(value) {
    const section = document.getElementById('festival-section');
    section.classList.toggle('hidden', value !== 'yes');
}

function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function () {
        const preview = document.getElementById('image-preview');
        preview.src = reader.result;
        preview.classList.remove('hidden');
    };
    reader.readAsDataURL(event.target.files[0]);
}
</script>
</body>
</html>