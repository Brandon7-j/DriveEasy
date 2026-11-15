<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$error = "";
$success = "";

// Delete a car
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'delete') {

    $car_id = (int) $_POST['car_id'];

    try {
        $stmt = $conn->prepare("DELETE FROM cars WHERE car_id = ?");
        $stmt->execute([$car_id]);

        $success = "Car deleted successfully.";

    } catch (PDOException $e) {
        $error = "This car cannot be deleted because it has related bookings.";
    }
}

// Update a car
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'update') {

    $car_id = (int) $_POST['car_id'];

    $stmt = $conn->prepare(
        "UPDATE cars SET
        category_id = ?,
        brand = ?,
        model = ?,
        car_name = ?,
        year = ?,
        registration_number = ?,
        price_per_day = ?,
        description = ?
        WHERE car_id = ?"
    );

    try {
        $brand = trim($_POST['brand']);
        $model = trim($_POST['model']);
        $price = $_POST['price_per_day'];

        $stmt->execute([
            $_POST['category_id'],
            $brand,
            $model,
            $brand . ' ' . $model,
            $_POST['year'],
            trim($_POST['registration_number']),
            $price,
            trim($_POST['description']),
            $car_id
        ]);

        $success = "Car updated successfully.";

    } catch (PDOException $e) {
        $error = "Unable to update car. Check the registration number.";
    }
}

// Get categories
$categories = $conn->query(
    "SELECT * FROM categories ORDER BY category_name"
)->fetchAll(PDO::FETCH_ASSOC);

// Get car being edited
$edit_car = null;

if (isset($_GET['edit'])) {
    $stmt = $conn->prepare("SELECT * FROM cars WHERE car_id = ?");
    $stmt->execute([(int) $_GET['edit']]);
    $edit_car = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Add a new car
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'add') {

    try {
        $brand = trim($_POST['brand']);
        $model = trim($_POST['model']);

        $stmt = $conn->prepare(
            "INSERT INTO cars
            (category_id, car_name, brand, model,
            registration_number, year, price_per_day,
            description, status)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'available')"
        );

        $stmt->execute([
            $_POST['category_id'],
            $brand . ' ' . $model,
            $brand,
            $model,
            trim($_POST['registration_number']),
            $_POST['year'],
            $_POST['price_per_day'],
            trim($_POST['description'])
        ]);

        $success = "Car added successfully.";

    } catch (PDOException $e) {
        $error = "Unable to add car. Check the registration number.";
    }
}

// Get all cars
$cars = $conn->query(
    "SELECT cars.*, categories.category_name
     FROM cars
     LEFT JOIN categories
     ON cars.category_id = categories.category_id
     ORDER BY cars.car_id DESC"
)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Cars | DriveEase</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>

<div class="admin-content">

    <h1>Manage Cars</h1>

    <p><a href="dashboard.php">← Back to Dashboard</a></p>

    <?php if ($error): ?>
        <p class="error-message"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <?php if ($success): ?>
        <p class="success-message"><?php echo htmlspecialchars($success); ?></p>
    <?php endif; ?>

    <h2><?php echo $edit_car ? "Edit Car" : "Add New Car"; ?></h2>

    <form method="POST" class="car-form">

        <input type="hidden" name="action"
               value="<?php echo $edit_car ? 'update' : 'add'; ?>">

        <?php if ($edit_car): ?>
            <input type="hidden" name="car_id"
                   value="<?php echo $edit_car['car_id']; ?>">
        <?php endif; ?>

        <label>Category</label>
        <select name="category_id" required>
            <?php foreach ($categories as $category): ?>
                <option value="<?php echo $category['category_id']; ?>"
                    <?php if ($edit_car && $edit_car['category_id'] == $category['category_id']) echo 'selected'; ?>>
                    <?php echo htmlspecialchars($category['category_name']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Brand</label>
        <input type="text" name="brand"
               value="<?php echo htmlspecialchars($edit_car['brand'] ?? ''); ?>" required>

        <label>Model</label>
        <input type="text" name="model"
               value="<?php echo htmlspecialchars($edit_car['model'] ?? ''); ?>" required>

        <label>Year</label>
        <input type="number" name="year"
               value="<?php echo htmlspecialchars($edit_car['year'] ?? ''); ?>" required>

        <label>Registration Number</label>
        <input type="text" name="registration_number"
               value="<?php echo htmlspecialchars($edit_car['registration_number'] ?? ''); ?>" required>

        <label>Price Per Day</label>
        <input type="number" name="price_per_day" min="1" step="0.01"
               value="<?php echo htmlspecialchars($edit_car['price_per_day'] ?? ''); ?>" required>

        <label>Description</label>
        <textarea name="description"><?php echo htmlspecialchars($edit_car['description'] ?? ''); ?></textarea>

        <button type="submit">
            <?php echo $edit_car ? "Update Car" : "Add Car"; ?>
        </button>

        <?php if ($edit_car): ?>
            <a href="cars.php">Cancel</a>
        <?php endif; ?>

    </form>

    <h2>Car Records</h2>

    <div class="table-container">

        <table class="booking-table">

            <tr>
                <th>ID</th>
                <th>Brand</th>
                <th>Model</th>
                <th>Category</th>
                <th>Price</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>

            <?php foreach ($cars as $car): ?>
                <tr>
                    <td><?php echo $car['car_id']; ?></td>
                    <td><?php echo htmlspecialchars($car['brand']); ?></td>
                    <td><?php echo htmlspecialchars($car['model']); ?></td>
                    <td><?php echo htmlspecialchars($car['category_name'] ?? 'Uncategorized'); ?></td>
                    <td>KSh <?php echo number_format($car['price_per_day'], 2); ?></td>
                    <td><?php echo htmlspecialchars($car['status']); ?></td>

                    <td>
                        <a href="cars.php?edit=<?php echo $car['car_id']; ?>">Edit</a>

                        <form method="POST" style="display:inline;"
                              onsubmit="return confirm('Delete this car?');">

                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="car_id"
                                   value="<?php echo $car['car_id']; ?>">

                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>

        </table>

    </div>

</div>

</body>
</html>