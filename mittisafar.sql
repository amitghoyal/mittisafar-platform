-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 26, 2026 at 07:28 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mittisafar`
--

-- --------------------------------------------------------

--
-- Table structure for table `about_page`
--

CREATE TABLE `about_page` (
  `id` int(11) NOT NULL,
  `section_name` varchar(100) NOT NULL,
  `heading` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `about_page`
--

INSERT INTO `about_page` (`id`, `section_name`, `heading`, `content`, `image`, `created_at`) VALUES
(1, 'hero_section', 'Reconnect with Your Roots in मिट्टीSafar', 'Escape the hustle of city life and immerse yourself in India\'s untouched villages. Experience the warmth of rural hospitality, breathtaking landscapes, and timeless traditions.', 'hero-carousel-1.jpg', '2025-03-14 04:56:14'),
(2, 'our_story', 'Our Story', 'What started as a dream has now become a bridge connecting urban travelers to rural communities. मिट्टीSafar is not just a platform – it’s a movement that brings the untouched beauty of villages closer to you.', NULL, '2025-03-14 04:56:14'),
(3, 'our_mission', 'Our Mission', 'Our mission is simple – to make rural tourism a gateway for travelers to experience real India, while empowering villagers with new opportunities.', NULL, '2025-03-14 04:56:14'),
(4, 'why_choose_us', 'Why Choose Us?', 'मिट्टीSafar is more than just a trip – it’s a transformation. Every journey takes you beyond sightseeing, into the heart of real India.', NULL, '2025-03-14 04:56:14'),
(9, 'hero_section', 'Reconnect with Your Roots in मिट्टीSafar', 'In the heart of India, where the winds whisper stories of forgotten traditions, where every sunrise paints a picture of hope—welcome to मिट्टीSafar. A journey that is not just about travel, but about rediscovering yourself.', 'hero-carousel-1.jpg', '2025-03-14 05:00:02'),
(10, 'our_story', 'Our Story', 'मिट्टीSafar began as a dream—a dream to bridge the gap between bustling cities and the soulful silence of villages. It’s not just a platform; it’s a revolution that connects people, cultures, and stories.', NULL, '2025-03-14 05:00:02'),
(11, 'our_mission', 'Our Mission', 'Our mission is to bring people closer to the land, to its people, and to a way of life that celebrates simplicity, sustainability, and the beauty of togetherness. Through responsible tourism, we empower rural communities and preserve India\'s rich heritage.', NULL, '2025-03-14 05:00:02'),
(12, 'why_choose_us', 'Why Choose Us?', 'We don’t offer just vacations. We offer experiences that touch your soul. Every journey with मिट्टीSafar is a step towards meaningful travel—one where you don’t just see a place, but truly become a part of it.', NULL, '2025-03-14 05:00:02'),
(13, 'stats_travelers', '5000+', 'Happy Travelers', NULL, '2025-03-14 05:00:02'),
(14, 'stats_experiences', '250+', 'Authentic Rural Experiences', NULL, '2025-03-14 05:00:02'),
(15, 'stats_villages', '80+', 'Villages Connected', NULL, '2025-03-14 05:00:02'),
(16, 'stats_memories', '10,000+', 'Memories Created', NULL, '2025-03-14 05:00:02');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(11) NOT NULL,
  `traveler_id` int(11) NOT NULL,
  `experience_id` int(11) NOT NULL,
  `booking_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','confirmed','completed','cancelled') DEFAULT 'pending',
  `amount` decimal(10,2) NOT NULL,
  `payment_status` enum('pending','confirmed','failed') DEFAULT 'pending',
  `razorpay_order_id` varchar(255) DEFAULT NULL,
  `razorpay_payment_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `chat_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `phone`, `subject`, `message`, `created_at`) VALUES
