<?php
include 'config/db_connect.php'; // Database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>MittiSafar - Home</title>
  <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/vendor/bootstrap-icons/bootstrap-icons.css">
  <link rel="stylesheet" href="assets/vendor/aos/aos.css">
  <link rel="stylesheet" href="assets/vendor/glightbox/css/glightbox.min.css">
  <link rel="stylesheet" href="assets/vendor/swiper/swiper-bundle.min.css">
  <link rel="stylesheet" href="assets/css/main.css">
</head>
<style>
    .hero .carousel-item img {
    filter: brightness(70%);
}

.hero .carousel-container h2 {
    font-size: 2.5rem;
    font-weight: bold;
    text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.3);
}

.hero .btn-get-started {
    background: #ff7b00;
    color: #fff;
    padding: 12px 24px;
    font-size: 1.2rem;
    border-radius: 8px;
    transition: 0.3s;
}

.hero .btn-get-started:hover {
    background: #e66900;
}
.about img {
    border-radius: 15px;
    box-shadow: 5px 5px 20px rgba(0, 0, 0, 0.15);
}
.service-icon {
    font-size: 3rem;
    color: #ff7b00;
    transition: 0.3s;
}

.card:hover .service-icon {
    transform: scale(1.1);
    color: #e66900;
}
.card:hover {
    transform: translateY(-5px);
    transition: 0.3s ease-in-out;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
}
.experience-img {
    width: 100%;
    height: 250px; /* Set a fixed height */
    object-fit: cover; /* Ensures uniform cropping */
    border-radius: 10px;
    transition: transform 0.3s ease-in-out;
}

.experience-img:hover {
    transform: scale(1.05); /* Subtle zoom effect */
}

</style>
<body>
<?php include("includes/header.php"); ?>  
<main class="main">
<!-- Hero Section -->
 
<section id="hero" class="hero section dark-background" data-aos="fade-up">
    <div id="hero-carousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">
        <?php
        $heroQuery = "SELECT * FROM homepage_content WHERE section='hero'";
        $heroResult = mysqli_query($conn, $heroQuery);
        $active = "active";
        while ($hero = mysqli_fetch_assoc($heroResult)) :
        ?>
            <div class="carousel-item <?= $active; ?>">
                <img src="assets/img/<?= $hero['image']; ?>" alt="">
                <div class="carousel-container" data-aos="fade-in">
                    <h2><?= $hero['title']; ?></h2>
                    <p><?= $hero['description']; ?></p>
                    <a href="login.php" class="btn-get-started" data-aos="zoom-in">Start Your Journey</a>
                </div>
            </div>
        <?php 
        $active = ""; // Remove active after first iteration
        endwhile; 
        ?>
</div>
        <!-- Carousel Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#hero-carousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#hero-carousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </button>
</section>

<!-- About Section -->
<section id="about" class="about section py-5" data-aos="fade-up">
    <div class="container">
        <?php
        $aboutQuery = "SELECT * FROM homepage_content WHERE section='about'";
        $aboutResult = mysqli_fetch_assoc(mysqli_query($conn, $aboutQuery));
        ?>
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h2><?= $aboutResult['title']; ?></h2>
                <p class="lead"><?= $aboutResult['description']; ?></p>
            </div>
            <div class="col-lg-6 text-center">
                <img src="assets/img/<?= $aboutResult['image']; ?>" class="img-fluid about-img" alt="About Us" data-aos="zoom-in">
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section id="services" class="services section" data-aos="fade-up">
    <div class="container">
        <h2 class="text-center mb-5">Our Services</h2>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php
            $serviceQuery = "SELECT * FROM services";
            $serviceResult = mysqli_query($conn, $serviceQuery);
            while ($service = mysqli_fetch_assoc($serviceResult)) :
            ?>
                <div class="col">
                    <div class="card h-100 text-center shadow-sm border-0">
                        <div class="card-body" data-aos="zoom-in">
                            <div class="icon-box mb-3">
                                <i class="bi <?= $service['icon']; ?> service-icon"></i>
                            </div>
                            <h4 class="card-title"><?= $service['title']; ?></h4>
                            <p class="card-text"><?= $service['description']; ?></p>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<!-- Experiences Section -->
<section id="portfolio" class="portfolio section">
    <div class="container">
        <h2 class="text-center mb-4">Authentic Rural Experiences</h2>
        <div class="row g-4">
            <?php
            $experienceQuery = "SELECT * FROM experiences_homepage";
            $experienceResult = mysqli_query($conn, $experienceQuery);
            while ($experience = mysqli_fetch_assoc($experienceResult)) :
            ?>
                <div class="col-lg-4 col-md-6 d-flex align-items-stretch">
                    <div class="card p-3 text-center shadow-sm border-0">
                        <img src="assets/img/rural-experiences/<?= $experience['image']; ?>" class="img-fluid rounded experience-img" alt="<?= $experience['title']; ?>">
                        <h4 class="mt-3"><?= $experience['title']; ?></h4>
                        <p><?= $experience['description']; ?></p>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>

</main>

<?php include("includes/footer.php"); ?>

<!-- Scripts -->
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/aos/aos.js"></script>
<script>
  AOS.init();
</script>
</body>
</html>
