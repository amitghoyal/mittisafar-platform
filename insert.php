<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "mittisafar"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$location_name = "Goa"; 
$location_sql = "INSERT INTO `locations` (`name`) VALUES ('$location_name') 
                 ON DUPLICATE KEY UPDATE location_id=LAST_INSERT_ID(location_id)";
if ($conn->query($location_sql) === TRUE) {
    $location_id = $conn->insert_id;
} else {
    die("Error inserting location: " . $conn->error);
}

$hashed_password = password_hash("securePass@123", PASSWORD_BCRYPT);

$user_sql = "INSERT INTO `users` (`first_name`, `last_name`, `username`, `email`, `phone`, `password`, `date_of_birth`, `gender`, `nationality`, `otp_code`, `user_type`, `profile_pic`, `status`, `created_at`) 
VALUES ('Rahul', 'Singh', 'amit_singh', 'amit.singh@email.com', '9580420928', '$hashed_password', '1990-06-15', 'Male', 'Indian', NULL, 'traveler', NULL, 'active', NOW())";

if ($conn->query($user_sql) === TRUE) {
    $user_id = $conn->insert_id; 
    echo "User inserted successfully! User ID: $user_id<br>";

    $traveler_sql = "INSERT INTO `travelers` (`user_id`, `location_id`, `travel_preferences`, `emergency_contact`, `past_experiences`, `created_at`) 
    VALUES ($user_id, $location_id, '{\"preferred_transport\": \"Flight\", \"accommodation\": \"Hotel\", \"budget\": \"Mid-range\"}', '9876543211', 'Loves trekking in the Himalayas.', NOW())";

    if ($conn->query($traveler_sql) === TRUE) {
        echo "Traveler data inserted successfully!";
    } else {
        echo "Error inserting traveler data: " . $conn->error;
    }
} else {
    echo "Error inserting user data: " . $conn->error;
}

$conn->close();
?>
