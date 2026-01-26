<?php 
    $current_page = basename($_SERVER['PHP_SELF']); 
?>

<header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">
        
        <!-- Logo -->
        <a href="traveler_panel.php" class="logo d-flex align-items-center">
            <img src="../assets/img/logo2.png" alt="Mitti Safar Logo" class="site-logo">
        </a>
        
        <!-- Navigation Menu -->
        <nav id="navmenu" class="navmenu">
            <ul class="d-flex gap-4 mb-0">
                <li><a href="traveler_panel.php" class="<?= ($current_page == 'traveler_panel.php') ? 'active' : ''; ?>">Dashboard</a></li>
                <li><a href="book_festival_services.php" class="<?= ($current_page == 'book_festival_services.php') ? 'active' : ''; ?>">Book Festival Services</a></li>
                <li><a href="explore_experiences.php" class="<?= ($current_page == 'explore_experiences.php') ? 'active' : ''; ?>">Explore Experiences</a></li>
                <li><a href="manage_bookings.php" class="<?= ($current_page == 'manage_bookings.php') ? 'active' : ''; ?>">Manage Bookings</a></li>
                <li><a href="profile.php" class="<?= ($current_page == 'profile.php') ? 'active' : ''; ?>">Profile</a></li>
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

        <!-- Logout Button -->
        <div class="header-buttons d-flex gap-3">
            <a class="btn btn-danger" href="../logout.php">Logout</a>
        </div>
    </div>
</header>

<style>

/* Header Styling */
.header {
    background-color: white; /* Full white background */
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); /* Soft shadow for a premium look */
    padding: 12px 0;
}

/* Logo Styling */
.site-logo {
    height: 70px;
    max-width: 100%;
    object-fit: contain;
}

.header .logo img {
    margin-right: 30px; /* Reduced spacing */
}

/* Navigation Menu */
.navmenu ul {
    list-style: none;
    padding: 0;
    display: flex;
    align-items: center;
    gap: 20px;
}

.navmenu ul li {
    display: inline-block;
}

.navmenu ul li a {
    text-decoration: none;
    font-weight: 600;
    color: #314136;
    padding: 10px 15px;
    transition: color 0.3s ease-in-out;
    font-size: 16px;
}

.navmenu ul li a.active,
.navmenu ul li a:hover {
    color: #D98F4E;
}

/* Logout Button */
.header-buttons .btn-danger {
    background-color: #d9534f;
    border-color: #d9534f;
    font-size: 14px;
    padding: 10px 18px;
    border-radius: 5px;
}

.header-buttons .btn-danger:hover {
    background-color: #c9302c;
    border-color: #c9302c;
}

/* Mobile Menu Icon */
.mobile-nav-toggle {
    color: #314136;
    font-size: 24px;
    cursor: pointer;
}
</style>
