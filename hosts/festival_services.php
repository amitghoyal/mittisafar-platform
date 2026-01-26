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

// Fetch host_id
$user_id = $_SESSION['user_id'];
$host_id_query = $conn->prepare("SELECT host_id FROM hosts WHERE user_id = ?");
$host_id_query->bind_param("i", $user_id);
$host_id_query->execute();
$host_id_result = $host_id_query->get_result();
$host_id = $host_id_result->fetch_assoc()['host_id'];

// Handle Add Festival Service
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_service'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $festival_name = $_POST['festival_name'];
    $price = $_POST['price'];
    $availability = json_encode($_POST['availability']);
    $status = 'pending';

    // Handle image upload
    $image_name = "";
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "../uploads/";
        $image_name = time() . "_" . basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image_name;
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
    }

    $stmt = $conn->prepare("INSERT INTO festival_services (host_id, title, description, festival_name, price, availability, image, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssssss", $host_id, $title, $description, $festival_name, $price, $availability, $image_name, $status);

    if ($stmt->execute()) {
        $success = "Festival Service added successfully!";
    } else {
        $error = "Something went wrong. Please try again.";
    }
    $stmt->close();
}

// Handle Delete (after modal confirmation)
if (isset($_POST['delete_service_id'])) {
    $service_id = $_POST['delete_service_id'];
    $conn->query("DELETE FROM festival_services WHERE service_id = $service_id AND host_id = $host_id");
    header("Location: manage_festival_services.php");
    exit();
}

// Fetch all festival services
$result = $conn->query("SELECT * FROM festival_services WHERE host_id = $host_id");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Festival Services | MittiSafar</title>
    <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/vendor/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/main.css">
</head>
<body>

<?php include("../includes/host_header.php"); ?>

<div class="container mt-4">
    <h3>Manage Festival Services 🎉</h3>

    <?php if (isset($success)): ?>
        <div class="alert alert-success"><?= $success; ?></div>
    <?php endif; ?>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error; ?></div>
    <?php endif; ?>

    <!-- Add Festival Service Form -->
    <form action="" method="POST" enctype="multipart/form-data" class="p-4 shadow bg-white rounded">
        <h5>Add New Festival Service</h5>

        <div class="mb-3">
            <label>Service Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control" rows="3" required></textarea>
        </div>

        <div class="mb-3">
            <label>Festival Name</label>
            <input type="text" name="festival_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Price (₹)</label>
            <input type="number" name="price" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Availability Dates</label>
            <input type="text" name="availability[]" class="form-control" placeholder="e.g., 10-12 March">
        </div>

        <div class="mb-3">
            <label>Upload Image</label>
            <input type="file" name="image" class="form-control">
        </div>

        <button type="submit" name="add_service" class="btn btn-primary">Add Service</button>
    </form>

    <!-- Display All Festival Services -->
    <h5 class="mt-4">Your Festival Services</h5>
    <div class="row">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="col-md-4">
                <div class="card mb-3">
                    <img src="../uploads/<?= $row['image']; ?>" class="card-img-top" style="height: 180px;">
                    <div class="card-body">
                        <h5 class="card-title"><?= $row['title']; ?></h5>
                        <p class="card-text"><?= $row['description']; ?></p>
                        <p><strong>Festival: </strong><?= $row['festival_name']; ?></p>
                        <p><strong>Price: ₹</strong><?= $row['price']; ?></p>
                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal" data-service-id="<?= $row['service_id']; ?>">Delete</button>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<!-- Modal for Confirmation -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this festival service? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <form action="" method="POST">
                    <input type="hidden" name="delete_service_id" id="delete_service_id">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include("../includes/footer.php"); ?>

<script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<script>
// Set the service ID in the modal when the delete button is clicked
var deleteModal = document.getElementById('deleteModal');
deleteModal.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget; // Button that triggered the modal
    var serviceId = button.getAttribute('data-service-id'); // Extract service ID
    var modalInput = deleteModal.querySelector('#delete_service_id');
    modalInput.value = serviceId; // Set the service ID in the hidden input
});
</script>

</body>
</html>
