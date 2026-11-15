<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$customers = $conn->query(
    "SELECT user_id, full_name, email, phone, created_at
     FROM users
     WHERE role = 'customer'
     ORDER BY user_id DESC"
)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customers | DriveEase</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>

<div class="admin-content">

    <h1>Customer Management</h1>
    <a href="dashboard.php">← Back to Dashboard</a>

    <div class="table-container">
        <table class="booking-table">
            <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Date Registered</th>
            </tr>

            <?php foreach ($customers as $customer): ?>
            <tr>
                <td><?= $customer['user_id'] ?></td>
                <td><?= htmlspecialchars($customer['full_name']) ?></td>
                <td><?= htmlspecialchars($customer['email']) ?></td>
                <td><?= htmlspecialchars($customer['phone']) ?></td>
                <td><?= htmlspecialchars($customer['created_at']) ?></td>
            </tr>
            <?php endforeach; ?>

        </table>
    </div>

</div>

</body>
</html>