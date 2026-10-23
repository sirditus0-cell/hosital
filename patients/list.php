<?php
include "../hospital/includes/auth_check.php";
include "../config/db.php";

$base_path = "../";
$page_title = "Patient Directory - CarePulse Hospital";

$result = $conn->query("SELECT * FROM patients ORDER BY patient_id DESC");

include "../includes/header.php";
?>

<div class="page-header">
    <div>
        <h1 class="page-title"><i class="fa-solid fa-hospital-user" style="color: var(--primary);"></i> Patient Directory</h1>
        <p class="page-subtitle">Manage registered patients, blood group details, and contact profiles</p>
    </div>
    <div>
        <a href="add.php" class="btn btn-primary">
            <i class="fa-solid fa-user-plus"></i> Add New Patient
        </a>
    </div>
</div>

<div class="table-container">
    <table class="custom-table">
        <thead>
            <tr>
                <th>Patient ID</th>
                <th>Full Name</th>
                <th>Gender</th>
                <th>Date of Birth</th>
                <th>Blood Group</th>
                <th>Contact Phone</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if($result && $result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><strong>#PT-<?php echo str_pad($row['patient_id'], 4, "0", STR_PAD_LEFT); ?></strong></td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 0.5rem; font-weight: 600;">
                                <div style="width: 32px; height: 32px; background: #e0f2fe; color: #0284c7; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.85rem;">
                                    <i class="fa-solid fa-user"></i>
                                </div>
                                <?php echo htmlspecialchars($row['first_name'] . " " . $row['last_name']); ?>
                            </div>
                        </td>
                        <td>
                            <?php if(strtolower($row['gender']) == 'male'): ?>
                                <span class="badge badge-info"><i class="fa-solid fa-mars"></i> Male</span>
                            <?php elseif(strtolower($row['gender']) == 'female'): ?>
                                <span class="badge badge-primary"><i class="fa-solid fa-venus"></i> Female</span>
                            <?php else: ?>
                                <span class="badge badge-secondary"><?php echo htmlspecialchars($row['gender']); ?></span>
                            <?php endif; ?>
                        </td>
                        <td><i class="fa-regular fa-calendar" style="color: var(--text-muted);"></i> <?php echo htmlspecialchars($row['date_of_birth']); ?></td>
                        <td>
                            <span class="badge badge-danger">
                                <i class="fa-solid fa-droplet"></i> <?php echo htmlspecialchars($row['blood_group']); ?>
                            </span>
                        </td>
                        <td><i class="fa-solid fa-phone" style="color: var(--primary);"></i> <?php echo htmlspecialchars($row['phone']); ?></td>
                        <td><i class="fa-solid fa-location-dot" style="color: var(--text-muted);"></i> <?php echo htmlspecialchars($row['address']); ?></td>
                        <td>
                            <div style="display: flex; gap: 0.4rem;">
                                <a href="edit.php?id=<?php echo $row['patient_id']; ?>" class="btn btn-secondary btn-sm" title="Edit Patient">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                                <a href="delete.php?id=<?php echo $row['patient_id']; ?>" class="btn btn-danger btn-sm" title="Delete Patient" onclick="return confirm('Delete this patient record?');">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" style="text-align: center; padding: 2.5rem; color: var(--text-muted);">
                        <i class="fa-solid fa-folder-open" style="font-size: 2.5rem; margin-bottom: 0.75rem; color: var(--text-light);"></i>
                        <p>No patient records found.</p>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include "../includes/footer.php"; ?>