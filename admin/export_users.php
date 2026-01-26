<?php
include '../config/db_connect.php';

// Headers for Excel file
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=users_data.xls");
header("Pragma: no-cache");
header("Expires: 0");

// Fetch users data
$query = "SELECT user_id, first_name, last_name, email, phone, user_type, status, created_at FROM users";
$result = mysqli_query($conn, $query);

// Output data in tabular format
echo "<table border='1'>";
echo "<tr><th>ID</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Phone</th><th>User Type</th><th>Status</th><th>Created At</th></tr>";

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>
        <td>{$row['user_id']}</td>
        <td>{$row['first_name']}</td>
        <td>{$row['last_name']}</td>
        <td>{$row['email']}</td>
        <td>{$row['phone']}</td>
        <td>{$row['user_type']}</td>
        <td>{$row['status']}</td>
        <td>{$row['created_at']}</td>
    </tr>";
}
echo "</table>";
?>
