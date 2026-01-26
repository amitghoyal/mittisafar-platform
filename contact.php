<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'config/db_connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Contact Us - मिट्टीSafar</title>

  <!-- Bootstrap & CSS -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">

  <link href="assets/css/main.css" rel="stylesheet">

</head>

<body>
<main class="main">
<?php
include_once("includes/header.php");
?>
<!-- Page Title -->
<div class="page-title light-background">
    <div class="container">
        <h1 class="mb-2">Get in Touch</h1>
        <nav class="breadcrumbs">
            <ol>
                <li><a href="index.php">Home</a></li>
                <li class="current">Contact Us</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Contact Section -->
<section id="contact" class="contact section">
    <div class="container" data-aos="fade-up">
        <div class="section-title text-center">
            <h2>We’d Love to Hear From You!</h2>
            <p>Have a question or want to connect? Send us a message!</p>
        </div>

        <div class="row gy-4">
            <div class="col-lg-5">
                <div class="contact-info shadow-lg p-4 rounded">
                    <h4>Our Office</h4>
                    <p><i class="bi bi-geo-alt text-primary"></i> 123, MittiSafar Lane, Rural Connect, India</p>
                    <h4>Email Us</h4>
                    <p><i class="bi bi-envelope text-primary"></i> <a href="mailto:contact@mittisafar.com">contact@mittisafar.com</a></p>
                    <h4>Call Us</h4>
                    <p><i class="bi bi-telephone text-primary"></i> +91 98765 43210</p>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="col-lg-7">
                <div class="contact-form shadow-lg p-4 rounded">
                    <h4>Send Us a Message</h4>
                    <div id="form-alert" class="alert d-none"></div>
                    
                    <form id="contact-form">
                        <div class="row gy-3">
                            <div class="col-md-6">
                                <input type="text" name="name" id="name" class="form-control" placeholder="Your Name" required>
                            </div>
                            <div class="col-md-6">
                                <input type="email" name="email" id="email" class="form-control" placeholder="Your Email" required>
                            </div>
                        </div>
                        <div class="row gy-3 mt-2">
                            <div class="col-md-6">
                                <input type="text" name="phone" id="phone" class="form-control" placeholder="Your Phone" required>
                            </div>
                            <div class="col-md-6">
                                <select name="subject" id="subject" class="form-select" required>
                                    <option value="" disabled selected>Select Subject</option>
                                    <option value="General Inquiry">General Inquiry</option>
                                    <option value="Booking Assistance">Booking Assistance</option>
                                    <option value="Host Registration">Host Registration</option>
                                    <option value="Feedback">Feedback</option>
                                </select>
                            </div>
                        </div>
                        <div class="mt-3">
                            <textarea name="message" id="message" class="form-control" rows="5" placeholder="Your Message" required></textarea>
                        </div>
                        <div class="text-center mt-3">
                            <button type="submit" class="btn btn-primary">Send Message</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</section>
</main>

<?php include_once("includes/footer.php"); ?>

<!-- Bootstrap & JavaScript -->
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/main.js"></script>

<!-- ✅ Fix: AJAX Form Submission -->
<script>
document.getElementById("contact-form").addEventListener("submit", function(event) {
    event.preventDefault();

    let formData = new FormData(this);
    let alertBox = document.getElementById("form-alert");

    fetch("contact-form-handler.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        alertBox.classList.remove("d-none", "alert-danger", "alert-success");
        alertBox.classList.add(data.status === "success" ? "alert-success" : "alert-danger");
        alertBox.innerHTML = data.message;
    })
    .catch(error => {
        alertBox.classList.remove("d-none", "alert-success");
        alertBox.classList.add("alert-danger");
        alertBox.innerHTML = "Something went wrong. Please try again.";
    });
});
</script>

</body>
</html>
