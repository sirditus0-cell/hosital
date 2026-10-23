<?php
include "../hospital/includes/auth_check.php";
include '../config/db.php';

$base_path = "../";
$page_title = "Billing & Invoices - CarePulse Hospital";

$total_amount = 0;
$paid_count = 0;
$unpaid_count = 0;

$stats_res = $conn->query("SELECT status, SUM(amount) as sum_amt, COUNT(*) as cnt FROM bills GROUP BY status");
if($stats_res) {
    while($st = $stats_res->fetch_assoc()) {
        $total_amount += $st['sum_amt'];
        if(strtolower($st['status']) == 'paid') {
            $paid_count += $st['cnt'];
        } else {
            $unpaid_count += $st['cnt'];
        }
    }
}

$result = $conn->query("
    SELECT bills.*, patients.first_name, patients.last_name
    FROM bills
    JOIN patients ON bills.patient_id = patients.patient_id
    ORDER BY bills.bill_id DESC
");

include "../includes/header.php";
?>

<div class="page-header">
    <div>
        <h1 class="page-title"><i class="fa-solid fa-file-invoice-dollar" style="color: var(--info);"></i> Billing & Invoices</h1>
        <p class="page-subtitle">Track patient billing records, issued invoices, and payment statuses</p>
    </div>
    <div>
        <a href="add.php" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> Generate New Bill
        </a>
    </div>
</div>

<!-- Financial Summary Widgets -->
<div class="stats-grid" style="margin-bottom: 2rem;">
    <div class="stat-card">
        <div class="stat-icon purple">
            <i class="fa-solid fa-sack-dollar"></i>
        </div>
        <div class="stat-info">
            <h4>Total Revenue Invoiced</h4>
            <div class="stat-value">$<?php echo number_format($total_amount, 2); ?></div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon teal">
            <i class="fa-solid fa-circle-check"></i>
        </div>
        <div class="stat-info">
            <h4>Paid Invoices</h4>
            <div class="stat-value"><?php echo $paid_count; ?></div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon amber">
            <i class="fa-solid fa-circle-exclamation"></i>
        </div>
        <div class="stat-info">
            <h4>Outstanding Unpaid Bills</h4>
            <div class="stat-value"><?php echo $unpaid_count; ?></div>
        </div>
    </div>
</div>

<div class="table-container">
    <table class="custom-table">
        <thead>
            <tr>
                <th>Invoice #</th>
                <th>Patient Name</th>
                <th>Amount ($)</th>
                <th>Issue Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if($result && $result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><strong>#INV-<?php echo str_pad($row['bill_id'], 4, "0", STR_PAD_LEFT); ?></strong></td>
                        <td>
                            <div style="font-weight: 600;">
                                <i class="fa-solid fa-user" style="color: var(--primary);"></i>
                                <?php echo htmlspecialchars($row['first_name']." ".$row['last_name']); ?>
                            </div>
                        </td>
                        <td>
                            <strong style="font-size: 1.05rem; color: var(--text-main);">
                                $<?php echo number_format($row['amount'], 2); ?>
                            </strong>
                        </td>
                        <td>
                            <i class="fa-regular fa-calendar-alt" style="color: var(--text-muted);"></i>
                            <?php echo isset($row['created_at']) ? date("M d, Y", strtotime($row['created_at'])) : "N/A"; ?>
                        </td>
                        <td>
                            <?php if(strtolower($row['status']) == 'paid'): ?>
                                <span class="badge badge-success"><i class="fa-solid fa-check-double"></i> Paid</span>
                            <?php else: ?>
                                <span class="badge badge-danger"><i class="fa-solid fa-hourglass-half"></i> Unpaid</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" style="text-align: center; padding: 2.5rem; color: var(--text-muted);">
                        <i class="fa-solid fa-receipt" style="font-size: 2.5rem; margin-bottom: 0.75rem; color: var(--text-light);"></i>
                        <p>No billing records generated yet.</p>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include "../includes/footer.php"; ?>