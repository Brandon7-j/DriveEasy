<?php
session_start();
require_once '../config/database.php';

// Protect the dashboard
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Get system statistics
$total_cars = $conn->query("SELECT COUNT(*) FROM cars")->fetchColumn();

$total_customers = $conn->query(
    "SELECT COUNT(*) FROM users WHERE role = 'customer'"
)->fetchColumn();

$total_bookings = $conn->query(
    "SELECT COUNT(*) FROM bookings"
)->fetchColumn();

$total_payments = $conn->query(
    "SELECT COUNT(*) FROM payments"
)->fetchColumn();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | DriveEase</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>

<div class="dashboard">

    <aside class="sidebar">
        <h2>Drive<span>Ease</span></h2>
        <p>ADMIN PANEL</p>

        <a href="dashboard.php">Dashboard</a>
        <a href="cars.php">Manage Cars</a>
        <a href="customers.php">Customers</a>
        <a href="bookings.php">Bookings</a>
        <a href="payments.php">Payments</a>
        <a href="logout.php">Logout</a>
    </aside>

    <main class="main-content">

        <h1>Admin Dashboard</h1>

        <p>
            Welcome,
            <?php echo htmlspecialchars($_SESSION['admin_name']); ?>!
        </p>

        <div class="dashboard-cards">

            <div class="dashboard-card">
                <h3>Total Cars</h3>
                <p><?php echo $total_cars; ?></p>
            </div>

            <div class="dashboard-card">
                <h3>Customers</h3>
                <p><?php echo $total_customers; ?></p>
            </div>

            <div class="dashboard-card">
                <h3>Total Bookings</h3>
                <p><?php echo $total_bookings; ?></p>
            </div>

            <div class="dashboard-card">
                <h3>Total Payments</h3>
                <p><?php echo $total_payments; ?></p>
            </div>

        </div>

    </main>

</div>

</body>
</html>