<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$base_path = isset($base_path) ? $base_path : "../";
$page_title = isset($page_title) ? $page_title : "Hospital Management System";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom Hospital CSS -->
    <link rel="stylesheet" href="<?php echo $base_path; ?>assets/css/style.css">
</head>
<body>

<nav class="navbar">
    <div class="nav-container">
        <a href="<?php echo $base_path; ?>hospital/dashboard.php" class="nav-brand">
            <div class="brand-icon">
                <i class="fa-solid fa-hospital"></i>
            </div>
            <span>CarePulse Hospital</span>
        </a>

        <?php if(isset($_SESSION['username'])): ?>
        <ul class="nav-menu">
            <li>
                <a href="<?php echo $base_path; ?>hospital/dashboard.php" class="nav-link">
                    <i class="fa-solid fa-chart-line"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="<?php echo $base_path; ?>patients/list.php" class="nav-link">
                    <i class="fa-solid fa-user-injured"></i> Patients
                </a>
            </li>
            <li>
                <a href="<?php echo $base_path; ?>doctors/list.php" class="nav-link">
                    <i class="fa-solid fa-user-doctor"></i> Doctors
                </a>
            </li>
            <li>
                <a href="<?php echo $base_path; ?>appointments/list.php" class="nav-link">
                    <i class="fa-solid fa-calendar-check"></i> Appointments
                </a>
            </li>
            <li>
                <a href="<?php echo $base_path; ?>billing/list.php" class="nav-link">
                    <i class="fa-solid fa-file-invoice-dollar"></i> Billing
                </a>
            </li>
        </ul>

        <div class="nav-user">
            <div class="user-badge">
                <div class="user-avatar">
                    <?php echo strtoupper(substr($_SESSION['username'], 0, 1)); ?>
                </div>
                <span><?php echo htmlspecialchars($_SESSION['username']); ?></span>
            </div>
            <a href="<?php echo $base_path; ?>auth/logout.php" class="btn-logout">
                <i class="fa-solid fa-right-from-bracket"></i> Logout
            </a>
        </div>
        <?php endif; ?>
    </div>
</nav>

<div class="main-wrapper">
