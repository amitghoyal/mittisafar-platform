<?php
session_start();
if (!isset($_SESSION['traveler_id'])) {
    header("Location: login.php");
    exit();
}

include '../config/db_connect.php';
include '../includes/traveler_header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['book_homestay'])) {
    $traveler_id = $_SESSION['traveler_id'];
    $homestay_id = $_POST['homestay_id'];

    $query = "INSERT INTO homestay_bookings (traveler_id, homestay_id) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $traveler_id, $homestay_id);

    if ($stmt->execute()) {
        echo "<script>alert('Homestay booking successful!'); window.location.href='manage_homestays.php';</script>";
    } else {
        echo "<script>alert('Booking failed! Try again.');</script>";
    }
}

// Fetch only approved homestays
$query = "SELECT * FROM homestays WHERE status = 'approved'";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Homestay</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card img { height: 200px; object-fit: cover; }
        .btn-primary { background-color: #D98F4E; border-color: #D98F4E; }
        .btn-primary:hover { background-color: #593434; }
    </style>
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Available Homestays</h2>
    <div class="row">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $facilities = json_decode($row['facilities'], true);
                echo '
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm">
                        <img src="../assets/img/'.$row['image'].'" class="card-img-top" alt="'.$row['name'].'">
                        <div class="card-body text-center">
                            <h5 class="card-title">'.$row['name'].'</h5>
                            <p class="card-text">'.substr($row['description'], 0, 80).'...</p>
                            <p class="fw-bold">₹'.$row['price'].' per night</p>
                            <p><strong>Facilities:</strong> '.implode(", ", $facilities).'</p>
                            <form method="POST" onsubmit="return confirm(\'Are you sure you want to book this homestay?\')">
                                <input type="hidden" name="homestay_id" value="'.$row['homestay_id'].'">
                                <button type="submit" name="book_homestay" class="btn btn-primary">Book Now</button>
                            </form>
                        </div>
                    </div>
                </div>';
            }
        } else {
            echo '<p class="text-center text-muted">No homestays available.</p>';
        }
        ?>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
