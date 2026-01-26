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

## Screenshots 
- **Homepage**: ![mittisafar-homepage](https://github.com/user-attachments/assets/08e2a770-d372-4ec0-a594-bf2919f5963a)
- **Aboutus**: ![mittisafar-aboutus](https://github.com/user-attachments/assets/f491e2d2-6050-4045-8a37-40ff02e32206)
- **Host Registration**: ![mittisafar-host_registration](https://github.com/user-attachments/assets/5aed66ac-dc8a-40b6-8b40-6fe2aa65ad8e)
- **Login Page**: ![mittisafar-login](https://github.com/user-attachments/assets/cc55f6d7-bbe7-4eae-a772-b7f09c144f2f)
- **Forget Password**: ![mittisafar-forget_password](https://github.com/user-attachments/assets/a8253da1-bffb-4b7f-bbfa-854789c6edb6)
- **Forget Password Email**: <img width="1080" height="1536" alt="image" src="https://github.com/user-attachments/assets/8df09e07-a38d-4646-a883-ea0f9e3d370b" />
- **Dashboard Admin**: ![mittisafar-admin_dashboard](https://github.com/user-attachments/assets/aeeff8fc-e798-468c-bd8a-9e0b98ac58ba)
- **Dashboard Host**: ![mittisafar-host_dashboard](https://github.com/user-attachments/assets/9e177560-63a2-45c4-a604-3ec0db5169c0)
- **Dashboard Traveler**: ![mittisafar-traveller_dashboard](https://github.com/user-attachments/assets/6baa4550-d21c-4fdb-8d86-56eca10da82b)


## Project Setup
1. Clone the repository:
   ```bash
   git clone https://github.com/amittghoyal/mittisafar-platform.git
2. Move files into your XAMPP htdocs folder.
3. Import database.sql into MySQL via phpMyAdmin.
4. Configure config.php with your database and Razorpay credentials.
5. Start Apache & MySQL in XAMPP.
6. Visit http://localhost/mittisafar.

## Roadmap
- [x] Traveler booking system  
- [x] Host service management  
- [ ] Razorpay payment integration (dummy)  
- [ ] Email notifications for forget password  

## Mission
Empowering rural hosts, preserving heritage, and offering travelers an unforgettable journey into the soul of India.

