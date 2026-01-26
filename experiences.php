<?php
include 'config/db_connect.php';

// Fetch experiences
$query = "SELECT * FROM experiences_about ORDER BY delay ASC";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Database query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Experiences - MittiSafar</title>

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/vendor/bootstrap-icons/bootstrap-icons.css">
  <link rel="stylesheet" href="assets/vendor/aos/aos.css">
  <link rel="stylesheet" href="assets/vendor/glightbox/css/glightbox.min.css">
  <link rel="stylesheet" href="assets/vendor/swiper/swiper-bundle.min.css">
  <link rel="stylesheet" href="assets/css/main.css">
  
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&family=Poppins:wght@100;200;300;400;500;600;700;800;900&family=Raleway:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>

<body class="about-page">
<?php include_once("includes/header.php"); ?>

<main class="main">

<!-- Page Title -->
<div class="page-title light-background">
    <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Authentic Rural Experiences</h1>
        <nav class="breadcrumbs">
            <ol>
                <li><a href="index.php">Home</a></li>
                <li class="current">Experiences</li>
            </ol>
        </nav>
    </div>
</div><!-- End Page Title -->

<!-- Experiences Section -->
<section id="experiences" class="experiences section">
    <div class="container" data-aos="fade-up">

        <div class="section-title text-center">
            <h2>Live the Soul of India</h2>
            <p>Step away from the ordinary and embrace the warmth of rural life. These experiences will leave footprints in your heart forever.</p>
        </div>

        <div class="row gy-4">
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="<?= htmlspecialchars($row['delay']); ?>">
                    <div class="experience-card shadow-lg p-4 rounded">
                        <div class="pic mb-3">
                            <img src="assets/img/experiences/<?= htmlspecialchars($row['image']); ?>" class="img-fluid rounded shadow" alt="<?= htmlspecialchars($row['title']); ?>">
                        </div>
                        <h4><?= htmlspecialchars($row['title']); ?></h4>
                        <p><?= htmlspecialchars($row['description']); ?></p>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <!-- Call to Action -->
        <div class="text-center mt-5" data-aos="fade-up" data-aos-delay="700">
            <h4>Ready to Create Your Own Story?</h4>
            <p>Book an experience and live the magic of rural India.</p>
            <a href="login.php" class="btn btn-primary">Book Your Experience</a>
        </div>

    </div>
</section><!-- /Experiences Section -->

</main>

<?php include_once("includes/footer.php"); ?>

<!-- Scroll Top -->
<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS -->
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/aos/aos.js"></script>
<script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
<script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
<script src="assets/js/main.js"></script>

</body>
</html>
                