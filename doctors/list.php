<?php
include "../hospital/includes/auth_check.php";
include "../config/db.php";

$base_path = "../";
$page_title = "Doctor Roster - CarePulse Hospital";

$result = $conn->query("
    SELECT doctors.*, departments.department_name 
    FROM doctors 
    LEFT JOIN departments ON doctors.department_id = departments.department_id
");

include "../includes/header.php";
?>

<div class="page-header">
    <div>
        <h1 class="page-title"><i class="fa-solid fa-user-doctor" style="color: var(--secondary);"></i> Medical Specialists</h1>
        <p class="page-subtitle">View and manage hospital doctors, specialties, and contact details</p>
    </div>
    <div>
        <a href="add.php" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> Add New Doctor
        </a>
    </div>
</div>

<div class="doctors-grid">
    <?php 
    $index = 0;
    if($result && $result->num_rows > 0): 
        while($row = $result->fetch_assoc()):
            $avatar = ($index % 2 == 0) ? "../assets/images/doctor_male.png" : "../assets/images/doctor_female.png";
            $dept = !empty($row['department_name']) ? $row['department_name'] : "General Department";
            $index++;
    ?>
        <div class="doctor-card">
            <div class="doctor-avatar-wrapper">
                <img src="<?php echo $avatar; ?>" alt="<?php echo htmlspecialchars($row['name']); ?>" class="doctor-avatar-img">
                <div class="doctor-dept-tag">
                    <i class="fa-solid fa-hospital-user"></i> <?php echo htmlspecialchars($dept); ?>
                </div>
            </div>
            <div class="doctor-card-body">
                <h3 class="doctor-name"><?php echo htmlspecialchars($row['name']); ?></h3>
                <div class="doctor-specialty">
                    <i class="fa-solid fa-stethoscope"></i> <?php echo htmlspecialchars($row['specialty']); ?>
                </div>
                <div class="doctor-contact-info">
                    <div><i class="fa-solid fa-phone" style="width: 18px; color: var(--primary);"></i> <?php echo htmlspecialchars($row['phone']); ?></div>
                    <div><i class="fa-solid fa-envelope" style="width: 18px; color: var(--primary);"></i> <?php echo htmlspecialchars($row['email']); ?></div>
                </div>
                <div class="doctor-card-footer">
                    <a href="edit.php?id=<?php echo $row['doctor_id']; ?>" class="btn btn-secondary btn-sm btn-block">
                        <i class="fa-solid fa-pen"></i> Edit
                    </a>
                    <a href="delete.php?id=<?php echo $row['doctor_id']; ?>" class="btn btn-danger btn-sm btn-block" onclick="return confirm('Are you sure you want to delete this doctor?');">
                        <i class="fa-solid fa-trash"></i> Delete
                    </a>
                </div>
            </div>
        </div>
    <?php 
        endwhile; 
    else: 
    ?>
        <div class="form-card" style="grid-column: 1 / -1; text-align: center; padding: 3rem;">
            <i class="fa-solid fa-user-doctor-slash" style="font-size: 3rem; color: var(--text-light); margin-bottom: 1rem;"></i>
            <h3>No Doctors Found</h3>
            <p style="color: var(--text-muted); margin-bottom: 1.5rem;">There are currently no doctor records in the database.</p>
            <a href="add.php" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Add First Doctor</a>
        </div>
    <?php endif; ?>
</div>

<?php include "../includes/footer.php"; ?>