(1, 'Amit', 'amitgohil1@gmail.com', '9510360227', 'Host Registration', 'Hello need a help', '2025-03-14 06:13:22'),
(2, 'Gediya Nimesh', 'gediynimesh@gmail.com', '9327740662', 'Booking Assistance', '\"Hello, I am interested in booking a traditional homestay experience for the upcoming weekend. Could you please provide availability and pricing details? Also, do you offer any guided village tours along with the stay? Looking forward to your response. Thank you!\"', '2025-04-03 11:01:45'),
(3, 'Gediya Nimesh', 'gediynimesh@gmail.com', '9327740662', 'Booking Assistance', '\"Hello, I am interested in booking a traditional homestay experience for the upcoming weekend. Could you please provide availability and pricing details? Also, do you offer any guided village tours along with the stay? Looking forward to your response. Thank you!\"', '2025-04-03 11:03:07'),
(4, 'Gediya Nimesh', 'gediynimesh@gmail.com', '9327740662', 'Booking Assistance', '\"Hello, I am interested in booking a traditional homestay experience for the upcoming weekend. Could you please provide availability and pricing details? Also, do you offer any guided village tours along with the stay? Looking forward to your response. Thank you!\"', '2025-04-03 11:03:07'),
(5, 'Gediya Nimesh', 'gediynimesh@gmail.com', '9327740662', 'Booking Assistance', '\"Hello, I am interested in booking a traditional homestay experience for the upcoming weekend. Could you please provide availability and pricing details? Also, do you offer any guided village tours along with the stay? Looking forward to your response. Thank you!\"', '2025-04-03 11:03:07');

-- --------------------------------------------------------

--
-- Table structure for table `experiences`
--

