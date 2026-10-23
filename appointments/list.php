<?php
include "../hospital/includes/auth_check.php";
include '../config/db.php';

$base_path = "../";
$page_title = "Appointment Schedule - CarePulse Hospital";

$result = $conn->query("
    SELECT 
        appointments.appointment_id,
        patients.first_name,
        patients.last_name,
        doctors.name AS doctor_name,
        doctors.specialty AS doctor_specialty,
        appointments.appointment_date,
        appointments.status
    FROM appointments
    JOIN patients ON appointments.patient_id = patients.patient_id
    JOIN doctors ON appointments.doctor_id = doctors.doctor_id
    ORDER BY appointments.appointment_date DESC
");

include "../includes/header.php";
?>

<div class="page-header">
    <div>
        <h1 class="page-title"><i class="fa-solid fa-calendar-days" style="color: var(--warning);"></i> Appointment Schedule</h1>
        <p class="page-subtitle">Manage doctor appointments, consultation dates, and visit statuses</p>
    </div>
    <div>
        <a href="add.php" class="btn btn-primary">
            <i class="fa-solid fa-calendar-plus"></i> Book Appointment
        </a>
    </div>
</div>

<div class="table-container">
    <table class="custom-table">
        <thead>
            <tr>
                <th>Appt ID</th>
                <th>Patient Name</th>
                <th>Attending Doctor</th>
                <th>Date & Time</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if($result && $result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><strong>#APT-<?php echo str_pad($row['appointment_id'], 4, "0", STR_PAD_LEFT); ?></strong></td>
                        <td>
                            <div style="font-weight: 600; color: var(--text-main);">
                                <i class="fa-solid fa-user-injured" style="color: var(--primary);"></i>
                                <?php echo htmlspecialchars($row['first_name']." ".$row['last_name']); ?>
                            </div>
                        </td>
                        <td>
                            <div style="font-weight: 600;">
                                <i class="fa-solid fa-user-doctor" style="color: var(--secondary);"></i>
                                <?php echo htmlspecialchars($row['doctor_name']); ?>
                            </div>
                            <?php if(!empty($row['doctor_specialty'])): ?>
                                <small style="color: var(--text-muted);"><?php echo htmlspecialchars($row['doctor_specialty']); ?></small>
                            <?php endif; ?>
                        </td>
                        <td>
                            <i class="fa-regular fa-clock" style="color: var(--primary);"></i>
                            <?php echo date("M d, Y - h:i A", strtotime($row['appointment_date'])); ?>
                        </td>
                        <td>
                            <?php 
                            $status = strtolower($row['status']);
                            if($status == 'completed') {
                                echo '<span class="badge badge-success"><i class="fa-solid fa-circle-check"></i> Completed</span>';
                            } elseif($status == 'scheduled' || $status == 'pending') {
                                echo '<span class="badge badge-warning"><i class="fa-solid fa-clock"></i> '.htmlspecialchars($row['status']).'</span>';
                            } else {
                                echo '<span class="badge badge-danger"><i class="fa-solid fa-circle-xmark"></i> '.htmlspecialchars($row['status']).'</span>';
                            }
                            ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" style="text-align: center; padding: 2.5rem; color: var(--text-muted);">
                        <i class="fa-solid fa-calendar-xmark" style="font-size: 2.5rem; margin-bottom: 0.75rem; color: var(--text-light);"></i>
                        <p>No appointments booked yet.</p>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include "../includes/footer.php"; ?>