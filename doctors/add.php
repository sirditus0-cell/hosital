<?php
include "../hospital/includes/auth_check.php";
include "../config/db.php";

$base_path = "../";
$page_title = "Add Doctor - CarePulse Hospital";
$message = "";
$error = "";

if(isset($_POST['add'])) {
    $stmt = $conn->prepare("INSERT INTO doctors (name, specialty, phone, email, department_id) VALUES (?,?,?,?,?)");

    $stmt->bind_param("ssssi",
        $_POST['name'],
        $_POST['specialty'],
        $_POST['phone'],
        $_POST['email'],
        $_POST['department_id']
    );

    if($stmt->execute()){
        $message = "Doctor successfully registered!";
    } else {
        $error = "Failed to add doctor. Please check your inputs.";
    }
}

// Fetch departments for dropdown
$departments = [];
$dept_res = $conn->query("SELECT * FROM departments");
if($dept_res) {
    while($d = $dept_res->fetch_assoc()) {
        $departments[] = $d;
    }
}

include "../includes/header.php";
?>

<div class="page-header">
    <div>
        <h1 class="page-title"><i class="fa-solid fa-user-plus" style="color: var(--primary);"></i> Add Doctor</h1>
        <p class="page-subtitle">Register a new medical specialist to the hospital system</p>
    </div>
    <div>
        <a href="list.php" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Back to Doctor Roster
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
            <label class="form-label" for="name"><i class="fa-solid fa-user-doctor"></i> Full Name</label>
            <input type="text" id="name" name="name" class="form-control" placeholder="Dr. John Doe" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="specialty"><i class="fa-solid fa-stethoscope"></i> Medical Specialty</label>
            <input type="text" id="specialty" name="specialty" class="form-control" placeholder="Cardiology, Pediatrics, etc." required>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="phone"><i class="fa-solid fa-phone"></i> Phone Number</label>
                <input type="text" id="phone" name="phone" class="form-control" placeholder="+1 555-0192" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="email"><i class="fa-solid fa-envelope"></i> Email Address</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="doctor@hospital.com" required>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="department_id"><i class="fa-solid fa-building-user"></i> Department</label>
            <?php if(!empty($departments)): ?>
                <select id="department_id" name="department_id" class="form-control" required>
                    <option value="">Select Department</option>
                    <?php foreach($departments as $dept): ?>
                        <option value="<?php echo $dept['department_id']; ?>"><?php echo htmlspecialchars($dept['department_name']); ?></option>
                    <?php endforeach; ?>
                </select>
            <?php else: ?>
                <input type="number" id="department_id" name="department_id" class="form-control" placeholder="Department ID (e.g. 1)" required>
            <?php endif; ?>
        </div>

        <button type="submit" name="add" class="btn btn-primary btn-block" style="margin-top: 1.5rem; padding: 0.85rem;">
            <i class="fa-solid fa-check"></i> Register Doctor
        </button>
    </form>
</div>

<?php include "../includes/footer.php"; ?>