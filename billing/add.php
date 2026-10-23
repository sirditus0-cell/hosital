<?php
include "../hospital/includes/auth_check.php";
include '../config/db.php';

$base_path = "../";
$page_title = "Generate Bill - CarePulse Hospital";
$message = "";
$error = "";

if(isset($_POST['generate'])) {
    $stmt = $conn->prepare("INSERT INTO bills (patient_id, amount, status) VALUES (?, ?, ?)");

    $stmt->bind_param("ids",
        $_POST['patient_id'],
        $_POST['amount'],
        $_POST['status']
    );

    if($stmt->execute()){
        $message = "Bill successfully generated!";
    } else {
        $error = "Failed to generate invoice.";
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

include "../includes/header.php";
?>

<div class="page-header">
    <div>
        <h1 class="page-title"><i class="fa-solid fa-file-circle-plus" style="color: var(--info);"></i> Generate Bill</h1>
        <p class="page-subtitle">Create a medical treatment bill or consultation invoice for a patient</p>
    </div>
    <div>
        <a href="list.php" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> View All Invoices
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
                    <option value="">-- Select Billed Patient --</option>
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

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="amount"><i class="fa-solid fa-dollar-sign"></i> Total Bill Amount ($)</label>
                <input type="number" step="0.01" id="amount" name="amount" class="form-control" placeholder="150.00" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="status"><i class="fa-solid fa-credit-card"></i> Payment Status</label>
                <select id="status" name="status" class="form-control" required>
                    <option value="Unpaid" selected>Unpaid</option>
                    <option value="Paid">Paid</option>
                </select>
            </div>
        </div>

        <button type="submit" name="generate" class="btn btn-primary btn-block" style="margin-top: 1.5rem; padding: 0.85rem;">
            <i class="fa-solid fa-receipt"></i> Generate & Issue Bill
        </button>
    </form>
</div>

<?php include "../includes/footer.php"; ?>