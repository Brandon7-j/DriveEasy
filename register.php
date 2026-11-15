<?php

require_once 'config/database.php';

session_start();

$page_title = "Register | DriveEase";

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = $_POST['password'];

    if ($full_name === '' || $email === '' || $phone === '' || $password === '') {
        $errors[] = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Enter a valid email address.";
    } elseif (strlen($password) < 8) {
        $errors[] = "Password must contain at least 8 characters.";
    } else {

        $stmt = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->fetch()) {

            $errors[] = "Email already registered.";

        } else {

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare(
                "INSERT INTO users (full_name, email, phone, password)
                 VALUES (?, ?, ?, ?)"
            );

            $stmt->execute([
                $full_name,
                $email,
                $phone,
                $hashed_password
            ]);

            header("Location: login.php?registered=success");
            exit;
        }
    }
}

include 'includes/header.php';
include 'includes/navbar.php';

?>

<section class="form-section">

    <div class="form-container">

        <h1>Create Your Account</h1>

        <p>Register with DriveEase Car Rentals.</p>

        <?php foreach ($errors as $error): ?>
            <p class="error-message">
                <?php echo htmlspecialchars($error); ?>
            </p>
        <?php endforeach; ?>

        <form method="POST">

            <label>Full Name</label>
            <input type="text" name="full_name" required>

            <label>Email Address</label>
            <input type="email" name="email" required>

            <label>Phone Number</label>
            <input type="tel" name="phone" required>

            <label>Password</label>
            <input type="password" name="password" minlength="8" required>

            <button type="submit">Register</button>

        </form>

        <p>Already registered? <a href="login.php">Login here</a></p>

    </div>

</section>

<?php include 'includes/footer.php'; ?>