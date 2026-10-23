<?php
include "../hospital/includes/auth_check.php";
include '../config/db.php';

$base_path = "../";
$page_title = "Add Patient - CarePulse Hospital";
$message = "";
$error = "";

if(isset($_POST['add'])){
    $stmt = $conn->prepare('INSERT INTO patients (first_name,last_name,gender,date_of_birth,phone,address,blood_group) VALUES (?,?,?,?,?,?,?)');

    $stmt->bind_param("sssssss",
        $_POST['first_name'],
        $_POST['last_name'],
        $_POST['gender'],
        $_POST['date_of_birth'],
        $_POST['phone'],
        $_POST['address'],
        $_POST['blood_group']
    );

    if($stmt->execute()){
        $message = "Patient added successfully!";
    } else {
        $error = "Failed to add patient record.";
    }
}
include "../includes/header.php";
?>

<div class="page-header">
    <div>
        <h1 class="page-title"><i class="fa-solid fa-user-plus" style="color: var(--primary);"></i> Add New Patient</h1>
        <p class="page-subtitle">Register a new patient into the hospital management database</p>
    </div>
    <div>
        <a href="list.php" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Back to Patient Directory
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
        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="first_name"><i class="fa-solid fa-user"></i> First Name</label>
                <input type="text" id="first_name" name="first_name" class="form-control" placeholder="John" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="last_name"><i class="fa-solid fa-user"></i> Last Name</label>
                <input type="text" id="last_name" name="last_name" class="form-control" placeholder="Doe" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="gender"><i class="fa-solid fa-venus-mars"></i> Gender</label>
                <select id="gender" name="gender" class="form-control" required>
                    <option value="">Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label" for="date_of_birth"><i class="fa-regular fa-calendar"></i> Date of Birth</label>
                <input type="date" id="date_of_birth" name="date_of_birth" class="form-control" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="phone"><i class="fa-solid fa-phone"></i> Contact Phone</label>
                <input type="text" id="phone" name="phone" class="form-control" placeholder="+1 555-0192" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="blood_group"><i class="fa-solid fa-droplet"></i> Blood Group</label>
                <select id="blood_group" name="blood_group" class="form-control" required>
                    <option value="">Select Blood Type</option>
                    <option value="A+">A+</option>
                    <option value="A-">A-</option>
                    <option value="B+">B+</option>
                    <option value="B-">B-</option>
                    <option value="O+">O+</option>
                    <option value="O-">O-</option>
                    <option value="AB+">AB+</option>
                    <option value="AB-">AB-</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="address"><i class="fa-solid fa-location-dot"></i> Home Address</label>
            <input type="text" id="address" name="address" class="form-control" placeholder="123 Health Ave, Medical City" required>
        </div>

        <button type="submit" name="add" class="btn btn-primary btn-block" style="margin-top: 1.5rem; padding: 0.85rem;">
            <i class="fa-solid fa-user-check"></i> Register Patient
        </button>
    </form>
</div>

<?php include "../includes/footer.php"; ?>