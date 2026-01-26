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
    $category = $_POST['category'];
    $custom_category = ($category == 'Others') ? trim($_POST['custom_category']) : NULL;
    $price = floatval($_POST['price']);
    $group_size = intval($_POST['group_size']);
    $homestay_available = $_POST['homestay_available'];

    // Handling multiple availability
    $availability_ranges = [];
    if (!empty($_POST['availability_from']) && !empty($_POST['availability_to'])) {
        for ($i = 0; $i < count($_POST['availability_from']); $i++) {
            $from = trim($_POST['availability_from'][$i]);
            $to = trim($_POST['availability_to'][$i]);

            if (!empty($from) && !empty($to)) {
                $availability_ranges[] = [
                    "from" => $from,
                    "to" => $to
                ];
            }
        }
    }
    $availability_json = json_encode($availability_ranges);

    // Validate fields
    if (empty($title) || empty($description)) {
        $errors[] = "Title and description are required.";
    }
    if ($category == 'Others' && empty($custom_category)) {
        $errors[] = "Please specify the custom category.";
    }
    if ($price <= 0 || $group_size <= 0) {
        $errors[] = "Price and group size must be positive values.";
    }
    if (empty($availability_ranges)) {
        $errors[] = "At least one availability slot is required.";
    }

    // Handle Image Uploads
    $image_paths = [];
    if (!empty($_FILES['images']['name'][0])) {
        foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
            $file_name = time() . "_" . $_FILES['images']['name'][$key];
            $file_path = "../uploads/" . $file_name;
            move_uploaded_file($tmp_name, $file_path);
            $image_paths[] = $file_path;
        }
    }
    $image_json = json_encode($image_paths);

    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO experiences (host_id, title, description, category, custom_category, price, group_size, availability, image, homestay_available) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issssdisss", $host_id, $title, $description, $category, $custom_category, $price, $group_size, $availability_json, $image_json, $homestay_available);
        
        if ($stmt->execute()) {
            $success = "Experience added successfully!";
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
    <title>Add Experience | MittiSafar</title>
    <link href="../assets/img/favicon.png" rel="icon">
    <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/main.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</head>

<body>
<?php include("../includes/host_header.php"); ?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Add a New Experience</h2>
    
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
            <label class="form-label">Category</label>
            <select name="category" class="form-control" required>
                <option value="Cooking">Cooking</option>
                <option value="Farming">Farming</option>
                <option value="Handicrafts">Handicrafts</option>
                <option value="Trekking">Trekking</option>
                <option value="Cultural Performance">Cultural Performance</option>
                <option value="Others">Others</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Custom Category (if Others)</label>
            <input type="text" name="custom_category" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Price</label>
            <input type="number" name="price" class="form-control" step="0.01" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Group Size</label>
            <input type="number" name="group_size" class="form-control" required>
        </div>
        
        <div id="availability-section">
            <label class="form-label">Availability (From - To)</label>
            <div id="availability-container">
                <div class="availability-group d-flex">
                    <input type="datetime-local" name="availability_from[]" class="form-control" required>
                    <input type="datetime-local" name="availability_to[]" class="form-control ms-2" required>
                    <button type="button" class="btn btn-danger ms-2 remove-availability">×</button>
                </div>
            </div>
            <button type="button" id="add-availability" class="btn btn-secondary mt-2">Add More</button>
        </div>

        <div class="mb-3">
            <label class="form-label">Upload Images</label>
            <input type="file" name="images[]" class="form-control" multiple>
        </div>
        <div class="mb-3">
            <label class="form-label">Homestay Available?</label>
            <div>
                <input type="radio" name="homestay_available" value="yes"> Yes
                <input type="radio" name="homestay_available" value="no" checked> No
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Add Experience</button>
    </form>
</div>

<?php include("../includes/footer.php"); ?>

<script>
    $(document).ready(function() {
        $("#add-availability").click(function() {
            let availabilityHTML = `
                <div class="availability-group d-flex mt-2">
                    <input type="datetime-local" name="availability_from[]" class="form-control" required>
                    <input type="datetime-local" name="availability_to[]" class="form-control ms-2" required>
                    <button type="button" class="btn btn-danger ms-2 remove-availability">×</button>
                </div>`;
            $("#availability-container").append(availabilityHTML);
        });

        $(document).on("click", ".remove-availability", function() {
            $(this).closest(".availability-group").remove();
        });
    });
</script>

</body>
</html>
