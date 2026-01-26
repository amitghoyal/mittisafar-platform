<?php
session_start();
include '../config/db_connect.php';
include '../config/razorpay_config.php';

require('../vendor/autoload.php'); // Ensure you installed Razorpay SDK via Composer

use Razorpay\Api\Api;

$api = new Api(RAZORPAY_KEY_ID, RAZORPAY_KEY_SECRET);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $service_id = $_POST['service_id'];
    $traveler_id = $_POST['traveler_id'];
    $booking_date = $_POST['booking_date'];
    $num_people = $_POST['num_people'];
    $amount = $_POST['amount']; // Final amount including GST

    // Convert amount to paise (Razorpay requires amount in paise)
    $final_amount = $amount * 100;

    try {
        $order = $api->order->create([
            'receipt' => 'ORDER_' . time(),
            'amount' => $final_amount,
            'currency' => 'INR',
            'payment_capture' => 1 // Auto capture payment
        ]);

        $response = [
            "status" => "success",
            "order_id" => $order->id,
            "amount" => $amount
        ];
    } catch (Exception $e) {
        $response = [
            "status" => "error",
            "message" => $e->getMessage()
        ];
    }

    echo json_encode($response);
}
?>
