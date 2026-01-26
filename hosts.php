<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Become a Host - MittiSafar</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

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

</head>

<body class="about-page">
<?php
include_once("includes/header.php");
?>  
<main class="main">

<!-- Page Title -->
<div class="page-title light-background">
    <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Become a Host</h1>
        <nav class="breadcrumbs">
            <ol>
                <li><a href="index.php">Home</a></li>
                <li class="current">Become a Host</li>
            </ol>
        </nav>
    </div>
</div><!-- End Page Title -->

<!-- Become a Host Section -->
<section id="become-a-host" class="host-section section">
    <div class="container" data-aos="fade-up">
        
        <div class="section-title text-center">
            <h2>Open Your Home, Share Your Story</h2>
            <p>Turn your village home into a welcoming experience for travelers from around the world. Let them feel the warmth of rural life while you earn a livelihood.</p>
        </div>

        <!-- Benefits of Hosting -->
        <div class="row gy-4">
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="benefit-card shadow-lg p-4 rounded text-center">
                    <i class="bi bi-house-heart text-primary display-4"></i>
                    <h4>Earn with Dignity</h4>
                    <p>Provide travelers with a place to stay and get rewarded while sharing your culture.</p>
                </div>
            </div>

            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <div class="benefit-card shadow-lg p-4 rounded text-center">
                    <i class="bi bi-globe2 text-success display-4"></i>
                    <h4>Meet People from Around the World</h4>
                    <p>Connect with travelers who want to experience real rural life and traditions.</p>
                </div>
            </div>

            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
                <div class="benefit-card shadow-lg p-4 rounded text-center">
                    <i class="bi bi-emoji-smile text-danger display-4"></i>
                    <h4>Make Lifelong Friendships</h4>
                    <p>Welcome guests, share meals, and create memories that will last forever.</p>
                </div>
            </div>
        </div>

        <!-- Hosting Steps -->
        <div class="row mt-5">
            <div class="col-lg-6" data-aos="fade-up">
                <img src="assets/img/host/join-host.jpg" class="img-fluid rounded shadow" alt="Host with Travelers">
            </div>
            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
                <h3>How to Become a Host?</h3>
                <p class="fst-italic">Joining मिट्टीSafar as a host is easy! Just follow these simple steps:</p>
                <ul class="list-unstyled">
                    <li><i class="bi bi-check-circle text-primary"></i> <strong>Sign Up:</strong> Register your home with us.</li>
                    <li><i class="bi bi-check-circle text-primary"></i> <strong>Get Verified:</strong> Our team will visit your place for verification.</li>
                    <li><i class="bi bi-check-circle text-primary"></i> <strong>Start Hosting:</strong> Welcome travelers and begin your journey!</li>
                </ul>
                <a href="register_host.php" class="btn btn-primary mt-3">Register as a Host</a>
            </div>
        </div>

        <!-- Testimonials from Hosts -->
        <div class="section-title text-center mt-5">
            <h2>Our Hosts Speak</h2>
            <p>Real stories from village hosts who found a new way of life through मिट्टीSafar.</p>
        </div>

        <div class="row gy-4">
            <!-- Testimonial 1 -->
            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                <div class="testimonial-card shadow-lg p-4 rounded">
                    <p class="fst-italic">"I never thought my small home could become a place where people from all over the world would come and stay. Hosting has changed my life."</p>
                    <h5>- Ramesh Kumar, Rajasthan</h5>
                </div>
            </div>

            <!-- Testimonial 2 -->
            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
                <div class="testimonial-card shadow-lg p-4 rounded">
                    <p class="fst-italic">"The extra income from hosting helped me send my daughter to school. More than money, I gained respect in my community."</p>
                    <h5>- Sunita Devi, Uttarakhand</h5>
                </div>
            </div>
        </div>

        <!-- Call to Action -->
        <div class="text-center mt-5" data-aos="fade-up" data-aos-delay="300">
            <h4>Join the मिट्टीSafar Family</h4>
            <p>Become a part of this journey and bring the world closer to your village.</p>
            <a href="register_host.php" class="btn btn-success">Get Started Now</a>
        </div>

    </div>
</section><!-- /Become a Host Section -->

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