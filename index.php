<?php

require_once 'config/database.php';

$page_title = "Home | DriveEase Car Rentals";

include 'includes/header.php';
include 'includes/navbar.php';

?>

<section class="hero">

    <div class="hero-content">

        <p class="hero-tag">WELCOME TO DRIVE EASE</p>

        <h1>Find Your Perfect Ride. <span>Drive With Ease.</span></h1>

        <p>
            Discover affordable, reliable and comfortable cars
            for your next journey.
        </p>

        <a href="cars.php" class="hero-btn">Explore Our Cars</a>

    </div>

</section>

<section class="services container">

    <h2>Why Choose DriveEase?</h2>

    <div class="service-grid">

        <div class="service-card">
            <h3>Affordable Prices</h3>
            <p>Enjoy competitive rental prices without compromising quality.</p>
        </div>

        <div class="service-card">
            <h3>Wide Car Selection</h3>
            <p>Choose from a variety of vehicles to suit your needs.</p>
        </div>

        <div class="service-card">
            <h3>Easy Booking</h3>
            <p>Book your preferred vehicle through our simple online system.</p>
        </div>

    </div>

</section>

<section class="cta">

    <h2>Ready for Your Next Journey?</h2>

    <p>Find a car that matches your destination and budget.</p>

    <a href="cars.php" class="hero-btn">Book a Car</a>

</section>

<?php include 'includes/footer.php'; ?>