You said:
<?php
session_start();
include '../config/db_connect.php';
include '../config/razorpay_config.php';

use Razorpay\Api\Api;

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $razorpay_payment_id = $_POST['razorpay_payment_id'] ?? '';
    $razorpay_order_id = $_POST['razorpay_order_id'] ?? '';
    $razorpay_signature = $_POST['razorpay_signature'] ?? '';
    $service_id = $_POST['service_id'] ?? '';
    $booking_date = $_POST['booking_date'] ?? '';
    $num_people = $_POST['num_people'] ?? '';
    $amount = $_POST['amount'] ?? '';

    // Fetch user_id from session
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(["status" => "error", "message" => "User not logged in."]);
        exit();
    }
    $user_id = $_SESSION['user_id'];

    if (!$razorpay_payment_id || !$razorpay_order_id || !$razorpay_signature) {
        echo json_encode(["status" => "error", "message" => "Invalid payment details."]);
        exit();
    }

    try {
        $api = new Api(RAZORPAY_KEY_ID, RAZORPAY_KEY_SECRET);
        $attributes = [
            'razorpay_payment_id' => $razorpay_payment_id,
            'razorpay_order_id' => $razorpay_order_id,
            'razorpay_signature' => $razorpay_signature
        ];
        
        $api->utility->verifyPaymentSignature($attributes);

        // Update booking status in the database
        $update_query = "UPDATE festival_bookings SET status = 'confirmed', payment_id = ? WHERE user_id = ? AND service_id = ? AND booking_date = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param('siis', $razorpay_payment_id, $user_id, $service_id, $booking_date);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            // Fetch user details from users table
            $user_query = "SELECT email, name FROM users WHERE user_id = ?";
            $stmt = $conn->prepare($user_query);
            $stmt->bind_param('i', $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();

            if ($user) {
                // Send email using mail() function
                $to = $user['email'];
                $subject = "Booking Confirmation - MittiSafar";
                $message = "Dear {$user['name']},\n\n"
                         . "Your booking for the festival service has been confirmed.\n\n"
                         . "Booking Date: {$booking_date}\n"
                         . "Number of People: {$num_people}\n"
                         . "Total Amount Paid: ₹{$amount}\n\n"
                         . "Thank you for choosing MittiSafar!\n\n"
                         . "Best regards,\nMittiSafar Team";
                $headers = "From: no-reply@mittisafar.com" . "\r\n" . "Reply-To: support@mittisafar.com";

                mail($to, $subject, $message, $headers);
            }

            echo json_encode(["status" => "success", "message" => "Payment verified and booking confirmed."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Booking update failed."]);
        }
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => "Payment verification failed."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}
?>  