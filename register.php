<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Your Role - MittiSafar</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <style>
        /* General Styling */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Background Image */
        body {
            font-family: 'Poppins', sans-serif;
            background: url('assets/img/bg-village.jpg') center/cover no-repeat fixed;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            position: relative;
        }

        /* Dark Overlay for Readability */
        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            z-index: 1;
        }

        /* Container Styling */
        .container {
            position: relative;
            z-index: 2;
            text-align: center;
            background: rgba(255, 255, 255, 0.1);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
            max-width: 750px;
            width: 90%;
        }

        /* Title Styling */
        h2 {
            font-weight: 600;
            margin-bottom: 25px;
            letter-spacing: 1px;
            text-transform: uppercase;
            background: linear-gradient(to right, #FF9800, #F57C00);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Role Box Styling */
        .role-box {
            background: rgba(255, 255, 255, 0.2);
            padding: 25px;
            border-radius: 12px;
            transition: 0.4s ease-in-out;
            text-align: center;
            box-shadow: 0 5px 15px rgba(255, 255, 255, 0.1);
            position: relative;
            overflow: hidden;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        /* Glowing Effect on Hover */
        .role-box:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.05);
            box-shadow: 0 10px 25px rgba(255, 255, 255, 0.2);
        }

        /* Neon Glow Borders */
        .role-box::before {
            content: "";
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(45deg, #FFA726, #FF5722);
            z-index: -1;
            opacity: 0;
            transition: opacity 0.3s;
            border-radius: 12px;
        }

        .role-box:hover::before {
            opacity: 1;
        }

        /* Button Styling */
        .btn-custom {
            background: linear-gradient(120deg, #444, #222);
            border: none;
            padding: 12px;
            font-size: 18px;
            border-radius: 8px;
            width: 100%;
            color: white;
            font-weight: 500;
            transition: all 0.3s ease-in-out;
            text-transform: uppercase;
        }

        .btn-custom:hover {
            background: linear-gradient(120deg, #222, #111);
            box-shadow: 0 4px 15px rgba(255, 255, 255, 0.2);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 30px;
            }
            .role-box {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Choose Your Path in <span style="color: #FFA726;">MittiSafar</span></h2>
        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="role-box p-4">
                    <h3>Rural Host</h3>
                    <p>Share your culture, traditions, and experiences with travelers from across the world.</p>
                    <a href="register_host.php" class="btn btn-custom">Register as a Host</a>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="role-box p-4">
                    <h3>Urban Traveler</h3>
                    <p>Experience the authentic village life, learn new skills, and reconnect with nature.</p>
                    <a href="register_traveler.php" class="btn btn-custom">Register as a Traveler</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
