<?php

require_once 'config/database.php';

session_start();

$page_title = "Login | DriveEase";

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare(
        "SELECT * FROM users WHERE email = ? AND role = 'customer'"
    );

    $stmt->execute([$email]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {

        session_regenerate_id(true);

        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['user_name'] = $user['full_name'];
        $_SESSION['role'] = $user['role'];

        header("Location: cars.php");
        exit;

    } else {

        $error = "Invalid email or password.";

    }
}

include 'includes/header.php';
include 'includes/navbar.php';

?>

<section class="form-section">

    <div class="form-container">

        <h1>Customer Login</h1>

        <?php if (isset($_GET['registered'])): ?>
            <p class="success-message">Registration successful. Please login.</p>
        <?php endif; ?>

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

        <p>Don't have an account? <a href="register.php">Register here</a></p>

    </div>

</section>

<?php include 'includes/footer.php'; ?>