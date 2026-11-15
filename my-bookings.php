<?php

session_start();

require_once 'config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$page_title = "My Bookings | DriveEase";

$stmt = $conn->prepare(
    "SELECT bookings.*, cars.brand, cars.model
     FROM bookings
     JOIN cars ON bookings.car_id = cars.car_id
     WHERE bookings.user_id = ?
     ORDER BY bookings.created_at DESC"
);

$stmt->execute([$_SESSION['user_id']]);

$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

include 'includes/header.php';
include 'includes/navbar.php';

?>

<section class="cars-section container">

    <h1>My Bookings</h1>

    <?php if (isset($_GET['success'])): ?>
        <p class="success-message">Your booking was submitted successfully!</p>
    <?php endif; ?>

    <div class="table-container">

        <table class="booking-table">

            <thead>
                <tr>
                    <th>Car</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>

                <?php foreach ($bookings as $booking): ?>

                    <tr>
                        <td>
                            <?php echo htmlspecialchars($booking['brand'] . ' ' . $booking['model']); ?>
                        </td>

                        <td><?php echo htmlspecialchars($booking['start_date']); ?></td>

                        <td><?php echo htmlspecialchars($booking['end_date']); ?></td>

                        <td>KSh <?php echo number_format((float)$booking['total_amount'], 2); ?></td>

                        <td><?php echo htmlspecialchars(ucfirst($booking['status'])); ?></td>
                    </tr>

                <?php endforeach; ?>

                <?php if (empty($bookings)): ?>
                    <tr>
                        <td colspan="5">You have no bookings yet.</td>
                    </tr>
                <?php endif; ?>

            </tbody>

        </table>

    </div>

</section>

<?php include 'includes/footer.php'; ?>