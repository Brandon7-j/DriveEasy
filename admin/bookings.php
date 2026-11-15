<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $booking_id = (int) $_POST['booking_id'];
    $status = $_POST['status'];

    $allowed = ['pending', 'confirmed', 'completed', 'cancelled'];

    if (in_array($status, $allowed, true)) {

        $stmt = $conn->prepare(
            "UPDATE bookings SET status = ? WHERE booking_id = ?"
        );

        $stmt->execute([$status, $booking_id]);

        $message = "Booking status updated.";
    }
}

$bookings = $conn->query(
    "SELECT bookings.*, users.full_name,
            cars.brand, cars.model
     FROM bookings
     JOIN users ON bookings.user_id = users.user_id
     JOIN cars ON bookings.car_id = cars.car_id
     ORDER BY bookings.booking_id DESC"
)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bookings | DriveEase</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>

<div class="admin-content">

    <h1>Booking Management</h1>
    <a href="dashboard.php">← Back to Dashboard</a>

    <?php if ($message): ?>
        <p class="success-message"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <div class="table-container">
        <table class="booking-table">
            <tr>
                <th>ID</th>
                <th>Customer</th>
                <th>Car</th>
                <th>Start Date</th>
                <th>Return Date</th>
                <th>Total</th>
                <th>Status</th>
                <th>Action</th>
            </tr>

            <?php foreach ($bookings as $booking): ?>
            <tr>
                <td><?= $booking['booking_id'] ?></td>
                <td><?= htmlspecialchars($booking['full_name']) ?></td>
                <td><?= htmlspecialchars($booking['brand'] . ' ' . $booking['model']) ?></td>
                <td><?= htmlspecialchars($booking['start_date']) ?></td>
                <td><?= htmlspecialchars($booking['end_date']) ?></td>
                <td>KSh <?= number_format($booking['total_amount'], 2) ?></td>
                <td><?= htmlspecialchars($booking['status']) ?></td>

                <td>
                    <form method="POST">
                        <input type="hidden" name="booking_id"
                               value="<?= $booking['booking_id'] ?>">

                        <select name="status">
                            <?php foreach (['pending', 'confirmed', 'completed', 'cancelled'] as $status): ?>
                                <option value="<?= $status ?>"
                                    <?= $booking['status'] === $status ? 'selected' : '' ?>>
                                    <?= ucfirst($status) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <button type="submit">Update</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>

        </table>
    </div>

</div>

</body>
</html>