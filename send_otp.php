<?php
session_start();
include 'config/db_connect.php';

if (isset($_POST['phone'])) {
    $phone = $_POST['phone'];
    $otp = rand(100000, 999999); // Generate a 6-digit OTP

    // Store OTP in session (temporary storage)
    $_SESSION['otp'] = $otp;
    $_SESSION['phone'] = $phone;

    // ✅ Replace with your actual Fast2SMS API key
    $api_key = "YOUR_FAST2SMS_API_KEY";
    $sender_id = "MITTISAFAR";  // ✅ Must be DLT-approved
    $message = "Your OTP for MittiSafar registration is: $otp. Do not share it.";
    $route = "q";  // ✅ Use 'q' for transactional, 'p' for promotional
    $language = "english";

    // ✅ Make sure `variables_values` is properly set if using DLT templates
    $postData = [
        "authorization" => $api_key,
        "route" => $route,
        "sender_id" => $sender_id,
        "message" => urlencode($message),
        "language" => $language,
        "flash" => "0",
        "numbers" => $phone
    ];

    // API URL
    $sms_url = "https://www.fast2sms.com/dev/bulkV2";

    // ✅ Send request using cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $sms_url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["cache-control: no-cache"]);

    $response = curl_exec($ch);
    curl_close($ch);

    // ✅ Debugging: Check response
    file_put_contents('sms_debug.log', $response);  // Log response for debugging

    if ($response) {
        echo json_encode(["status" => "success", "message" => "OTP Sent Successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to Send OTP"]);
    }
}
?>
