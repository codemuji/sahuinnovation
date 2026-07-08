<?php
require_once __DIR__ . '/../../app/core/Auth.php';
Auth::requireRole('director');

$db = Database::getInstance()->getConnection();
$userId = Auth::userId();
$user = Auth::user();

// Determine Filter inputs
$filterType = $_GET['filter_type'] ?? 'year';
$selectedYear = $_GET['year'] ?? date('Y');
$selectedMonth = $_GET['month'] ?? date('Y-m');
$fromDate = $_GET['from_date'] ?? date('Y-m-01');
$toDate = $_GET['to_date'] ?? date('Y-m-d');

// Build date filtering criteria
$whereAlloc = "a.director_id = ?";
$whereUsage = "director_id = ? AND status = 'approved'";
$paramsAlloc = [$userId];
$paramsUsage = [$userId];
$periodLabel = "";

if ($filterType === 'month') {
    $whereAlloc .= " AND DATE_FORMAT(a.created_at, '%Y-%m') = ?";
    $whereUsage .= " AND DATE_FORMAT(resolved_at, '%Y-%m') = ?";
    $paramsAlloc[] = $selectedMonth;
    $paramsUsage[] = $selectedMonth;
    $periodLabel = date('F Y', strtotime($selectedMonth . '-01'));
} elseif ($filterType === 'range') {
    $whereAlloc .= " AND DATE(a.created_at) BETWEEN ? AND ?";
    $whereUsage .= " AND DATE(resolved_at) BETWEEN ? AND ?";
    $paramsAlloc[] = $fromDate;
    $paramsAlloc[] = $toDate;
    $paramsUsage[] = $fromDate;
    $paramsUsage[] = $toDate;
    $periodLabel = date('d M Y', strtotime($fromDate)) . ' to ' . date('d M Y', strtotime($toDate));
} else { // 'year'
    $whereAlloc .= " AND YEAR(a.created_at) = ?";
    $whereUsage .= " AND YEAR(resolved_at) = ?";
    $paramsAlloc[] = $selectedYear;
    $paramsUsage[] = $selectedYear;
    $periodLabel = "Year " . $selectedYear;
}

