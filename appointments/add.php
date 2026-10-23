<?php
include "../hospital/includes/auth_check.php";
include '../config/db.php';

$base_path = "../";
$page_title = "Book Appointment - CarePulse Hospital";
$message = "";
$error = "";

if(isset($_POST['book'])) {
    $stmt = $conn->prepare("INSERT INTO appointments (patient_id, doctor_id, appointment_date, status) VALUES (?, ?, ?, ?)");

    $stmt->bind_param("iiss",
        $_POST['patient_id'],
        $_POST['doctor_id'],
        $_POST['appointment_date'],
        $_POST['status']
    );

    if($stmt->execute()){
        $message = "Appointment successfully booked!";
    } else {
        $error = "Failed to book appointment. Please verify details.";
    }
}

// Fetch patients for selection
$patients = [];
$p_res = $conn->query("SELECT patient_id, first_name, last_name FROM patients ORDER BY first_name ASC");
if($p_res) {
    while($p = $p_res->fetch_assoc()) {
        $patients[] = $p;
    }
}

// Fetch doctors for selection
$doctors = [];
$d_res = $conn->query("SELECT doctor_id, name, specialty FROM doctors ORDER BY name ASC");
if($d_res) {
    while($d = $d_res->fetch_assoc()) {
        $doctors[] = $d;
    }
}

include "../includes/header.php";
?>

<div class="page-header">
    <div>
        <h1 class="page-title"><i class="fa-solid fa-calendar-plus" style="color: var(--warning);"></i> Book Appointment</h1>
        <p class="page-subtitle">Schedule a consultation between a patient and a medical doctor</p>
    </div>
    <div>
        <a href="list.php" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> View Appointment Schedule
        </a>
    </div>
</div>

<div class="form-card">
    <?php if($message): ?>
        <div class="alert alert-success">
            <i class="fa-solid fa-circle-check"></i> <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <?php if($error): ?>
        <div class="alert alert-danger">
            <i class="fa-solid fa-circle-exclamation"></i> <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label class="form-label" for="patient_id"><i class="fa-solid fa-user-injured"></i> Select Patient</label>
            <?php if(!empty($patients)): ?>
                <select id="patient_id" name="patient_id" class="form-control" required>
                    <option value="">-- Choose Patient --</option>
                    <?php foreach($patients as $pt): ?>
                        <option value="<?php echo $pt['patient_id']; ?>">
                            <?php echo htmlspecialchars($pt['first_name'] . " " . $pt['last_name']); ?> (#PT-<?php echo $pt['patient_id']; ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            <?php else: ?>
                <input type="number" id="patient_id" name="patient_id" class="form-control" placeholder="Patient ID" required>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label class="form-label" for="doctor_id"><i class="fa-solid fa-user-doctor"></i> Select Doctor</label>
            <?php if(!empty($doctors)): ?>
                <select id="doctor_id" name="doctor_id" class="form-control" required>
                    <option value="">-- Choose Doctor --</option>
                    <?php foreach($doctors as $doc): ?>
                        <option value="<?php echo $doc['doctor_id']; ?>">
                            <?php echo htmlspecialchars($doc['name']); ?> (<?php echo htmlspecialchars($doc['specialty']); ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            <?php else: ?>
                <input type="number" id="doctor_id" name="doctor_id" class="form-control" placeholder="Doctor ID" required>
            <?php endif; ?>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="appointment_date"><i class="fa-regular fa-clock"></i> Date & Time</label>
                <input type="datetime-local" id="appointment_date" name="appointment_date" class="form-control" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="status"><i class="fa-solid fa-flag"></i> Appointment Status</label>
                <select id="status" name="status" class="form-control" required>
                    <option value="Scheduled" selected>Scheduled</option>
                    <option value="Completed">Completed</option>
                    <option value="Cancelled">Cancelled</option>
                </select>
            </div>
        </div>

        <button type="submit" name="book" class="btn btn-primary btn-block" style="margin-top: 1.5rem; padding: 0.85rem;">
            <i class="fa-solid fa-calendar-check"></i> Confirm Appointment
        </button>
    </form>
</div>

<?php include "../includes/footer.php"; ?>