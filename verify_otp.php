<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'config/db_connect.php'; // Database connection
if (!isset($_SESSION['email'])) {
    header("Location: forgot_password.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_SESSION['email'];
    $otp = trim($_POST['otp']);

    // Validate OTP format (Only 6-digit numbers allowed)
    if (!preg_match('/^\d{6}$/', $otp)) {
        $_SESSION['error'] = "Invalid OTP format.";
        header("Location: verify_otp.php");
        exit();
    }

    // Fetch OTP from the database
    $stmt = $conn->prepare("SELECT otp, expires_at FROM password_reset_tokens WHERE email = ? ORDER BY id DESC LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($db_otp, $expires_at);
        $stmt->fetch();

        // Check if OTP has expired
        if (strtotime($expires_at) < time()) {
            $_SESSION['error'] = "OTP has expired.";
            header("Location: verify_otp.php");
            exit();
        }

        // Verify OTP
        if ((string)$db_otp === (string)$otp) {
            $_SESSION['otp_verified'] = true;
            $_SESSION['otp_verified_success'] = "OTP verified successfully! Now you can reset your password.";
            
            // Delete OTP after successful verification
            $deleteStmt = $conn->prepare("DELETE FROM password_reset_tokens WHERE email = ?");
            $deleteStmt->bind_param("s", $email);
            $deleteStmt->execute();

            header("Location: reset_password.php");
            exit();
        } else {
            $_SESSION['error'] = "Invalid OTP.";
            header("Location: verify_otp.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "No OTP found.";
        header("Location: verify_otp.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP - Mitti Safar</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- Custom Styles -->
    <style>
        .custom-bg {
            background-color: #28395a;
            background-image: url(assets/img/gallery/mitti_safar_bg.png);
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 731px;
        }
        .custom-btn {
            background-color: #FFA726;
            border-color: #FFA726;
        }
        .custom-btn:hover {
            background-color: #FF9100;
            border-color: #FF9100;
        }
        .custom-text-color {
            color: #FFA726;
        }
        .custom-hr {
            border-color: #FFA726;
        }
        .container {
            padding-top: 70px;
        }
        .error-message {
            color: red;
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>
<body>

<section class="custom-bg py-3 py-md-5 py-xl-8">
    <div class="container">
        <div class="row gy-4 align-items-center">
            <div class="col-12 col-md-6 col-xl-7">
                <div class="d-flex justify-content-center">
                    <div class="col-12 col-xl-9">
                        <a href="index.php">
                            <img class="img-fluid rounded mb-4" loading="lazy" src="assets/img/logo2.png" width="245" height="80" alt="Mitti Safar Logo">
                        </a>     
                        <hr class="custom-hr mb-4">
                        <h2 class="h1 mb-4 text-white">MittiSafar – Connecting Rural India to the World</h2>
                        <p class="lead mb-5 text-white">
                            "MittiSafar is a platform that bridges the gap between urban travelers and rural hosts, offering authentic village experiences while empowering local communities. Whether it's staying in a homestay, experiencing traditional farming, or learning handicrafts, MittiSafar provides travelers with a real taste of rural Bharat."
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-xl-5">
                <div class="card border-0 rounded-4">

<?php
if (isset($_SESSION['otp_success'])) {
    echo '
    <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
        <strong>Success!</strong> ' . $_SESSION['otp_success'] . '
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>';
    unset($_SESSION['otp_success']);
}
?>

                    <div class="card-body p-3 p-md-4 p-xl-5">
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-4">
                                    <h3 class="custom-text-color">Verify OTP</h3>
                                    <p>Enter the OTP sent to your email to proceed.</p>
                                </div>
                            </div>
                        </div>
                        <?php if (isset($_SESSION['error'])): ?>
                            <p class="error-message"> <?= $_SESSION['error']; ?> </p>
                            <?php unset($_SESSION['error']); ?>
                        <?php endif; ?>
                        <form method="POST" action="">
                            <div class="row gy-3 overflow-hidden">
                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control text-center" name="otp" id="otp" placeholder="Enter 6-digit OTP" required pattern="\d{6}" maxlength="6">
                                        <label for="otp" class="form-label">Enter 6-digit OTP</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-grid">
                                        <button class="btn custom-btn" type="submit">Verify OTP</button>
                                    </div>
                                </div>
                                <div class="col-12 text-center mt-2">
                                    <a href="forgot_password.php" class="custom-text-color">Resend OTP?</a>
                                </div>
                                <div class="col-12 text-center mt-2">
                                    <a href="login.php" class="custom-text-color">Back to Login</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Required JS for Bootstrap 4 dismissible alerts -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
