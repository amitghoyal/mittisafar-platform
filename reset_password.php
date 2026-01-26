<?php
session_start();
require 'config/db_connect.php'; // Database connection

if (!isset($_SESSION['otp_verified']) || !isset($_SESSION['email'])) {
    header("Location: forgot_password.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_SESSION['email'];
    $new_password = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Validate password length
    if (strlen($new_password) < 6) {
        $_SESSION['error'] = "Password must be at least 6 characters long.";
        header("Location: reset_password.php");
        exit();
    }

    // Check if passwords match
    if ($new_password !== $confirm_password) {
        $_SESSION['error'] = "Passwords do not match.";
        header("Location: reset_password.php");
        exit();
    }

    // Hash the new password
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Update password in users table
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
    $stmt->bind_param("ss", $hashed_password, $email);
    if ($stmt->execute()) {
        // Remove OTP from database
        $stmt = $conn->prepare("DELETE FROM password_reset_tokens WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();

        // Clear session and redirect to login
        session_unset();
        session_destroy();
        header("Location: login.php?success=Password reset successful! Please login.");
        exit();
    } else {
        $_SESSION['error'] = "Something went wrong. Try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Mitti Safar</title>

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
        .toggle-password {
            cursor: pointer;
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
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
if (isset($_SESSION['otp_verified_success'])) {
    echo '
    <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
        <strong>Success!</strong> ' . $_SESSION['otp_verified_success'] . '
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>';
    unset($_SESSION['otp_verified_success']);
}
?>

                    <div class="card-body p-3 p-md-4 p-xl-5">
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-4">
                                    <h3 class="custom-text-color">Reset Password</h3>
                                    <p>Enter a new password to secure your account.</p>
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
                                    <div class="form-floating mb-3 position-relative">
                                        <input type="password" class="form-control" name="new_password" id="new_password" placeholder="New Password" required>
                                        <label for="new_password" class="form-label">New Password:</label>
                                        <span class="toggle-password" onclick="togglePassword('new_password')">👁️</span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating mb-3 position-relative">
                                        <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required>
                                        <label for="confirm_password" class="form-label">Confirm Password:</label>
                                        <span class="toggle-password" onclick="togglePassword('confirm_password')">👁️</span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-grid">
                                        <button class="btn custom-btn" type="submit">Reset Password</button>
                                    </div>
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

<!-- Bootstrap JS -->
<script src="assets/js/bootstrap.bundle.min.js"></script>

<!-- Password Toggle Script -->
<script>
    function togglePassword(fieldId) {
        var input = document.getElementById(fieldId);
        if (input.type === "password") {
            input.type = "text";
        } else {
            input.type = "password";
        }
    }
</script>

</body>
</html>
