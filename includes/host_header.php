<?php 
    $current_page = basename($_SERVER['PHP_SELF']); 
?>

<header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">
        
        <!-- Logo -->
        <a href="dashboard.php" class="logo d-flex align-items-center">
            <img src="../assets/img/logo2.png" alt="Mitti Safar Logo" class="site-logo">
        </a>
        
        <!-- Navigation Menu -->
        <nav id="navmenu" class="navmenu">
            <ul class="d-flex gap-4 mb-0">
                <li><a href="host_dashboard.php" class="<?= ($current_page == 'host_dashboard.php') ? 'active' : ''; ?>">Dashboard</a></li>
                
                <!-- Manage Experiences Dropdown -->
                <li class="dropdown">
                    <a href="#" class="<?= ($current_page == 'view_experiences.php' || $current_page == 'add_experience.php') ? 'active' : ''; ?>">Manage Experiences ▾</a>
                    <ul class="dropdown-menu">
                        <li><a href="view_experiences.php" class="<?= ($current_page == 'view_experiences.php') ? 'active' : ''; ?>">View Experiences</a></li>
                        <li><a href="add_experience.php" class="<?= ($current_page == 'add_experience.php') ? 'active' : ''; ?>">Add Experience</a></li>
                    </ul>
                </li>

                <!-- Manage Bookings Dropdown (Updated) -->
                <li class="dropdown">
                    <a href="#" class="<?= ($current_page == 'view_bookings.php' || $current_page == 'approved_bookings.php' || $current_page == 'completed_bookings.php' || $current_page == 'pending_bookings.php') ? 'active' : ''; ?>">Manage Bookings ▾</a>
                    <ul class="dropdown-menu">
                        <li><a href="view_bookings.php" class="<?= ($current_page == 'view_bookings.php') ? 'active' : ''; ?>">View Bookings</a></li>
                    </ul>
                </li>

                <!-- Festival Services Dropdown -->
                <li class="dropdown">
                    <a href="#" class="<?= ($current_page == 'view_festival_services.php' || $current_page == 'add_festival_service.php') ? 'active' : ''; ?>">Festival Services ▾</a>
                    <ul class="dropdown-menu">
                        <li><a href="view_festival_services.php" class="<?= ($current_page == 'view_festival_services.php') ? 'active' : ''; ?>">View Services</a></li>
                        <li><a href="add_festival_service.php" class="<?= ($current_page == 'add_festival_service.php') ? 'active' : ''; ?>">Add Service</a></li>
                    </ul>
                </li>

                <li><a href="payments.php" class="<?= ($current_page == 'payments.php') ? 'active' : ''; ?>">Payments</a></li>
                <li><a href="profile.php" class="<?= ($current_page == 'profile.php') ? 'active' : ''; ?>">Profile</a></li>
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

        <!-- Buttons -->
        <div class="header-buttons d-flex gap-3">
            <a class="btn btn-outline-primary" href="../logout.php">Logout</a>
        </div>
    </div>
</header>
<!-- CSS for Dropdown Menu -->
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
    position: relative;
}

/* Parent Links */
.navmenu ul li a {
    text-decoration: none;
    font-weight: 600;
    color: #314136;
    padding: 10px 15px;
    transition: color 0.3s ease-in-out;
    font-size: 16px;
}

/* Active & Hover States */
.navmenu ul li a.active,
.navmenu ul li a:hover {
    color: #D98F4E;
}

/* Dropdown Menu */
.dropdown-menu {
    display: none;
    position: absolute;
    left: 0;
    background: white;
    list-style: none;
    padding: 10px 0;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    border-radius: 5px;
    min-width: 180px;
    z-index: 1000;
}

.dropdown-menu li {
    width: 100%;
}

.dropdown-menu li a {
    display: block;
    padding: 8px 15px;
    font-size: 14px;
    color: #314136;
    transition: background 0.3s ease-in-out;
}

.dropdown-menu li a:hover {
    background: #f8f8f8;
    color: #D98F4E;
}

/* Show dropdown on hover */
.navmenu ul li:hover .dropdown-menu {
    display: block;
}

/* Header Buttons */
.header-buttons .btn {
    font-size: 14px;
    padding: 10px 18px;
    border-radius: 5px;
}

/* Primary Button */
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