<?php
session_start();
include '../config/db_connect.php';

if (!isset($_POST['id'])) {
    die("Invalid request.");
}

$service_id = intval($_POST['id']); // Ensure it's an integer

$query = "SELECT title, price, description, festival_name, availability, status, created_at, image FROM festival_services WHERE service_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $service_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    $images = json_decode($row['image'], true) ?: []; // Decode JSON image array, handle invalid JSON
    $availability = json_decode($row['availability'], true) ?: []; // Decode JSON availability, handle invalid JSON
    ?>
    <div class="container">
        <h4 class="mb-3"><?= htmlspecialchars($row['title']); ?></h4>
        <p><strong>Festival:</strong> <?= htmlspecialchars($row['festival_name']); ?></p>
        <p><strong>Price:</strong> ₹<?= htmlspecialchars(number_format($row['price'], 2)); ?></p>

        <p><strong>Availability:</strong></p>
        <ul>
            <?php if (!empty($availability)): ?>
                <?php foreach ($availability as $slot): ?>
                    <li><?= htmlspecialchars($slot); ?></li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>Not available</li>
            <?php endif; ?>
        </ul>

        <p><strong>Status:</strong> 
            <span class="badge bg-<?= $row['status'] === 'approved' ? 'success' : ($row['status'] === 'pending' ? 'warning' : 'danger'); ?>">
                <?= ucfirst($row['status']); ?>
            </span>
        </p>
        <p><strong>Posted On:</strong> <?= date("d M Y, h:i A", strtotime($row['created_at'])); ?></p>
        <p><?= nl2br(htmlspecialchars($row['description'])); ?></p>

        <?php if (!empty($images)): ?>
            <div id="carousel-service" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php foreach ($images as $index => $img): ?>
                        <div class="carousel-item <?= $index === 0 ? 'active' : ''; ?>">
                            <img src="../uploads/<?= htmlspecialchars($img); ?>" class="d-block w-100" alt="Service Image">
                        </div>
                    <?php endforeach; ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carousel-service" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carousel-service" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                </button>
            </div>
        <?php endif; ?>
    </div>
    <?php
} else {
    echo "<p class='text-danger'>Service not found.</p>";
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