// CSV Export Logic
if (isset($_GET['export']) && $_GET['export'] === 'csv') {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=Budget-Report-' . str_replace(' ', '_', $periodLabel) . '-' . str_replace(' ', '_', $user['name']) . '.csv');
    
    $output = fopen('php://output', 'w');
    
    // Header info
    fputcsv($output, ["SAHU INNOVATION PVT. LTD."]);
    fputcsv($output, ["ANNUAL BUDGET REPORT - " . $periodLabel]);
    fputcsv($output, ["Director Name:", $user['name']]);
    fputcsv($output, ["Employee ID:", $user['employee_id']]);
    fputcsv($output, []);
    
    // Allocations Section
    fputcsv($output, ["--- FUND ALLOCATIONS ---"]);
    fputcsv($output, ["Date", "Source", "Amount (INR)", "Notes"]);
    
    $stmt = $db->prepare("SELECT a.*, u.name as admin_name FROM fund_allocations a JOIN users u ON a.admin_id = u.id 
        WHERE $whereAlloc ORDER BY a.created_at ASC");
    $stmt->execute($paramsAlloc);
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
    
    $stmt = $db->prepare("SELECT * FROM fund_usages WHERE $whereUsage ORDER BY resolved_at ASC");
    $stmt->execute($paramsUsage);
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
    WHERE $whereAlloc ORDER BY a.created_at DESC");
$stmt->execute($paramsAlloc);
$allocations = $stmt->fetchAll();

// 2. Fetch Approved Expenses
$stmt = $db->prepare("SELECT * FROM fund_usages WHERE $whereUsage ORDER BY resolved_at DESC");
$stmt->execute($paramsUsage);
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

<div class="panel-header">
    <div class="panel-title">
        <h1>CA Budget Report</h1>
        <p>Allocation and expense statements ready for Chartered Accountant (CA) review.</p>
    </div>
</div>

<!-- Filters Box -->
<div class="desktop-card" style="margin-bottom: 30px; padding: 20px;">
    <form method="GET" style="display: flex; flex-wrap: wrap; gap: 15px; align-items: flex-end;">
        
        <div class="form-group" style="margin-bottom: 0; min-width: 150px;">
            <label class="form-label" for="filter_type" style="margin-bottom: 4px; font-size: 12px;">Filter By</label>
            <select name="filter_type" id="filter_type" class="form-control" style="height: 38px; padding: 0 10px; font-size: 13px;" onchange="handleFilterTypeChange()">
                <option value="year" <?= $filterType === 'year' ? 'selected' : '' ?>>Yearly</option>
                <option value="month" <?= $filterType === 'month' ? 'selected' : '' ?>>Monthly</option>
                <option value="range" <?= $filterType === 'range' ? 'selected' : '' ?>>Custom Date Range</option>
            </select>
        </div>

        <!-- Year Dropdown -->
        <div class="form-group" id="year-filter-group" style="margin-bottom: 0; min-width: 120px; display: none;">
            <label class="form-label" for="year" style="margin-bottom: 4px; font-size: 12px;">Select Year</label>
            <select name="year" id="year" class="form-control" style="height: 38px; padding: 0 10px; font-size: 13px;">
                <?php foreach ($years as $yr): ?>
                    <option value="<?= $yr ?>" <?= $yr == $selectedYear ? 'selected' : '' ?>><?= $yr ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Month Input -->
        <div class="form-group" id="month-filter-group" style="margin-bottom: 0; min-width: 150px; display: none;">
            <label class="form-label" for="month" style="margin-bottom: 4px; font-size: 12px;">Select Month</label>
            <input type="month" name="month" id="month" class="form-control" style="height: 38px; padding: 0 10px; font-size: 13px;" value="<?= h($selectedMonth) ?>">
        </div>

        <!-- Date Range Inputs -->
        <div id="range-filter-group" style="display: none; gap: 10px; align-items: flex-end;">
            <div class="form-group" style="margin-bottom: 0; min-width: 140px;">
                <label class="form-label" for="from_date" style="margin-bottom: 4px; font-size: 12px;">From Date</label>
                <input type="date" name="from_date" id="from_date" class="form-control" style="height: 38px; padding: 0 10px; font-size: 13px;" value="<?= h($fromDate) ?>">
            </div>
            <div class="form-group" style="margin-bottom: 0; min-width: 140px;">
                <label class="form-label" for="to_date" style="margin-bottom: 4px; font-size: 12px;">To Date</label>
                <input type="date" name="to_date" id="to_date" class="form-control" style="height: 38px; padding: 0 10px; font-size: 13px;" value="<?= h($toDate) ?>">
            </div>
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary" style="width: auto; height: 38px; padding: 0 20px; font-size: 13px; line-height: 38px;">
                <i class="fa fa-filter"></i> Apply Filter
            </button>
            <a href="report.php?filter_type=<?= $filterType ?>&year=<?= $selectedYear ?>&month=<?= $selectedMonth ?>&from_date=<?= $fromDate ?>&to_date=<?= $toDate ?>&export=csv" class="btn" style="width: auto; height: 38px; line-height: 38px; padding: 0 20px; font-size: 13px; border: 1px solid var(--accent); color: var(--accent); background: transparent; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 6px;">
                <i class="fa fa-file-csv"></i> Export CSV for CA
            </a>
        </div>
    </form>
</div>

<!-- Period Header Badge -->
<div style="margin-bottom: 25px;">
    <span style="font-size: 13px; font-weight: 600; text-transform: uppercase; color: var(--text-muted); letter-spacing: 0.5px;">Active Reporting Period:</span>
    <h2 style="font-size: 20px; font-weight: 800; color: var(--primary); margin-top: 4px;"><?= h($periodLabel) ?></h2>
</div>

<!-- Financial Summary Widgets -->
<div class="grid grid-3" style="margin-bottom: 40px;">
    <div class="desktop-card" style="border-left: 4px solid var(--accent);">
        <div style="font-size: 12px; color: var(--text-muted); text-transform: uppercase; margin-bottom: 8px;">Total Allocations</div>
        <div style="font-size: 24px; font-weight: 800; color: var(--accent);"><?= formatCurrency($sumAllocated) ?></div>
    </div>
    <div class="desktop-card" style="border-left: 4px solid var(--success);">
        <div style="font-size: 12px; color: var(--text-muted); text-transform: uppercase; margin-bottom: 8px;">Approved Expenses</div>
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

<script>
function handleFilterTypeChange() {
    const type = document.getElementById('filter_type').value;
    document.getElementById('year-filter-group').style.display = type === 'year' ? 'block' : 'none';
    document.getElementById('month-filter-group').style.display = type === 'month' ? 'block' : 'none';
    document.getElementById('range-filter-group').style.display = type === 'range' ? 'flex' : 'none';
}
// Run on load to set initial state
document.addEventListener('DOMContentLoaded', handleFilterTypeChange);
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>
