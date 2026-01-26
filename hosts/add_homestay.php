<?php
include '../config/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $host_id = $_POST['host_id'];
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = $_POST['price'];
    $facilities = isset($_POST['facilities']) ? json_encode($_POST['facilities']) : json_encode([]);
    $status = 'pending'; // Default status
    
    // Image Upload Handling
    $image = null;
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "../uploads/";
        $image = time() . "_" . basename($_FILES['image']['name']);
        $target_file = $target_dir . $image;
        move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
    }
    
    // Insert Query
    $query = "INSERT INTO homestays (host_id, name, description, price, facilities, image, status) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "issdsss", $host_id, $name, $description, $price, $facilities, $image, $status);
    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Homestay added successfully!'); window.location.href='manage_homestays.php';</script>";
    } else {
        echo "<script>alert('Error adding homestay.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Homestay</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Add Homestay</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="host_id" value="1"> <!-- Change as per session value -->
        
        <div class="mb-3">
            <label for="name" class="form-label">Homestay Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control" required></textarea>
        </div>
        
        <div class="mb-3">
            <label for="price" class="form-label">Price (₹)</label>
            <input type="number" name="price" class="form-control" step="0.01" required>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Facilities</label><br>
            <input type="checkbox" name="facilities[]" value="WiFi"> WiFi
            <input type="checkbox" name="facilities[]" value="Parking"> Parking
            <input type="checkbox" name="facilities[]" value="Breakfast"> Breakfast
        </div>
        
        <div class="mb-3">
            <label for="image" class="form-label">Upload Image</label>
            <input type="file" name="image" class="form-control">
        </div>
        
        <button type="submit" class="btn btn-primary">Add Homestay</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
