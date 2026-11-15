<?php
session_start();
require_once '../config/database.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare(
        "SELECT * FROM users WHERE email = ? AND role = 'admin'"
    );

    $stmt->execute([$email]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin && password_verify($password, $admin['password'])) {

        session_regenerate_id(true);

        $_SESSION['admin_id'] = $admin['user_id'];
        $_SESSION['admin_name'] = $admin['full_name'];

        header("Location: dashboard.php");
        exit;

    } else {
        $error = "Invalid administrator email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | DriveEase</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>

<div class="admin-login">
    <h1>DriveEase Admin</h1>
    <p>Administrator Login</p>

    <?php if ($error): ?>
        <p class="error-message">
            <?php echo htmlspecialchars($error); ?>
        </p>
    <?php endif; ?>

    <form method="POST">
        <label>Email Address</label>
        <input type="email" name="email" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit">Login</button>
    </form>
</div>

</body>
</html>