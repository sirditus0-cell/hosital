<?php
include "includes/auth_check.php";
include "../config/db.php";

$base_path = "../";
$page_title = "Hospital Dashboard - CarePulse";

// Fetch counts for dashboard stats
$patient_count = 0;
$doctor_count = 0;
$appointment_count = 0;
$bill_count = 0;

if($conn) {
    $res = $conn->query("SELECT COUNT(*) AS total FROM patients");
    if($res) { $patient_count = $res->fetch_assoc()['total']; }

    $res = $conn->query("SELECT COUNT(*) AS total FROM doctors");
    if($res) { $doctor_count = $res->fetch_assoc()['total']; }

    $res = $conn->query("SELECT COUNT(*) AS total FROM appointments");
    if($res) { $appointment_count = $res->fetch_assoc()['total']; }

    $res = $conn->query("SELECT COUNT(*) AS total FROM bills");
    if($res) { $bill_count = $res->fetch_assoc()['total']; }
}

include "../includes/header.php";
?>

<!-- Hero Banner with Video Background -->
<div class="hero-banner">
    <video class="hero-bg-video" autoplay muted loop playsinline preload="auto">
        <source src="../hospital-background.mp4" type="video/mp4">
    </video>
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <div class="badge badge-primary" style="margin-bottom: 0.75rem; background: rgba(56, 189, 248, 0.2); color: #7dd3fc; border: 1px solid rgba(56, 189, 248, 0.4);">
            <i class="fa-solid fa-hospital-user"></i> Medical Command Center
        </div>
        <h1 class="hero-title">Welcome back, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
        <p class="hero-desc">
            Streamline patient care, manage doctor schedules, view appointments, and process medical billing with CarePulse Hospital System.
        </p>
        <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
            <a href="../patients/add.php" class="btn btn-primary">
                <i class="fa-solid fa-user-plus"></i> Add New Patient
            </a>
            <a href="../appointments/add.php" class="btn btn-success">
                <i class="fa-solid fa-calendar-plus"></i> Book Appointment
            </a>
        </div>
    </div>
</div>

<!-- Quick Stat Counters -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon blue">
            <i class="fa-solid fa-users"></i>
        </div>
        <div class="stat-info">
            <h4>Total Patients</h4>
            <div class="stat-value"><?php echo $patient_count; ?></div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon teal">
            <i class="fa-solid fa-user-doctor"></i>
        </div>
        <div class="stat-info">
            <h4>Medical Staff</h4>
            <div class="stat-value"><?php echo $doctor_count; ?></div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon amber">
            <i class="fa-solid fa-calendar-check"></i>
        </div>
        <div class="stat-info">
            <h4>Appointments</h4>
            <div class="stat-value"><?php echo $appointment_count; ?></div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon purple">
            <i class="fa-solid fa-file-invoice-dollar"></i>
        </div>
        <div class="stat-info">
            <h4>Bills Issued</h4>
            <div class="stat-value"><?php echo $bill_count; ?></div>
        </div>
    </div>
</div>

<!-- Module Cards with Pictures -->
<div class="dashboard-grid">
    <!-- Patient Management Card -->
    <div class="module-card">
        <img src="../assets/images/medical_banner.png" alt="Patient Management" class="module-img">
        <div class="module-body">
            <h3 class="module-title">
                <i class="fa-solid fa-hospital-user" style="color: var(--primary);"></i> Patient Directory
            </h3>
            <p class="module-desc">
                Register new patients, update medical histories, blood groups, and manage patient profiles.
            </p>
            <div class="module-actions">
                <a href="../patients/add.php" class="btn btn-primary btn-sm btn-block">
                    <i class="fa-solid fa-plus"></i> Add Patient
                </a>
                <a href="../patients/list.php" class="btn btn-secondary btn-sm btn-block">
                    <i class="fa-solid fa-list"></i> View All
                </a>
            </div>
        </div>
    </div>

    <!-- Doctor Management Card -->
    <div class="module-card">
        <img src="../assets/images/doctor_female.png" alt="Doctor Management" class="module-img">
        <div class="module-body">
            <h3 class="module-title">
                <i class="fa-solid fa-user-doctor" style="color: var(--secondary);"></i> Doctor Roster
            </h3>
            <p class="module-desc">
                Manage medical specialists, departments, contact information, and physician availability.
            </p>
            <div class="module-actions">
                <a href="../doctors/add.php" class="btn btn-primary btn-sm btn-block">
                    <i class="fa-solid fa-plus"></i> Add Doctor
                </a>
                <a href="../doctors/list.php" class="btn btn-secondary btn-sm btn-block">
                    <i class="fa-solid fa-list"></i> View Roster
                </a>
            </div>
        </div>
    </div>

    <!-- Appointment Management Card -->
    <div class="module-card">
        <img src="../assets/images/doctor_male.png" alt="Appointment Management" class="module-img">
        <div class="module-body">
            <h3 class="module-title">
                <i class="fa-solid fa-calendar-days" style="color: var(--warning);"></i> Appointments
            </h3>
            <p class="module-desc">
                Schedule patient consultations, assign doctors, and monitor consultation statuses.
            </p>
            <div class="module-actions">
                <a href="../appointments/add.php" class="btn btn-primary btn-sm btn-block">
                    <i class="fa-solid fa-plus"></i> Book New
                </a>
                <a href="../appointments/list.php" class="btn btn-secondary btn-sm btn-block">
                    <i class="fa-solid fa-list"></i> Schedule
                </a>
            </div>
        </div>
    </div>

    <!-- Billing Card -->
    <div class="module-card">
        <img src="../assets/images/hospital_hero.png" alt="Billing Management" class="module-img">
        <div class="module-body">
            <h3 class="module-title">
                <i class="fa-solid fa-receipt" style="color: var(--info);"></i> Billing & Invoices
            </h3>
            <p class="module-desc">
                Generate financial invoices, record patient payments, and track outstanding bills.
            </p>
            <div class="module-actions">
                <a href="../billing/add.php" class="btn btn-primary btn-sm btn-block">
                    <i class="fa-solid fa-plus"></i> New Bill
                </a>
                <a href="../billing/list.php" class="btn btn-secondary btn-sm btn-block">
                    <i class="fa-solid fa-list"></i> Invoices
                </a>
            </div>
        </div>
    </div>
</div>

<?php include "../includes/footer.php"; ?>