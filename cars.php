<?php

require_once 'config/database.php';

$page_title = "Our Cars | DriveEase Car Rentals";

include 'includes/header.php';
include 'includes/navbar.php';

$sql = "SELECT cars.*, categories.category_name
        FROM cars
        LEFT JOIN categories
        ON cars.category_id = categories.category_id
        WHERE cars.status = 'available'
        ORDER BY cars.car_id DESC";

$stmt = $conn->prepare($sql);
$stmt->execute();

$cars = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<section class="cars-section container">

    <h1>Explore Our Cars</h1>

    <p class="section-description">
        Find the perfect vehicle for your next journey.
    </p>

    <div class="cars-grid">

        <?php if (count($cars) > 0): ?>

            <?php foreach ($cars as $car): ?>

               <div class="car-card">

    <img
        src="<?php echo htmlspecialchars($car['image'] ?: 'default-car.jpg'); ?>"
        alt="<?php echo htmlspecialchars($car['brand'] . ' ' . $car['model']); ?>"
        class="car-image"
    >

    <div class="car-info">

                        <h3>
                            <?php echo htmlspecialchars($car['brand'] . ' ' . $car['model']); ?>
                        </h3>

                        <p>
                            Category:
                            <?php echo htmlspecialchars($car['category_name'] ?? 'Uncategorized'); ?>
                        </p>

                        <p>
                            Year: <?php echo htmlspecialchars($car['year'] ?? 'Not specified'); ?>
                        </p>

                        <h4>
                            KSh <?php echo number_format((float)$car['price_per_day'], 2); ?> / day
                        </h4>

                        <a href="car-details.php?id=<?php echo (int)$car['car_id']; ?>"
                           class="car-btn">
                            View Details
                        </a>

                    </div>

                </div>

            <?php endforeach; ?>

        <?php else: ?>

            <p class="no-cars">
                No cars are currently available. Please check again later.
            </p>

        <?php endif; ?>

    </div>

</section>

<?php include 'includes/footer.php'; ?>