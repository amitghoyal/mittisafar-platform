<?php
session_start();
if (isset($_SESSION['success'])) {
    echo "<div class='alert alert-success'>" . $_SESSION['success'] . "</div>";
    unset($_SESSION['success']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Mitti Safar</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
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
                        <div class="card-body p-3 p-md-4 p-xl-5">
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-4">
                                        <h3 class="custom-text-color">Login</h3>
                                        <p>Don't have an account yet? <a href="register.php" class="custom-text-color">Register here</a></p>
                                    </div>
                                </div>
                            </div>
                            <?php if (isset($_SESSION['error'])): ?>
                                <p class="error-message"> <?= $_SESSION['error']; ?> </p>
                                <?php unset($_SESSION['error']); ?>
                            <?php endif; ?>
                            <form action="process_login.php" method="POST">
                                <div class="row gy-3 overflow-hidden">
                                    <div class="col-12">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" name="username" id="username" placeholder="Username" required>
                                            <label for="username" class="form-label">Username:</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating mb-3">
                                            <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                                            <label for="password" class="form-label">Password:</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-grid">
                                            <button class="btn custom-btn" type="submit">Sign In</button>
                                        </div>
                                    </div>
                                    <div class="col-12 text-center mt-2">
    <a href="forgot_password.php" class="custom-text-color">Forgot Password?</a>
</div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>