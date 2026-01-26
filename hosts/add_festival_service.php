<?php
session_start();
include("../config/db_connect.php");

// Redirect if user is not a host
if (!isset($_SESSION['host_id']) || $_SESSION['user_type'] != 'host') {
    header("Location: ../login.php");
    exit();
}

$host_id = $_SESSION['host_id'];
$errors = [];
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $festival_name = trim($_POST['festival_name']);
    $price = floatval($_POST['price']);
    $max_group_size = intval($_POST['max_group_size']);

    // Process availability JSON
    $availability = [];
    if (!empty($_POST['availability'])) {
        foreach ($_POST['availability'] as $slot) {
            if (!empty($slot)) {
                $availability[] = $slot;
            }
        }
    }
    $availability_json = json_encode($availability, JSON_UNESCAPED_SLASHES);

    // Validate fields
    if (empty($title) || empty($description) || empty($festival_name)) {
        $errors[] = "Title, description, and festival name are required.";
    }
    if ($price <= 0) {
        $errors[] = "Price must be a positive value.";
    }
    if ($max_group_size <= 0) {
        $errors[] = "Max group size must be at least 1.";
    }
    if (empty($availability)) {
        $errors[] = "At least one availability slot is required.";
    }

    // Handle Image Uploads
    $image_paths = [];
    if (!empty($_FILES['images']['name'][0])) {
        foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
            $file_name = time() . "_" . $_FILES['images']['name'][$key];
            $file_path = "uploads/" . $file_name; // Store relative path
            move_uploaded_file($tmp_name, "../" . $file_path);
            $image_paths[] = $file_path;
        }
    }
    $image_json = json_encode($image_paths, JSON_UNESCAPED_SLASHES);

    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO festival_services 
            (host_id, title, description, festival_name, price, availability, max_group_size, image, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending')");

        $stmt->bind_param("isssdiss", $host_id, $title, $description, $festival_name, $price, $availability_json, $max_group_size, $image_json);

        if ($stmt->execute()) {
            $success = "Festival service added successfully!";
        } else {
            $errors[] = "Database error: " . $stmt->error;
        }
        $stmt->close();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Festival Service | MittiSafar</title>
    <link href="../assets/img/favicon.png" rel="icon">
    <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.min.css">
    <link rel="stylesheet" href="../assets/css/main.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"></script>
</head>

<body>
<?php include("../includes/host_header.php"); ?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Add a Festival Service</h2>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger"> <?= implode('<br>', $errors) ?> </div>
    <?php endif; ?>
    <?php if ($success): ?>
        <div class="alert alert-success"> <?= $success ?> </div> 
    <?php endif; ?>

    <form action="" method="POST" enctype="multipart/form-data" class="p-4 border rounded bg-light">
        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Festival Name</label>
            <input type="text" name="festival_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Price</label>
            <input type="number" name="price" class="form-control" step="0.01" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Max Group Size</label>
            <input type="number" name="max_group_size" class="form-control" min="1" required>
        </div>
        
        <!-- Dynamic Availability Fields -->
        <div class="mb-3">
            <label class="form-label">Availability (Date & Time)</label>
            <div id="availability-container">
                <div class="input-group mb-2">
                    <input type="text" name="availability[]" class="form-control datetimepicker" placeholder="Select date & time" required>
                    <button type="button" class="btn btn-danger remove-slot" style="display: none;">Remove</button>
                </div>
            </div>
            <button type="button" id="add-slot" class="btn btn-success btn-sm">+ Add More Slots</button>
        </div>

        <div class="mb-3">
            <label class="form-label">Upload Images</label>
            <input type="file" name="images[]" class="form-control" multiple>
        </div>
        <button type="submit" class="btn btn-primary w-100">Add Festival Service</button>
    </form>
</div>

<script>
$(document).ready(function () {
    $(".datetimepicker").datetimepicker({
        format: 'Y-m-d H:i',
        step: 30,
        minDate: 0,
        onShow: function () {
            this.setOptions({ minDate: 0 });
        }
    });

    $("#add-slot").click(function () {
        let newSlot = `
            <div class="input-group mb-2">
                <input type="text" name="availability[]" class="form-control datetimepicker" placeholder="Select date & time" required>
                <button type="button" class="btn btn-danger remove-slot">Remove</button>
            </div>
        `;
        $("#availability-container").append(newSlot);
        $(".datetimepicker").datetimepicker({
            format: 'Y-m-d H:i',
            step: 30,
            minDate: 0
        });
    });

    $(document).on("click", ".remove-slot", function () {
        $(this).closest(".input-group").remove();
    });
});
</script>

<?php include("../includes/footer.php"); ?>
</body>
</html>
