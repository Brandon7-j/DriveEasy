<?php

session_start();

require_once 'config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$page_title = "Book a Car | DriveEase";

$error = "";

if (!isset($_GET['car_id']) || !filter_var($_GET['car_id'], FILTER_VALIDATE_INT)) {
    die("Invalid car selection.");
}

$car_id = (int) $_GET['car_id'];

$stmt = $conn->prepare(
    "SELECT * FROM cars WHERE car_id = ? AND status = 'available'"
);

$stmt->execute([$car_id]);
$car = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$car) {
    die("This car is currently unavailable.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    if (!$start_date || !$end_date) {
        $error = "Please select both rental dates.";
    } elseif ($start_date < date('Y-m-d')) {
        $error = "Start date cannot be in the past.";
    } elseif ($end_date <= $start_date) {
        $error = "End date must be after the start date.";
    } else {

        $start = new DateTime($start_date);
        $end = new DateTime($end_date);

        $days = $start->diff($end)->days;

        $total = $days * $car['price_per_day'];

        $check = $conn->prepare(
            "SELECT COUNT(*) FROM bookings
             WHERE car_id = ?
             AND status IN ('pending', 'confirmed')
             AND start_date < ?
             AND end_date > ?"
        );

        $check->execute([$car_id, $end_date, $start_date]);

        if ($check->fetchColumn() > 0) {

            $error = "Sorry, this car is already booked for those dates.";

        } else {

            $stmt = $conn->prepare(
                "INSERT INTO bookings
                (user_id, car_id, start_date, end_date, total_amount)
                VALUES (?, ?, ?, ?, ?)"
            );

            $stmt->execute([
                $_SESSION['user_id'],
                $car_id,
                $start_date,
                $end_date,
                $total
            ]);

            header("Location: my-bookings.php?success=1");
            exit;
        }
    }
}

include 'includes/header.php';
include 'includes/navbar.php';

?>

<section class="form-section">

    <div class="form-container">

        <h1>Book Your Car</h1>

        <h3>
            <?php echo htmlspecialchars($car['brand'] . ' ' . $car['model']); ?>
        </h3>

        <p>
            Rental Price: KSh
            <?php echo number_format((float)$car['price_per_day'], 2); ?> per day
        </p>

        <?php if ($error): ?>
            <p class="error-message">
                <?php echo htmlspecialchars($error); ?>
            </p>
        <?php endif; ?>

        <form method="POST">

            <label>Pick-up Date</label>
            <input type="date" name="start_date"
                   min="<?php echo date('Y-m-d'); ?>" required>

            <label>Return Date</label>
            <input type="date" name="end_date"
                   min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" required>

            <button type="submit">Confirm Booking</button>

        </form>

    </div>

</section>

<?php include 'includes/footer.php'; ?>