CREATE TABLE `experiences` (
  `experience_id` int(11) NOT NULL,
  `host_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `category` enum('Cooking','Farming','Handicrafts','Trekking','Cultural Performance','Others') NOT NULL,
  `custom_category` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `group_size` int(11) NOT NULL,
  `availability` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`availability`)),
  `image` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('active','inactive','deleted') DEFAULT 'active',
  `homestay_available` enum('yes','no') DEFAULT 'no'
) ;

--
-- Dumping data for table `experiences`
--

INSERT INTO `experiences` (`experience_id`, `host_id`, `title`, `description`, `category`, `custom_category`, `price`, `group_size`, `availability`, `image`, `created_at`, `status`, `homestay_available`) VALUES
(10, 15, 'Traditional Pottery Making', 'Learn the ancient art of pottery from skilled rural artisans. Hands-on experience in molding clay and creating beautiful pottery pieces.', 'Handicrafts', NULL, 500.00, 10, '[{\"from\":\"2025-05-04T10:00\",\"to\":\"2025-05-04T13:00\"}]', '[\"..\\/uploads\\/1743391557_potter.jpeg\"]', '2025-03-31 03:25:57', 'active', 'yes'),
(11, 15, 'Traditional Rajasthani Cooking Experience', 'Join a local family in their village home and learn to cook authentic Rajasthani dishes like Dal Baati Churma and Gatte ki Sabzi. This immersive experience will let you understand the flavors and techniques of traditional cooking while enjoying warm hospitality.\"', 'Cooking', NULL, 1500.00, 5, '[{\"from\":\"2025-04-05T10:00\",\"to\":\"2025-04-07T06:00\"}]', '[\"..\\/uploads\\/1743680093_3f5c4e4617a5ce403d2fcd789a00b108.jpg\"]', '2025-04-03 11:34:53', 'active', 'yes'),
(12, 15, 'Sunset Camel Safari & Cultural Night', '\"Enjoy a mesmerizing camel safari through the golden sand dunes as the sun sets over the horizon. After the ride, experience an evening filled with folk music, dance performances, and a traditional Rajasthani dinner under the stars.\"', 'Others', 'Adventure', 2500.00, 8, '[{\"from\":\"2005-04-04T04:00\",\"to\":\"2025-04-10T10:00\"}]', '[\"..\\/uploads\\/1743680527_th (21).jpeg\"]', '2025-04-03 11:42:07', 'active', 'yes'),
(13, 15, 'Organic Farming & Village Life Experience', '\"Spend a day on a traditional organic farm, learning sustainable farming techniques, plowing fields with oxen, and harvesting fresh vegetables. Enjoy a farm-to-table meal prepared with organic ingredients and experience the simplicity of rural life.\"', 'Farming', NULL, 1200.00, 10, '[{\"from\":\"2025-05-31T08:00\",\"to\":\"2025-06-10T04:00\"}]', '[\"..\\/uploads\\/1743680624_organic farming 2.jpeg\"]', '2025-04-03 11:43:44', 'active', 'yes'),
(14, 15, 'Handicraft', 'Handicraft', 'Handicrafts', NULL, 2000.00, 10, '[{\"from\":\"20025-05-04T10:00\",\"to\":\"20025-05-10T07:00\"}]', '[\"..\\/uploads\\/1743680709_4e58135138556248e78fbd1d640fa73a.jpg\"]', '2025-04-03 11:45:09', 'active', 'yes'),
(15, 15, 'Village Cycling Tour', '\"Explore the beauty of rural landscapes on a guided cycling tour through scenic villages, lush fields, and ancient temples. Interact with locals, visit traditional homes, and enjoy a refreshing break with homemade snacks and chai.\"', 'Others', 'Adventure', 1500.00, 15, '[{\"from\":\"0025-05-10T07:00\",\"to\":\"2025-05-15T04:00\"}]', '[\"..\\/uploads\\/1743680885_th.jpeg\"]', '2025-04-03 11:48:05', 'active', 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `experiences_about`
--

CREATE TABLE `experiences_about` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `delay` int(11) DEFAULT 100
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `experiences_about`
--

INSERT INTO `experiences_about` (`id`, `title`, `description`, `image`, `delay`) VALUES
(1, 'Cook on a Chulha', 'Feel the aroma of spices as you cook a meal on an earthen stove, just like generations before us.', 'cooking.jpeg', 100),
(2, 'Hand Milking Cows', 'Reconnect with nature by experiencing the joy of hand-milking a cow.', 'milking.jpg', 200),
(3, 'Bullock Cart Ride', 'Travel like the villagers do—slow, peaceful, and in sync with nature.', 'bullock-cart.jpeg', 300),
(4, 'Pottery & Handicrafts', 'Feel the joy of molding clay with your own hands.', 'potter.jpeg', 400),
(5, 'Organic Farming', 'Feel the soil, sow the seeds, and harvest fresh vegetables with your own hands.', 'organic-farming.jpg', 500),
(6, 'Traditional Folk Dance & Music', 'Lose yourself in the beats of the dhol and the melody of folk songs.', 'folk-dance.jpg', 600);

-- --------------------------------------------------------

--
-- Table structure for table `experiences_homepage`
--

CREATE TABLE `experiences_homepage` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `experiences_homepage`
--

INSERT INTO `experiences_homepage` (`id`, `title`, `description`, `category`, `image`, `created_at`) VALUES
(1, 'Traditional Homestays', 'Live with a local family and experience their warm hospitality.', 'homestay', 'homestay.jpg', '2025-03-14 04:15:22'),
(2, 'Organic Farming', 'Learn sustainable farming techniques.', 'farming', 'farming.jpg', '2025-03-14 04:15:22'),
(3, 'Trekking & Nature Walks', 'Explore untouched trails and scenic landscapes of rural India.', 'adventure', 'trekking.jpg', '2025-03-14 04:15:22'),
(4, 'Handicrafts & Pottery', 'Create beautiful handicrafts with skilled rural artisans.', 'homestay', 'handicrafts.jpg', '2025-03-14 04:15:22'),
(5, 'Bullock Cart Ride', 'Take a peaceful ride through the village and experience traditional transportation.', 'adventure', 'bullock-cart.jpeg', '2025-03-14 04:15:22'),
(6, 'Village Cooking Experience', 'Learn to cook traditional village-style meals with fresh local ingredients.', 'food', 'village-cooking.jpg', '2025-04-03 04:45:30');

-- --------------------------------------------------------

--
-- Table structure for table `festival_bookings`
--

CREATE TABLE `festival_bookings` (
  `booking_id` int(11) NOT NULL,
  `traveler_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `num_people` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `gst` decimal(10,2) NOT NULL,
  `final_amount` decimal(10,2) NOT NULL,
  `selected_date` date NOT NULL,
  `status` enum('pending','confirmed','cancelled') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `payment_status` enum('pending','paid','failed') DEFAULT 'pending',
  `razorpay_payment_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `festival_bookings`
--

INSERT INTO `festival_bookings` (`booking_id`, `traveler_id`, `service_id`, `num_people`, `total_price`, `gst`, `final_amount`, `selected_date`, `status`, `created_at`, `payment_status`, `razorpay_payment_id`) VALUES
(35, 42, 11, 5, 7500.00, 1350.00, 8850.00, '2026-03-23', 'confirmed', '2025-03-31 17:34:07', 'paid', NULL),
(38, 42, 11, 7, 10500.00, 1890.00, 12390.00, '2026-03-23', 'pending', '2025-03-31 18:29:54', 'paid', NULL),
(40, 42, 11, 5, 7500.00, 1350.00, 8850.00, '2026-03-23', 'cancelled', '2025-04-01 02:53:45', 'pending', NULL),
(41, 42, 11, 5, 7500.00, 1350.00, 8850.00, '2026-03-23', 'pending', '2025-04-01 05:02:12', 'pending', NULL),
(42, 46, 11, 3, 4500.00, 810.00, 5310.00, '2026-03-23', 'pending', '2025-04-11 06:50:41', 'pending', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `festival_services`
--

CREATE TABLE `festival_services` (
  `service_id` int(11) NOT NULL,
  `host_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `festival_name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `availability` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`availability`)),
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `image` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`image`)),
  `max_group_size` int(11) NOT NULL DEFAULT 10
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `festival_services`
--

INSERT INTO `festival_services` (`service_id`, `host_id`, `title`, `description`, `festival_name`, `price`, `availability`, `status`, `created_at`, `image`, `max_group_size`) VALUES
(11, 15, 'Holi', 'celebrate Holi with organic colors, dance, and sweets in the heart of Vrindavan.', 'Holi', 1500.00, '[\"2026-03-23 10:00\",\"2026-03-23 14:00\"]', 'approved', '2025-03-31 04:05:38', '[\"uploads/1743393938_gallery-6.jpg\"]', 10),
(12, 15, 'Folk Dance & Music Night', '\"Experience the vibrant culture of Rajasthan with an evening of mesmerizing folk dances and traditional music. Enjoy performances like Ghoomar, Kalbeliya, and Bhavai while savoring delicious local cuisine.\"', 'Desert Heritage Festival', 2000.00, '0', 'approved', '2025-04-03 12:10:47', '[\"uploads/1743682247_th (1).jpeg\"]', 10),
(13, 15, 'Diwali Village Lights & Fireworks Celebration', '\"Experience the magic of Diwali in a rural village with traditional diya lighting, rangoli making, and a grand fireworks show. Enjoy festive sweets, cultural performances, and prayers at the local temple.\"', 'Diwali', 2500.00, '0', 'approved', '2025-04-03 12:22:16', '[\"uploads/1743682936_download.jpeg\"]', 20);

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `caption` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`id`, `image`, `caption`, `created_at`) VALUES
(1, 'gallery-1.jpg', 'Traditional Village Homestay', '2025-03-14 05:34:36'),
(2, 'gallery-2.jpg', 'Bullock Cart Ride Through Fields', '2025-03-14 05:34:36'),
(3, 'gallery-3.jpg', 'Handicrafts by Local Artisans', '2025-03-14 05:34:36'),
(4, 'gallery-4.jpg', 'Hands-on Organic Farming', '2025-03-14 05:34:36'),
(5, 'gallery-5.jpg', 'Cooking Traditional Meals on Chulha', '2025-03-14 05:34:36'),
(6, 'gallery-6.jpg', 'Celebrating Village Festivals', '2025-03-14 05:34:36');

-- --------------------------------------------------------

--
-- Table structure for table `homepage_content`
--

CREATE TABLE `homepage_content` (
  `id` int(11) NOT NULL,
  `section` varchar(50) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `homepage_content`
--

INSERT INTO `homepage_content` (`id`, `section`, `title`, `description`, `image`, `created_at`) VALUES
(4, 'about', 'MittiSafar - A Journey Back to Our Roots', 'MittiSafar is not just about travel; it’s about rediscovering the heart of India. We bridge the gap between urban travelers and rural communities, offering an immersive experience filled with love, culture, and tradition. Through authentic homestays, storytelling sessions, and traditional craftsmanship, we bring you the soul of India’s villages. Come, be a part of their joy, their stories, and their dreams.', '67f8b91809841.jpg', '2025-03-14 04:15:22'),
(5, 'hero', 'Experience the Soul of Rural India', 'Step away from the city lights and into the heart of India’s villages, where every sunrise tells a story and every sunset is a celebration. Discover authentic rural life, warm hospitality, and unforgettable experiences.', '67ee5984876cf.jpg', '2025-03-30 12:50:37'),
(6, 'about_us', 'MittiSafar - A Journey Back to Our Roots', 'At MittiSafar, we believe in reconnecting people with the soul of India. Our platform bridges the gap between urban travelers and rural hosts, offering immersive experiences in the heart of the countryside. Travel, learn, and grow with us.', '67ee59acd3373.jpg', '2025-03-30 12:50:37'),
(7, 'mission', 'Empowering Villages, Enriching Journeys', 'We aim to empower rural communities by bringing travelers closer to their traditions, crafts, and daily life. Every stay booked, every experience shared, contributes to sustainable rural development and preserves India’s rich heritage.', '67ee59dd3b588.jpg', '2025-03-30 12:50:37'),
(8, 'vision', 'A World Where Every Village is a Destination', 'Our vision is to create a world where rural India is not just seen but experienced, where every traveler carries home a piece of the village’s warmth and wisdom. Together, we build memories that last a lifetime.', '67ee5a0b7b8e6.jpg', '2025-03-30 12:50:37');

-- --------------------------------------------------------

--
-- Table structure for table `homestays`
--

CREATE TABLE `homestays` (
  `homestay_id` int(11) NOT NULL,
  `host_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `facilities` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`facilities`)),
  `image` longtext NOT NULL,
  `status` enum('active','inactive','deleted') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hosts`
--

CREATE TABLE `hosts` (
  `host_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `state` varchar(100) NOT NULL,
  `district` varchar(100) NOT NULL,
  `village` varchar(100) NOT NULL,
  `pincode` varchar(10) NOT NULL,
  `bio` text DEFAULT NULL,
  `languages_spoken` varchar(255) DEFAULT NULL,
  `skills` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`skills`)),
  `specialties` text DEFAULT NULL,
  `experience_years` int(11) NOT NULL,
  `availability` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`availability`)),
  `homestay_available` enum('yes','no') DEFAULT 'no',
  `verification_status` enum('pending','approved','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hosts`
--

INSERT INTO `hosts` (`host_id`, `user_id`, `state`, `district`, `village`, `pincode`, `bio`, `languages_spoken`, `skills`, `specialties`, `experience_years`, `availability`, `homestay_available`, `verification_status`, `created_at`) VALUES
(15, 55, 'Gujarat', 'Ahmedabad', 'Village A1', '380001', 'This is me', 'Hindi, English', '[]', NULL, 1, '[]', 'yes', 'approved', '2025-03-30 07:57:51'),
(16, 63, 'Gujarat', 'Ahmedabad', 'Village A1', '380001', NULL, NULL, '[]', NULL, 0, '[]', 'no', 'approved', '2025-04-10 11:38:19');

-- --------------------------------------------------------

--
-- Table structure for table `host_page`
--

CREATE TABLE `host_page` (
  `id` int(11) NOT NULL,
  `section_name` varchar(255) NOT NULL,
  `heading` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `host_page`
--

INSERT INTO `host_page` (`id`, `section_name`, `heading`, `content`, `icon`, `image`) VALUES
(1, 'hero_section', 'Become a Host', 'Turn your village home into a welcoming experience for travelers from around the world. Let them feel the warmth of rural life while you earn a livelihood.', NULL, NULL),
(2, 'benefit_1', 'Earn with Dignity', 'Provide travelers with a place to stay and get rewarded while sharing your culture.', 'bi-house-heart', NULL),
(3, 'benefit_2', 'Meet People from Around the World', 'Connect with travelers who want to experience real rural life and traditions.', 'bi-globe2', NULL),
(4, 'benefit_3', 'Make Lifelong Friendships', 'Welcome guests, share meals, and create memories that will last forever.', 'bi-emoji-smile', NULL),
(5, 'how_to_host', 'How to Become a Host?', 'Joining मिट्टीSafar as a host is easy! Just follow these simple steps:', NULL, 'join-host.jpg'),
(6, 'step_1', 'Sign Up', 'Register your home with us.', 'bi-check-circle', NULL),
(7, 'step_2', 'Get Verified', 'Our team will visit your place for verification.', 'bi-check-circle', NULL),
(8, 'step_3', 'Start Hosting', 'Welcome travelers and begin your journey!', 'bi-check-circle', NULL),
(9, 'testimonial_1', 'Ramesh Kumar, Rajasthan', 'I never thought my small home could become a place where people from all over the world would come and stay. Hosting has changed my life.', NULL, NULL),
(10, 'testimonial_2', 'Sunita Devi, Uttarakhand', 'The extra income from hosting helped me send my daughter to school. More than money, I gained respect in my community.', NULL, NULL),
(11, 'call_to_action', 'Join the मिट्टीSafar Family', 'Become a part of this journey and bring the world closer to your village.', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `location_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `district` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `message_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `otp` varchar(6) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `traveler_id` int(11) NOT NULL,
  `host_id` int(11) DEFAULT NULL,
  `experience_id` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `review_text` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `title`, `description`, `icon`, `created_at`) VALUES
(1, 'Cooking on a Chulha', 'Cook with local families using organic ingredients.', 'bi-fire', '2025-03-14 04:15:22'),
(2, 'Bullock Cart Ride', 'Experience slow travel on a traditional bullock cart.', 'bi-truck', '2025-03-14 04:15:22'),
(3, 'Hand Milking', 'Milk cows the traditional way and learn dairy farming.', 'bi-cup-straw', '2025-03-14 04:15:22'),
(4, 'Organic Farming', 'Learn how villagers cultivate crops using traditional methods.', 'bi-tree', '2025-03-14 04:15:22'),
(5, 'Community Volunteering', 'Help build better villages through education and sustainability.', 'bi-heart', '2025-03-14 04:15:22'),
(6, 'Sunset Tea by the Fields', 'Sip on homemade chai while watching the golden sun set over lush green fields. Feel the peace in every sip.', 'bi-cup-hot', '2025-03-14 04:26:54'),
(7, 'Traditional Folk Music & Dance', 'Join villagers in an unforgettable night of folk songs, rhythmic beats, and traditional dance performances.', 'bi-music-note', '2025-03-14 04:26:54'),
(8, 'Cooking on a Chulha', 'Learn the art of cooking on a mud stove with fresh organic produce, guided by loving grandmothers who have mastered the flavors of the land.', 'bi-fire', '2025-03-14 04:26:54'),
(9, 'Handwoven Dreams - Crafting with Artisans', 'Weave a story with your hands. Learn the age-old techniques of weaving, pottery, and embroidery, passed down through generations.', 'bi-brush', '2025-03-14 04:26:54'),
(10, 'Rural Storytelling Under the Stars', 'Under a blanket of stars, let village elders transport you to another world with timeless stories of love, courage, and magic.', 'bi-moon', '2025-03-14 04:26:54'),
(11, 'Bullock Cart Ride', 'Take a slow ride through the countryside on a traditional bullock cart, just as our ancestors did.', 'bi-truck', '2025-03-14 04:26:54'),
(13, 'Secret Waterfalls & Hidden Trails', 'Walk through uncharted trails and discover nature’s hidden treasures—waterfalls, ancient caves, and untouched beauty.', 'bi-water', '2025-03-14 04:26:54');

-- --------------------------------------------------------

--
-- Table structure for table `travelers`
--

CREATE TABLE `travelers` (
  `traveler_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `travel_preferences` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`travel_preferences`)),
  `emergency_contact` varchar(15) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `travelers`
--

INSERT INTO `travelers` (`traveler_id`, `user_id`, `travel_preferences`, `emergency_contact`, `created_at`) VALUES
(42, 61, NULL, '9642375842', '2025-03-31 05:13:54'),
(43, 62, NULL, '9568742325', '2025-03-31 12:55:16'),
(45, 65, NULL, '9685412305', '2025-04-10 12:04:55'),
(46, 66, NULL, '9958745896', '2025-04-11 06:42:35');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `date_of_birth` date NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `nationality` varchar(50) NOT NULL,
  `otp_code` varchar(6) DEFAULT NULL,
  `user_type` enum('admin','host','traveler') NOT NULL,
  `profile_pic` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive','banned') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `username`, `email`, `phone`, `password`, `date_of_birth`, `gender`, `nationality`, `otp_code`, `user_type`, `profile_pic`, `status`, `created_at`) VALUES
(55, 'Amit', 'Ghoyal', 'amit@123', 'amitgohil1105@gmail.com', '9510360227', '$2y$10$ffmbezgP69QicPN3Uia1i.ImqhFmDC7PZLld99HTj6lIULzsPR9YK', '2005-04-11', 'Male', 'indian', NULL, 'host', 'uploads/host_15_1743689060.jpeg', 'active', '2025-03-30 07:57:51'),
(56, 'Amit', 'Ghoyal', 'admin_123', 'amit@example.com', '9876543210', '$2y$10$5RLmBuJCOhNPhCn/0H13E.OtjNVNZn0SurKyXKISWV8Qh.LMDYkai', '1990-01-01', 'Male', 'Indian', NULL, 'admin', 'uploads/Logo.png', 'active', '2025-03-30 11:40:43'),
(61, 'Manish', 'Ghoyal', 'nimesh@123', 'manishgohil3036@gmail.com', '8855627941', '$2y$10$1HSHHlWl1JzVKQmmXk4Slucw5lmitMIb0E1tT47p7YySl4o9vYFeq', '2001-04-05', 'Male', 'Indian', NULL, 'traveler', 'uploads1744289901_WIN_20240218_17_19_49_Pro.jpg', 'active', '2025-03-31 05:13:54'),
(62, 'Nimesh', 'Gediya', 'nimesh', 'nimesh.gediya27@gmail.com', '9327740662', '123456', '2005-04-27', 'Male', 'Indian', NULL, 'traveler', 'uploads/1743321471_Screenshot_2025-03-27-19-49-22-288_com.instagram.android.jpg', 'active', '2025-03-31 12:55:16'),
(63, 'Nimesh', 'Gediya', 'Nimesh@1', 'nimesh11@gmail.com', '8546213584', '$2y$10$rtfr2fLMVccy5bjO1zYi/eWzDPS0hm81ueAVzvd/RRtTqaG.B/5tq', '2004-02-27', 'Male', '', NULL, 'host', 'uploads/1744285099_Poster.png', 'active', '2025-04-10 11:38:19'),
(65, 'Satish', 'Zapadiya', 'Satish', 'satish11@gmail.com', '9685741231', '$2y$10$ezFs/kHdaKQyXaNzrL3.4ewAUp5c59aHiYAyUSYA1bbAomNHW2hJu', '2005-02-21', 'Male', 'Indian', NULL, 'traveler', 'uploads/profile_photos/profile_67f7b3e7c95094.13924832.png', 'active', '2025-04-10 12:04:55'),
(66, 'ckp', 'collage', 'ckpcmc', 'ckp1105@gmail.com', '9987456325', '$2y$10$UL/Jhu.AevN0AlK08qR0u.886hhs2N0bT0W00u6LXsy289Xqe6PFi', '2005-04-27', 'Male', 'Indian', NULL, 'traveler', 'uploads/profile_photos/profile_67f8b9dbc8b9e5.77488935.jpg', 'active', '2025-04-11 06:42:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about_page`
--
ALTER TABLE `about_page`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `traveler_id` (`traveler_id`),
  ADD KEY `experience_id` (`experience_id`);

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`chat_id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `experiences`
--
ALTER TABLE `experiences`
  ADD PRIMARY KEY (`experience_id`),
  ADD KEY `host_id` (`host_id`);

--
-- Indexes for table `experiences_about`
--
ALTER TABLE `experiences_about`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `experiences_homepage`
--
ALTER TABLE `experiences_homepage`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `festival_bookings`
--
ALTER TABLE `festival_bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `traveler_id` (`traveler_id`),
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `festival_services`
--
ALTER TABLE `festival_services`
  ADD PRIMARY KEY (`service_id`),
  ADD KEY `host_id` (`host_id`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `homepage_content`
--
ALTER TABLE `homepage_content`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `homestays`
--
ALTER TABLE `homestays`
  ADD PRIMARY KEY (`homestay_id`),
  ADD KEY `host_id` (`host_id`);

--
-- Indexes for table `hosts`
--
ALTER TABLE `hosts`
  ADD PRIMARY KEY (`host_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `host_page`
--
ALTER TABLE `host_page`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `section_name` (`section_name`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`location_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `traveler_id` (`traveler_id`),
  ADD KEY `host_id` (`host_id`),
  ADD KEY `experience_id` (`experience_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `travelers`
--
ALTER TABLE `travelers`
  ADD PRIMARY KEY (`traveler_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about_page`
--
ALTER TABLE `about_page`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `chat_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `experiences`
--
ALTER TABLE `experiences`
  MODIFY `experience_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `experiences_about`
--
ALTER TABLE `experiences_about`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `experiences_homepage`
--
ALTER TABLE `experiences_homepage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `festival_bookings`
--
ALTER TABLE `festival_bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `festival_services`
--
ALTER TABLE `festival_services`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `homepage_content`
--
ALTER TABLE `homepage_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `homestays`
--
ALTER TABLE `homestays`
  MODIFY `homestay_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `hosts`
--
ALTER TABLE `hosts`
  MODIFY `host_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `host_page`
--
ALTER TABLE `host_page`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `location_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `travelers`
--
ALTER TABLE `travelers`
  MODIFY `traveler_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`traveler_id`) REFERENCES `travelers` (`traveler_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`experience_id`) REFERENCES `experiences` (`experience_id`) ON DELETE CASCADE;

--
-- Constraints for table `chats`
--
ALTER TABLE `chats`
  ADD CONSTRAINT `chats_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `chats_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `experiences`
--
ALTER TABLE `experiences`
  ADD CONSTRAINT `experiences_ibfk_1` FOREIGN KEY (`host_id`) REFERENCES `hosts` (`host_id`) ON DELETE CASCADE;

--
-- Constraints for table `festival_bookings`
--
ALTER TABLE `festival_bookings`
  ADD CONSTRAINT `festival_bookings_ibfk_1` FOREIGN KEY (`traveler_id`) REFERENCES `travelers` (`traveler_id`),
  ADD CONSTRAINT `festival_bookings_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `festival_services` (`service_id`);

--
-- Constraints for table `festival_services`
--
ALTER TABLE `festival_services`
  ADD CONSTRAINT `festival_services_ibfk_1` FOREIGN KEY (`host_id`) REFERENCES `hosts` (`host_id`) ON DELETE CASCADE;

--
-- Constraints for table `homestays`
--
ALTER TABLE `homestays`
  ADD CONSTRAINT `homestays_ibfk_1` FOREIGN KEY (`host_id`) REFERENCES `hosts` (`host_id`) ON DELETE CASCADE;

--
-- Constraints for table `hosts`
--
ALTER TABLE `hosts`
  ADD CONSTRAINT `hosts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD CONSTRAINT `password_reset_tokens_ibfk_1` FOREIGN KEY (`email`) REFERENCES `users` (`email`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`traveler_id`) REFERENCES `travelers` (`traveler_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`host_id`) REFERENCES `hosts` (`host_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_3` FOREIGN KEY (`experience_id`) REFERENCES `experiences` (`experience_id`) ON DELETE CASCADE;

--
-- Constraints for table `travelers`
--
ALTER TABLE `travelers`
  ADD CONSTRAINT `travelers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
