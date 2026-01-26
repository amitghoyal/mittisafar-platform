<?php
include '../config/db_connect.php';

if (isset($_POST['id'])) {
    $experience_id = intval($_POST['id']);

    $query = "SELECT * FROM experiences WHERE experience_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $experience_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $images = json_decode($row['image'], true); // Decode JSON images
        $availability = json_decode($row['availability'], true); // Decode JSON availability
        ?>
        <div class="container">
            <h4 class="text-primary"><?= htmlspecialchars($row['title']); ?></h4>
            <p><strong>Category:</strong> <?= htmlspecialchars($row['category']); ?></p>
            <p><strong>Price:</strong> ₹<?= htmlspecialchars($row['price']); ?></p>
            <p><strong>Group Size:</strong> <?= htmlspecialchars($row['group_size']); ?></p>

            <!-- Display Availability Properly -->
            <p><strong>Availability:</strong>
                <?php 
                if (!empty($availability)) {
                    echo "<ul>";
                    foreach ($availability as $range) {
                        echo "<li><strong>From:</strong> " . htmlspecialchars($range['from']) . " <strong>To:</strong> " . htmlspecialchars($range['to']) . "</li>";
                    }
                    echo "</ul>";
                } else {
                    echo "<span class='text-muted'>No availability set.</span>";
                }
                ?>
            </p>

            <p><strong>Description:</strong> <?= nl2br(htmlspecialchars($row['description'])); ?></p>
            <p><strong>Homestay Available:</strong> <?= ucfirst($row['homestay_available']); ?></p>
            <p><strong>Status:</strong> <?= ucfirst($row['status']); ?></p>

            <!-- Bootstrap Carousel for Images -->
            <?php if (!empty($images)) { ?>
                <div id="experienceCarousel" class="carousel slide mt-3" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php foreach ($images as $index => $image) { ?>
                            <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                <img src="../uploads/<?= htmlspecialchars($image); ?>" class="d-block w-100" alt="Experience Image">
                            </div>
                        <?php } ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#experienceCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#experienceCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            <?php } else { ?>
                <p class="text-muted">No images available.</p>
            <?php } ?>

        </div>
        <?php
    } else {
        echo "<p class='text-danger'>Experience not found.</p>";
    }
}
?>
<!-- Include Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
