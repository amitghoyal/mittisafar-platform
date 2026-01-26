<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Mitti Safar</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
     .custom-bg {
        background-color: #28395a;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .custom-btn {
        background-color: #FFA726;
        border-color: #FFA726;
        transition: 0.3s;
    }
    .custom-btn:hover {
        background-color: #FF9100;
        border-color: #FF9100;
    }
    .custom-text-color {
        color: #FFA726;
    }
    .error-message, .success-message {
        font-weight: bold;
        text-align: center;
        padding: 5px;
    }
    .error-message { color: red; }
    .success-message { color: green; }
    .card {
        border-radius: 10px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
    }
    .form-control {
        padding: 10px;
    }
    </style>
</head>
<body>
    <div class="custom-bg">
        <div class="card p-4">
            <div class="card-body">
                <h3 class="custom-text-color text-center">Forgot Password</h3>
                <p class="text-center">Enter your registered email to receive a password reset link.</p>

                <?php 
                if (isset($_SESSION['error'])) {
                    echo "<p class='error-message'>" . $_SESSION['error'] . "</p>";
                    unset($_SESSION['error']);
                }
                if (isset($_SESSION['success'])) {
                    echo "<p class='success-message'>" . $_SESSION['success'] . "</p>";
                    unset($_SESSION['success']);
                }
                ?>

                <form action="process_forgot_password.php" method="POST">
                    <div class="mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                    </div>
                    <button type="submit" class="btn custom-btn w-100">Send Reset Link</button>
                </form>

                <div class="text-center mt-3">
                    <a href="login.php" class="custom-text-color">Back to Login</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
