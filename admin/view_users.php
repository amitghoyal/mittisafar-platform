<?php
include ('../config/db_connect.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View All Users | Mitti Safar</title>
    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/vendor/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/main.css">
</head>
<body>
<?php
include ('../includes/admin_header.php');
?>
<div class="container mt-5">
    <h2 class="text-center mb-4">View All Users</h2>
    
    <div class="card shadow">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5>User Details</h5>
            <div>
                <a href="export_users.php" class="btn btn-success btn-sm">Export to Excel</a>
                <button onclick="printTable()" class="btn btn-secondary btn-sm">Print</button>
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-4">
                    <input type="text" id="search" class="form-control" placeholder="Search by Name, Email, Phone...">
                </div>
            </div>

            <table class="table table-striped table-bordered" id="userTable">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Profile</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>User Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $limit = 10;
                    $page = isset($_GET['page']) ? $_GET['page'] : 1;
                    $start = ($page - 1) * $limit;

                    $query = "SELECT * FROM users LIMIT $start, $limit";
                    $result = mysqli_query($conn, $query);

                    while ($row = mysqli_fetch_assoc($result)) {
                        $profilePic = !empty($row['profile_pic']) ? $row['profile_pic'] : 'default.jpg';
                        echo "
                        <tr>
                            <td>{$row['user_id']}</td>
                            <td><img src='../{$profilePic}' width='50' height='50' class='rounded-circle'></td>
                            <td>{$row['first_name']} {$row['last_name']}</td>
                            <td>{$row['email']}</td>
                            <td>{$row['phone']}</td>
                            <td>{$row['user_type']}</td>
                            <td>
                                <a href='view_user_details.php?id={$row['user_id']}' class='btn btn-info btn-sm'>View</a>
                            </td>
                        </tr>";
                    }
                    ?>
                </tbody>
            </table>

            <?php
            // Pagination
            $total_query = "SELECT COUNT(*) FROM users";
            $total_result = mysqli_query($conn, $total_query);
            $total_users = mysqli_fetch_array($total_result)[0];
            $total_pages = ceil($total_users / $limit);

            echo '<nav><ul class="pagination justify-content-center">';
            for ($i = 1; $i <= $total_pages; $i++) {
                echo "<li class='page-item'><a class='page-link' href='view_users.php?page=$i'>$i</a></li>";
            }
            echo '</ul></nav>';
            ?>
        </div>
    </div>
</div>

<script>
document.getElementById('search').addEventListener('keyup', function() {
    let filter = this.value.toLowerCase();
    let rows = document.querySelectorAll('#userTable tbody tr');

    rows.forEach(row => {
        let text = row.textContent.toLowerCase();
        row.style.display = text.includes(filter) ? '' : 'none';
    });
});

function printTable() {
    window.print();
}
</script>

<?php include '../includes/footer.php'; ?>    
</body>
</html>
