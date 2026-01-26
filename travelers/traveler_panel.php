<?php 
    session_start(); 
    if (!isset($_SESSION['traveler_id'])) {
        header("Location: ../login.php");
        exit();
    } 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Traveler Dashboard</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="../assets/css/main.css" rel="stylesheet">
    
    <style>
        body {
            background-color: #f8f9fa;
        }
        
        .dashboard-container {
            max-width: 1200px;
            margin: auto;
            padding: 40px 20px;
        }

        .card {
            border: none;
            border-radius: 10px;
            transition: transform 0.3s ease-in-out;
        }

        .card:hover {
            transform: scale(1.05);
        }

        .card img {
            height: 200px;
            object-fit: cover;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .btn-primary {
            background-color: #D98F4E;
            border-color: #D98F4E;
        }

        .btn-primary:hover {
            background-color: #593434;
            border-color: #593434;
        }
    </style>
</head>
<body>
<?php
include '../includes/traveler_header.php';
?>
    <main class="dashboard-container">
        <h2 class="text-center mb-4">Welcome to Your Traveler Dashboard</h2>

        <div class="row g-4">

        <!-- Exploring Festival Services -->
<div class="col-md-4">
    <div class="card shadow-sm">
        <img src="../assets/img/gallery/gallery-1.jpeg" class="card-img-top" alt="Explore Festival Services">
        <div class="card-body text-center">
            <h5 class="card-title">Explore Festival Services</h5>
            <p class="card-text">Discover and enjoy special festival services during your trips.</p>
            <a href="book_estival_services.php" class="btn btn-primary">Explore</a>
        </div>
    </div>
</div>

            <!-- Exploring Experiences -->
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <img src="../assets/img/experiences/organic-farming.jpg" class="card-img-top" alt="Explore Experiences">
                    <div class="card-body text-center">
                        <h5 class="card-title">Explore Experiences</h5>
                        <p class="card-text">Discover amazing local activities and adventures.</p>
                        <a href="explore_experiences.php" class="btn btn-primary">Explore</a>
                    </div>
                </div>
            </div>

            <!-- Managing Bookings -->
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <img src="../assets/img/gallery/gallery-2.jpeg" class="card-img-top" alt="Manage Bookings">
                    <div class="card-body text-center">
                        <h5 class="card-title">Manage Bookings</h5>
                        <p class="card-text">View, modify, or cancel your bookings.</p>
                        <a href="manage_bookings.php" class="btn btn-primary">Manage</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mt-4">
            <!-- Reviews & Ratings -->
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <img src="../assets/img/experiences/cooking.jpeg" class="card-img-top" alt="Reviews & Ratings">
                    <div class="card-body text-center">
                        <h5 class="card-title">Reviews & Ratings</h5>
                        <p class="card-text">Rate your stays and experiences to help others.</p>
                        <a href="reviews.php" class="btn btn-primary">Write a Review</a>
                    </div>
                </div>
            </div>

            <!-- Profile Management -->
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <img src="../assets/img/gallery/gallery-4.jpeg" class="card-img-top" alt="Profile Management">
                    <div class="card-body text-center">
                        <h5 class="card-title">Profile Management</h5>
                        <p class="card-text">Update your personal details and change your password.</p>
                        <a href="profile.php" class="btn btn-primary">Manage Profile</a>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <br>
    <br>
    <?php 
    include('../includes/footer.php'); 
    ?>
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  
</body>
</html>
