<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$payments = $conn->query(
    "SELECT payments.*, bookings.user_id,
            users.full_name
     FROM payments
     JOIN bookings ON payments.booking_id = bookings.booking_id
     JOIN users ON bookings.user_id = users.user_id
     ORDER BY payments.payment_id DESC"
)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payments | DriveEase</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>

<div class="admin-content">

    <h1>Payment Management</h1>
    <a href="dashboard.php">← Back to Dashboard</a>

    <div class="table-container">
        <table class="booking-table">

            <tr>
                <th>Payment ID</th>
                <th>Customer</th>
                <th>Booking ID</th>
                <th>Amount</th>
                <th>Method</th>
                <th>Status</th>
                <th>Transaction Reference</th>
                <th>Date</th>
            </tr>

            <?php foreach ($payments as $payment): ?>
            <tr>
                <td><?= $payment['payment_id'] ?></td>
                <td><?= htmlspecialchars($payment['full_name']) ?></td>
                <td><?= $payment['booking_id'] ?></td>
                <td>KSh <?= number_format($payment['amount'], 2) ?></td>
                <td><?= htmlspecialchars($payment['payment_method']) ?></td>
                <td><?= htmlspecialchars($payment['payment_status']) ?></td>
                <td><?= htmlspecialchars($payment['transaction_reference'] ?? '') ?></td>
                <td><?= htmlspecialchars($payment['payment_date']) ?></td>
            </tr>
            <?php endforeach; ?>

        </table>
    </div>

</div>

</body>
</html>