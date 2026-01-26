<?php
session_start();
include '../config/db_connect.php';
include '../config/razorpay_config.php';
require '../vendor/autoload.php';

use Razorpay\Api\Api;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $service_id = $_POST['service_id'];
    $traveler_id = $_POST['traveler_id'];
    $booking_date = $_POST['booking_date'];
    $num_people = $_POST['num_people'];
    $final_amount = $_POST['final_amount'];
    $razorpay_payment_id = $_POST['razorpay_payment_id'];

    $api = new Api(RAZORPAY_KEY_ID, RAZORPAY_KEY_SECRET);

    try {
        $payment = $api->payment->fetch($razorpay_payment_id);

        if ($payment->status == "captured") {
            mysqli_begin_transaction($conn);

            $payment_query = "INSERT INTO payments (traveler_id, service_id, amount, payment_status, razorpay_payment_id)
                              VALUES (?, ?, ?, 'Paid', ?)";
            $stmt_payment = mysqli_prepare($conn, $payment_query);
            mysqli_stmt_bind_param($stmt_payment, "iids", $traveler_id, $service_id, $final_amount, $razorpay_payment_id);
            $payment_result = mysqli_stmt_execute($stmt_payment);
            $payment_id = mysqli_insert_id($conn);

            if ($payment_result) {
                $booking_query = "INSERT INTO festival_bookings (service_id, traveler_id, selected_date, num_people, amount_paid, payment_status, razorpay_payment_id)
                                  VALUES (?, ?, ?, ?, ?, 'Paid', ?)";
                $stmt_booking = mysqli_prepare($conn, $booking_query);
                mysqli_stmt_bind_param($stmt_booking, "iisids", $service_id, $traveler_id, $booking_date, $num_people, $final_amount, $razorpay_payment_id);
                $booking_result = mysqli_stmt_execute($stmt_booking);

                if ($booking_result) {
                    mysqli_commit($conn);
                    echo "Booking confirmed!";
                } else {
                    mysqli_rollback($conn);
                    echo "Database error while booking!";
                }
            } else {
                mysqli_rollback($conn);
                echo "Database error while recording payment!";
            }
        } else {
            echo "Payment verification failed!";
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
