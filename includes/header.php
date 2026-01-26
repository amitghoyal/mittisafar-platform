<?php 
    $current_page = basename($_SERVER['PHP_SELF']); 
?>

<header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">
        
        <!-- Logo -->
        <a href="index.php" class="logo d-flex align-items-center">
            <img src="assets/img/logo2.png" alt="MittiSafar Logo" class="site-logo">
        </a>
        
        <!-- Navigation Menu -->
        <nav id="navmenu" class="navmenu">
            <ul class="d-flex gap-4 mb-0">
                <li><a href="index.php" class="<?= ($current_page == 'index.php') ? 'active' : ''; ?>">Home</a></li>
                <li><a href="about.php" class="<?= ($current_page == 'about.php') ? 'active' : ''; ?>">About Us</a></li>
                <li><a href="experiences.php" class="<?= ($current_page == 'experiences.php') ? 'active' : ''; ?>">Experiences</a></li>
                <li><a href="hosts.php" class="<?= ($current_page == 'hosts.php') ? 'active' : ''; ?>">Become a Host</a></li>
                <li><a href="gallery.php" class="<?= ($current_page == 'gallery.php') ? 'active' : ''; ?>">Gallery</a></li>
                <li><a href="contact.php" class="<?= ($current_page == 'contact.php') ? 'active' : ''; ?>">Contact</a></li>
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

        <!-- Buttons -->
        <div class="header-buttons d-flex gap-3">
                <a class="btn btn-primary" href="register.php" role="button">Register</a>
            <a class="btn btn-outline-primary" href="login.php">Login</a>
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
    color: #314136; /* Dark green from your logo */
    padding: 10px 15px;
    transition: color 0.3s ease-in-out;
    font-size: 16px;
}

.navmenu ul li a.active,
.navmenu ul li a:hover {
    color: #D98F4E; /* Orange from your logo */
}

/* Header Buttons */
.header-buttons .btn {
    font-size: 14px;
    padding: 10px 18px;
    border-radius: 5px;
}

/* Primary Button */
.header-buttons .btn-primary {
    background-color: #D98F4E; /* Orange */
    border-color: #D98F4E;
}

.header-buttons .btn-primary:hover {
    background-color: #593434; /* Dark brown */
    border-color: #593434;
}

/* Secondary Button */
.header-buttons .btn-outline-primary {
    color: #D98F4E;
    border-color: #D98F4E;
}

.header-buttons .btn-outline-primary:hover {
    background-color: #D98F4E;
    color: white;
}

/* Mobile Menu Icon */
.mobile-nav-toggle {
    color: #314136;
    font-size: 24px;
    cursor: pointer;
}
</style>
