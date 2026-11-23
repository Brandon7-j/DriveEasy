<?php

require_once 'config/database.php';

$page_title = "Car Details | DriveEase";

include 'includes/header.php';
include 'includes/navbar.php';

if (!isset($_GET['id']) || !filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    die("Invalid car selection.");
}

$id = (int) $_GET['id'];

$stmt = $conn->prepare(
    "SELECT * FROM cars WHERE car_id = ?"
);

$stmt->execute([$id]);

$car = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$car) {
    die("Car not found.");
}

?>

<section class="car-details container">

    <div class="details-card">

        <img
        <img
    src="<?php echo htmlspecialchars($car['image'] ?? 'default-car.jpg'); ?>"
            alt="Car image"
        >

        <div class="details-info">

            <h1>
                <?php echo htmlspecialchars($car['brand'] . ' ' . $car['model']); ?>
            </h1>

            <p>Year: <?php echo htmlspecialchars($car['year']); ?></p>

            <p>Registration: <?php echo htmlspecialchars($car['registration_number']); ?></p>

            <p>
                Price:
                KSh <?php echo number_format((float)$car['price_per_day'], 2); ?> per day
            </p>

            <p><?php echo htmlspecialchars($car['description'] ?? ''); ?></p>

            <a href="booking.php?car_id=<?php echo (int)$car['car_id']; ?>"
               class="car-btn">
                Book This Car
            </a>

        </div>

    </div>

</section>

<?php include 'includes/footer.php'; ?>