<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Luxe Spa</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

<header class="navbar">
    <div class="logo">
        <img src="<?= base_url('images/logospa.png') ?>" alt="Luxe Spa Logo">
        <span>Luxe Spa</span>
    </div>

    <nav>
        <a href="<?= base_url('/') ?>">Home</a>

        <div class="dropdown">
            <a href="<?= base_url('about') ?>">
                About Us
                <i class="fa-solid fa-angle-down"></i>
            </a>
            <div class="dropdown-menu">
                <a href="<?= base_url('about') ?>">About Luxe Spa</a>
                <a href="<?= base_url('facility') ?>">Facilities</a>
                <a href="<?= base_url('/#services') ?>">Our Services</a>
                <a href="<?= base_url('policy') ?>">Website Policy</a>
            </div>
        </div>

        <a href="<?= base_url('book') ?>" class="<?= uri_string() === 'book' ? 'active' : '' ?>">Book Session</a>
        <a href="<?= base_url('contact') ?>" class="<?= uri_string() === 'contact' ? 'active' : '' ?>">Contact Us</a>
        <?php if (session()->get('member_logged_in')): ?>
            <a href="<?= base_url('member/subscription') ?>">Subscription</a>
        <?php endif; ?>
    </nav>

    <div class="header-actions">
        <?php if (session()->get('member_logged_in')): ?>
            <a href="<?= base_url('member/profile') ?>" class="book-btn">Profile</a>
            <a href="<?= base_url('logout') ?>" class="book-btn">Logout</a>
        <?php else: ?>
            <a href="<?= base_url('login') ?>" class="book-btn">Login</a>
        <?php endif; ?>
    </div>
</header>

<?php if ($__flash_success = session()->getFlashdata('success')): ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({ icon: 'success', title: 'Success', text: <?= json_encode($__flash_success) ?>, confirmButtonColor: '#b01246', timer: 3000, timerProgressBar: true });
});
</script>
<?php endif; ?>
<?php if ($__flash_error = session()->getFlashdata('error')): ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({ icon: 'error', title: 'Error', text: <?= json_encode($__flash_error) ?>, confirmButtonColor: '#b01246' });
});
</script>
<?php endif; ?>
