<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

include '../config/db_connect.php';

$errors = [];
$success = "";

// Function to validate and upload images
function uploadImage($file, $uploadDir) {
    $allowedExtensions = ['jpg', 'jpeg', 'png'];
    $maxFileSize = 2 * 1024 * 1024; // 2MB

    $fileName = basename($file["name"]);
    $fileTmp = $file["tmp_name"];
    $fileSize = $file["size"];
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    if (!in_array($fileExt, $allowedExtensions)) {
        return "Invalid file type. Only JPG and PNG are allowed.";
    }

    if ($fileSize > $maxFileSize) {
        return "File size exceeds 2MB.";
    }

    $newFileName = uniqid() . "." . $fileExt;
    $destination = $uploadDir . $newFileName;

    if (move_uploaded_file($fileTmp, $destination)) {
        return $newFileName;
    } else {
        return "Error uploading file.";
    }
}

// Update Homepage Content
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_homepage'])) {
    $section = $_POST['section'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $imagePath = null;

    if (!empty($_FILES['image']['name'])) {
        $imageUpload = uploadImage($_FILES['image'], "../assets/img/");
        if (strpos($imageUpload, "Error") === false) {
            $imagePath = $imageUpload;
        } else {
            $errors[] = $imageUpload;
        }
    }

    if (empty($errors)) {
        $sql = "UPDATE homepage_content SET title=?, description=?";
        if ($imagePath) {
            $sql .= ", image=?";
        }
        $sql .= " WHERE section=?";
        
        $stmt = $conn->prepare($sql);
        if ($imagePath) {
            $stmt->bind_param("ssss", $title, $description, $imagePath, $section);
        } else {
            $stmt->bind_param("sss", $title, $description, $section);
        }
        if ($stmt->execute()) {
            $success = "Homepage content updated successfully!";
        } else {
            $errors[] = "Failed to update homepage content.";
        }
    }
}

$homepageData = mysqli_query($conn, "SELECT * FROM homepage_content");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Homepage - Admin Panel</title>
    <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/vendor/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/main.css">
    <style>
        body {
            background: linear-gradient(to right, #ece9e6, #ffffff);
            font-family: 'Poppins', sans-serif;
        }
        .container {
            max-width: 1200px;
        }
        .card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        h2 {
            font-weight: 700;
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }
        .btn-custom {
            background: #6c5ce7;
            color: #fff;
            border-radius: 8px;
            transition: 0.3s;
        }
        .btn-custom:hover {
            background: #a29bfe;
            transform: scale(1.05);
        }
        .image-preview {
            display: block;
            width: 100%;
            max-width: 250px;
            border-radius: 10px;
            transition: 0.3s;
        }
        .image-preview:hover {
            transform: scale(1.05);
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.2);
        }
    </style>
    <script>
        function previewImage(event, imgId) {
            const reader = new FileReader();
            reader.onload = function () {
                document.getElementById(imgId).src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</head>
<body>

<?php include("../includes/admin_header.php"); ?>

<div class="container mt-4">
    <h2>✨ Edit Homepage Content ✨</h2>

    <?php if (!empty($errors)) : ?>
        <div class="alert alert-danger"><?= implode("<br>", $errors); ?></div>
    <?php endif; ?>
    <?php if ($success) : ?>
        <div class="alert alert-success"><?= $success; ?></div>
    <?php endif; ?>

    <!-- Homepage Content -->
    <div class="row">
        <?php while ($row = mysqli_fetch_assoc($homepageData)) : ?>
            <div class="col-md-6">
                <form method="POST" enctype="multipart/form-data" class="card p-4 mb-4">
                    <h4 class="text-center text-primary"><?= ucfirst($row['section']); ?> Section</h4>
                    <input type="hidden" name="section" value="<?= $row['section']; ?>">

                    <label class="fw-bold">Title:</label>
                    <input type="text" name="title" class="form-control mb-2" value="<?= $row['title']; ?>" required>

                    <label class="fw-bold">Description:</label>
                    <textarea name="description" class="form-control mb-2"><?= $row['description']; ?></textarea>

                    <label class="fw-bold">Current Image:</label>
                    <div class="text-center mb-2">
                        <img id="preview_<?= $row['section']; ?>" src="../assets/img/<?= $row['image']; ?>" class="image-preview">
                    </div>

                    <label class="fw-bold">Upload New Image:</label>
                    <input type="file" name="image" class="form-control mb-2" accept="image/*" onchange="previewImage(event, 'preview_<?= $row['section']; ?>')">

                    <button type="submit" name="update_homepage" class="btn btn-custom w-100">Update</button>
                </form>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
