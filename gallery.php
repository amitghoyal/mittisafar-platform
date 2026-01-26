<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>About - Sailor Bootstrap Template</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Sailor
  * Template URL: https://bootstrapmade.com/sailor-free-bootstrap-theme/
  * Updated: Aug 07 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
  <style>
    .gallery-img {
        width: 100%;
        height: 250px;
        object-fit: cover;
    }</style>
</head>
<body class="about-page">
<?php
include_once("includes/header.php");
?>  
<main class="main">

<!-- Page Title -->
<div class="page-title light-background">
    <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Gallery</h1>
        <nav class="breadcrumbs">
            <ol>
                <li><a href="index.php">Home</a></li>
                <li class="current">Gallery</li>
            </ol>
        </nav>
    </div>
</div><!-- End Page Title -->

<!-- Gallery Section -->
<section id="gallery" class="gallery section">
    <div class="container" data-aos="fade-up">
        
        <div class="section-title text-center">
            <h2>Experience the Beauty of Rural India</h2>
            <p>Explore moments that capture the essence of village life, cultural experiences, and breathtaking landscapes.</p>
        </div>

        <div class="row gy-4">
            <!-- Image 1 -->
            <div class="col-lg-4 col-md-6" data-aos="zoom-in">
                <div class="gallery-item">
                    <a href="assets/img/gallery/gallery-1.jpg" class="glightbox" class="gallery-img">
                       
                        <img src="assets/img/gallery/gallery-1.jpeg" class="img-fluid gallery-img rounded shadow" alt="Village Homestay">

                    </a>
                    <p class="mt-2 text-center">Traditional Village Homestay</p>
                </div>
            </div>

            <!-- Image 2 -->
            <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="100">
                <div class="gallery-item">
                    <a href="assets/img/gallery/gallery-2.jpg" class="glightbox">
                       
                        <img src="assets/img/gallery/gallery-2.jpeg" class="img-fluid gallery-img rounded shadow" alt="Bullock Cart Ride">

                    </a>
                    <p class="mt-2 text-center">Bullock Cart Ride Through Fields</p>
                </div>
            </div>

            <!-- Image 3 -->
            <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="200">
                <div class="gallery-item">
                    <a href="assets/img/gallery/gallery-3.jpg" class="glightbox">
                        
                        <img src="assets/img/gallery/gallery-3.jpg" class="img-fluid gallery-img rounded shadow" alt="andicrafts Making">
                    </a>
                    <p class="mt-2 text-center">Handicrafts by Local Artisans</p>
                </div>
            </div>

            <!-- Image 4 -->
            <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="300">
                <div class="gallery-item">
                    <a href="assets/img/gallery/gallery-4.jpeg" class="glightbox">
                        
                        <img src="assets/img/gallery/gallery-4.jpeg" class="img-fluid gallery-img rounded shadow" alt="Organic Farming">
                    </a>
                    <p class="mt-2 text-center">Hands-on Organic Farming</p>
                </div>
            </div>

            <!-- Image 5 -->
            <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="400">
                <div class="gallery-item">
                    <a href="assets/img/gallery/gallery-5.jpg" class="glightbox">
                        
                        <img src="assets/img/gallery/gallery-5.jpeg" class="img-fluid gallery-img rounded shadow" alt="Cooking on Chulha">
                    </a>
                    <p class="mt-2 text-center">Cooking Traditional Meals on Chulha</p>
                </div>
            </div>

            <!-- Image 6 -->
            <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="500">
                <div class="gallery-item">
                    <a href="assets/img/gallery/gallery-6.jpg" class="glightbox">
                        
                        <img src="assets/img/gallery/gallery-6.jpg" class="img-fluid gallery-img rounded shadow" alt="Village Festival">
                    </a>
                    <p class="mt-2 text-center">Celebrating Village Festivals</p>
                </div>
            </div>
        </div>

        <!-- Call to Action -->
        <div class="text-center mt-5" data-aos="fade-up" data-aos-delay="600">
            <h4>Want to Create Your Own Village Story?</h4>
            <p>Book an experience today and be a part of authentic rural India.</p>
            <a href="experiences.php" class="btn btn-primary">Explore Experiences</a>
        </div>

    </div>
</section><!-- /Gallery Section -->

</main>
  <?php
include_once("includes/footer.php");
?>  

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/waypoints/noframework.waypoints.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>