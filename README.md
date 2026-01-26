# MittiSafar 🌱 – Travel, Festival & Local Experience Booking Platform

**MittiSafar: मिट्टीSafar is more than just a trip – it’s a transformation.**  
A full-stack PHP/MySQL + Bootstrap platform designed to promote rural tourism, local festivals, and authentic village-based experiences in India.

## Features

### Travelers
- Browse festivals and cultural experiences
- View detailed service information
- Book securely with Razorpay
- Real-time availability & booking status
- Automated email confirmations

### Hosts
- Register & verify email via OTP
- Create and manage festival services/experiences
- Upload images & define availability
- Track bookings made by travelers

### Admins
- Approve/reject host services
- Manage users & monitor bookings
- Database-driven content management (e.g., About Us page)

---

## Tech Stack
- **Frontend:** Bootstrap, HTML, CSS, JavaScript  
- **Backend:** PHP (role-based authentication, secure sessions)  
- **Database:** MySQL (with JSON fields for dynamic content)  
- **Payments:** Razorpay integration (in progress)  
- **Email/OTP:** PHPMailer  

---

## Project Setup
1. Clone the repository:
   ```bash
   git clone https://github.com/amittghoyal/mittisafar-platform.git
2. Move files into your XAMPP htdocs folder.
3. Import database.sql into MySQL via phpMyAdmin.
4. Configure config.php with your database and Razorpay credentials.
5. Start Apache & MySQL in XAMPP.
6. Visit http://localhost/mittisafar.
