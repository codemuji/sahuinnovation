<?php
require_once __DIR__ . '/../../app/core/Auth.php';
Auth::requireRole('director');

$db = Database::getInstance()->getConnection();
$userId = Auth::userId();

// Get active director details
$user = Auth::user();

// Determine Year filter
$selectedYear = $_GET['year'] ?? date('Y');

// CSV Export Logic
if (isset($_GET['export']) && $_GET['export'] === 'csv') {
    // Set headers
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=Budget-Report-' . $selectedYear . '-' . str_replace(' ', '_', $user['name']) . '.csv');
    
    $output = fopen('php://output', 'w');
    
    // Header information
    fputcsv($output, ["SAHU INNOVATION PVT. LTD."]);
    fputcsv($output, ["ANNUAL BUDGET REPORT - " . $selectedYear]);
    fputcsv($output, ["Director Name:", $user['name']]);
    fputcsv($output, ["Employee ID:", $user['employee_id']]);
    fputcsv($output, []);
    
    // Allocations Section
    fputcsv($output, ["--- FUND ALLOCATIONS ---"]);
    fputcsv($output, ["Date", "Source", "Amount (INR)", "Notes"]);
    
    $stmt = $db->prepare("SELECT a.*, u.name as admin_name FROM fund_allocations a JOIN users u ON a.admin_id = u.id 
        WHERE a.director_id = ? AND YEAR(a.created_at) = ? ORDER BY a.created_at ASC");
    $stmt->execute([$userId, $selectedYear]);
    $allocs = $stmt->fetchAll();
    
    $totalAllocated = 0.00;
    foreach ($allocs as $a) {
        fputcsv($output, [
            date('Y-m-d H:i', strtotime($a['created_at'])),
            $a['admin_name'],
            $a['amount'],
            $a['notes']
        ]);
        $totalAllocated += $a['amount'];
    }
    fputcsv($output, ["", "Total Allocated:", $totalAllocated]);
    fputcsv($output, []);
    
    // Usages Section
    fputcsv($output, ["--- APPROVED EXPENSES ---"]);
    fputcsv($output, ["Date Approved", "Purpose Category", "Description", "Amount (INR)"]);
    
    $stmt = $db->prepare("SELECT * FROM fund_usages WHERE director_id = ? AND status = 'approved' 
        AND YEAR(resolved_at) = ? ORDER BY resolved_at ASC");
    $stmt->execute([$userId, $selectedYear]);
    $usages = $stmt->fetchAll();
    
    $totalExpensed = 0.00;
    foreach ($usages as $u) {
        fputcsv($output, [
            date('Y-m-d H:i', strtotime($u['resolved_at'])),
            $u['purpose'],
            $u['description'],
            $u['amount']
        ]);
        $totalExpensed += $u['amount'];
    }
    fputcsv($output, ["", "", "Total Expensed:", $totalExpensed]);
    fputcsv($output, []);
    
    // Summary
    fputcsv($output, ["--- SUMMARY ---"]);
    fputcsv($output, ["Net Allocated Funds", $totalAllocated]);
    fputcsv($output, ["Total Approved Expenses", $totalExpensed]);
    fputcsv($output, ["Remaining Wallet Balance", ($totalAllocated - $totalExpensed)]);
    
    fclose($output);
    exit();
}

// GUI View Logic
// 1. Fetch Allocations
$stmt = $db->prepare("SELECT a.*, u.name as admin_name FROM fund_allocations a JOIN users u ON a.admin_id = u.id 
    WHERE a.director_id = ? AND YEAR(a.created_at) = ? ORDER BY a.created_at DESC");
$stmt->execute([$userId, $selectedYear]);
$allocations = $stmt->fetchAll();

// 2. Fetch Approved Expenses
$stmt = $db->prepare("SELECT * FROM fund_usages WHERE director_id = ? AND status = 'approved' 
    AND YEAR(resolved_at) = ? ORDER BY resolved_at DESC");
$stmt->execute([$userId, $selectedYear]);
$approvedUsages = $stmt->fetchAll();

// Summary calculations
$sumAllocated = array_sum(array_column($allocations, 'amount'));
$sumExpensed = array_sum(array_column($approvedUsages, 'amount'));
$netBalance = $sumAllocated - $sumExpensed;

// Fetch unique years from allocations & usages for the year dropdown filter
$stmt = $db->prepare("SELECT DISTINCT YEAR(created_at) as yr FROM (
    SELECT created_at FROM fund_allocations WHERE director_id = ?
    UNION
    SELECT resolved_at as created_at FROM fund_usages WHERE director_id = ? AND status = 'approved' AND resolved_at IS NOT NULL
) combined ORDER BY yr DESC");
$stmt->execute([$userId, $userId]);
$years = $stmt->fetchAll(PDO::FETCH_COLUMN);

if (empty($years)) {
    $years = [date('Y')];
}

$pageTitle = "CA Budget Report";
include __DIR__ . '/../includes/header.php';
?>

<div class="panel-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
    <div class="panel-title">
        <h1>CA Budget Report (<?= h($selectedYear) ?>)</h1>
        <p>Annual allocation and expense logs ready for financial auditing.</p>
    </div>
    <div style="display: flex; gap: 10px; align-items: center;">
        <form method="GET" style="display: flex; gap: 5px;">
            <select name="year" class="form-control" style="width: auto; height: 36px; padding: 0 10px; font-size: 13px;" onchange="this.form.submit()">
                <?php foreach ($years as $yr): ?>
                    <option value="<?= $yr ?>" <?= $yr == $selectedYear ? 'selected' : '' ?>><?= $yr ?></option>
                <?php endforeach; ?>
            </select>
        </form>
        <a href="report.php?year=<?= $selectedYear ?>&export=csv" class="btn btn-primary" style="width: auto; height: 36px; line-height: 36px; padding: 0 15px; font-size: 13px;">
            <i class="fa fa-file-csv" style="margin-right: 8px;"></i> Export CSV for CA
        </a>
    </div>
</div>

<!-- Financial Summary Widgets -->
<div class="grid grid-3" style="margin-bottom: 40px;">
    <div class="desktop-card" style="border-left: 4px solid var(--accent);">
        <div style="font-size: 12px; color: var(--text-muted); text-transform: uppercase; margin-bottom: 8px;">Total Allocations (<?= h($selectedYear) ?>)</div>
        <div style="font-size: 24px; font-weight: 800; color: var(--accent);"><?= formatCurrency($sumAllocated) ?></div>
    </div>
    <div class="desktop-card" style="border-left: 4px solid var(--success);">
        <div style="font-size: 12px; color: var(--text-muted); text-transform: uppercase; margin-bottom: 8px;">Approved Expenses (<?= h($selectedYear) ?>)</div>
        <div style="font-size: 24px; font-weight: 800; color: var(--success);"><?= formatCurrency($sumExpensed) ?></div>
    </div>
    <div class="desktop-card" style="border-left: 4px solid var(--primary);">
        <div style="font-size: 12px; color: var(--text-muted); text-transform: uppercase; margin-bottom: 8px;">Net Period Balance</div>
        <div style="font-size: 24px; font-weight: 800; color: var(--primary);"><?= formatCurrency($netBalance) ?></div>
    </div>
</div>

<div class="grid grid-2">
    <!-- Allocations Statement -->
    <div class="desktop-card" style="padding: 0;">
        <div style="padding: 20px; border-bottom: 1px solid var(--border);">
            <h3 style="font-size: 15px; font-weight: 700; margin: 0;">Funding Allocations Statement</h3>
        </div>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Allocated By</th>
                        <th>Amount</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($allocations)): ?>
                        <tr><td colspan="4" style="text-align: center; color: var(--text-muted); padding: 30px;">No allocations for this period.</td></tr>
                    <?php else:
                        foreach ($allocations as $a): ?>
                            <tr>
                                <td><?= date('d M Y', strtotime($a['created_at'])) ?></td>
                                <td><?= h($a['admin_name']) ?></td>
                                <td style="font-weight: 700; color: var(--accent);"><?= formatCurrency($a['amount']) ?></td>
                                <td style="font-size: 12px; max-width: 150px;"><?= h($a['notes']) ?: '-' ?></td>
                            </tr>
                        <?php endforeach;
                    endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Expense Statement -->
    <div class="desktop-card" style="padding: 0;">
        <div style="padding: 20px; border-bottom: 1px solid var(--border);">
            <h3 style="font-size: 15px; font-weight: 700; margin: 0;">Approved Expenses Statement</h3>
        </div>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Approval Date</th>
                        <th>Category</th>
                        <th>Amount</th>
                        <th>Proof</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($approvedUsages)): ?>
                        <tr><td colspan="4" style="text-align: center; color: var(--text-muted); padding: 30px;">No approved expenses for this period.</td></tr>
                    <?php else:
                        foreach ($approvedUsages as $u): ?>
                            <tr>
                                <td><?= date('d M Y', strtotime($u['resolved_at'])) ?></td>
                                <td><span style="font-size: 12px; font-weight: 600;"><?= h($u['purpose']) ?></span></td>
                                <td style="font-weight: 700;"><?= formatCurrency($u['amount']) ?></td>
                                <td>
                                    <a href="<?= site_url('public/file.php?type=expense&file=' . urlencode($u['payment_proof'])) ?>" target="_blank" style="font-size: 11px; color: var(--accent); text-decoration: underline;">
                                        Receipt
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach;
                    endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
