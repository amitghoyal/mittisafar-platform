<?php
session_start();
include '../config/db_connect.php';

if (!isset($_SESSION['host_id'])) {
    die("Unauthorized access.");
}

$host_id = $_SESSION['host_id'];

// Fetch festival services for the logged-in host
$query = "SELECT service_id, title, festival_name, price, image FROM festival_services WHERE host_id = ? ORDER BY created_at DESC";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $host_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result) {
    die("Database query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>My Festival Services</title>

    <!-- Favicons -->
    <link href="../assets/img/favicon.png" rel="icon">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="../assets/css/main.css">

    <!-- Custom Styling -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f7f8fc;
        }
        .card {
            border: none;
            border-radius: 12px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
        .carousel-item img {
            height: 220px;
            object-fit: cover;
            border-radius: 8px;
        }
        .card-title {
            font-size: 1.2rem;
            font-weight: 600;
        }
        .btn-view {
            background: linear-gradient(45deg, #007bff, #6610f2);
            border: none;
            padding: 10px 16px;
            transition: 0.3s;
            border-radius: 8px;
        }
        .btn-view:hover {
            background: linear-gradient(45deg, #6610f2, #007bff);
        }
        .modal-content {
            border-radius: 12px;
            overflow: hidden;
            animation: slideIn 0.4s ease-in-out;
        }
        @keyframes slideIn {
            from { transform: translateY(-30px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>

<?php include_once("../includes/host_header.php"); ?>

<main class="main">
    <div class="container mt-5">
        <h2 class="text-center mb-4">My Festival Services</h2>
        <div class="row gy-4">
            <?php while ($row = mysqli_fetch_assoc($result)): 
                $images = json_decode($row['image'], true); // Decode JSON image array
            ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card shadow-lg">
                        <!-- Bootstrap Carousel for Multiple Images -->
                        <div id="carousel-<?= $row['service_id']; ?>" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <?php foreach ($images as $index => $img): ?>
                                    <div class="carousel-item <?= $index === 0 ? 'active' : ''; ?>">
                                        <img src="../<?= htmlspecialchars($img); ?>" class="d-block w-100" alt="<?= htmlspecialchars($row['title']); ?>">
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <!-- Controls -->
                            <button class="carousel-control-prev" type="button" data-bs-target="#carousel-<?= $row['service_id']; ?>" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carousel-<?= $row['service_id']; ?>" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            </button>
                        </div>

                        <div class="card-body text-center">
                            <h5 class="card-title"><?= htmlspecialchars($row['title']); ?></h5>
                            <p class="text-muted"><strong>Festival:</strong> <?= htmlspecialchars($row['festival_name']); ?></p>
                            <p class="text-dark"><strong>Price:</strong> ₹<?= htmlspecialchars($row['price']); ?></p>
                            <button class="btn btn-view text-white view-details" data-id="<?= $row['service_id']; ?>">View Details</button>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</main>

<!-- Modal for Festival Service Details -->
<div class="modal fade" id="festivalServiceModal" tabindex="-1" aria-labelledby="festivalServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animate__animated animate__fadeIn">
            <div class="modal-header">
                <h5 class="modal-title" id="festivalServiceModalLabel">Service Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalContent">
                <!-- Dynamic content will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php include_once("../includes/footer.php"); ?>

<!-- Vendor JS -->
<script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
    $(".view-details").click(function() {
        var serviceId = $(this).data("id");

        $.ajax({
            url: "fetch_festival_service_details.php",
            type: "POST",
            data: { id: serviceId },
            success: function(response) {
                $("#modalContent").html(response);
                $("#festivalServiceModal").modal("show");
            }
        });
    });
});
</script>

</body>
</html>
