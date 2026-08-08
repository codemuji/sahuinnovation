<?php
require_once __DIR__ . '/../../app/core/Auth.php';
Auth::requireRole('staff');

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
$whereDisburse = "user_id = ?";
$whereAlloc = "a.director_id = ?";
$paramsDisburse = [$userId];
$paramsAlloc = [$userId];
$periodLabel = "";

if ($filterType === 'month') {
    $whereDisburse .= " AND DATE_FORMAT(created_at, '%Y-%m') = ?";
    $whereAlloc .= " AND DATE_FORMAT(a.created_at, '%Y-%m') = ?";
    $paramsDisburse[] = $selectedMonth;
    $paramsAlloc[] = $selectedMonth;
    $periodLabel = date('F Y', strtotime($selectedMonth . '-01'));
} elseif ($filterType === 'range') {
    $whereDisburse .= " AND DATE(created_at) BETWEEN ? AND ?";
    $whereAlloc .= " AND DATE(a.created_at) BETWEEN ? AND ?";
    $paramsDisburse[] = $fromDate;
    $paramsDisburse[] = $toDate;
    $paramsAlloc[] = $fromDate;
    $paramsAlloc[] = $toDate;
    $periodLabel = date('d M Y', strtotime($fromDate)) . ' to ' . date('d M Y', strtotime($toDate));
} else { // 'year'
    $whereDisburse .= " AND YEAR(created_at) = ?";
    $whereAlloc .= " AND YEAR(a.created_at) = ?";
    $paramsDisburse[] = $selectedYear;
    $paramsAlloc[] = $selectedYear;
    $periodLabel = "Year " . $selectedYear;
}

// CSV Export Logic
if (isset($_GET['export']) && $_GET['export'] === 'csv') {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=Staff-Financial-Report-' . str_replace(' ', '_', $periodLabel) . '-' . str_replace(' ', '_', $user['name']) . '.csv');
    
    $output = fopen('php://output', 'w');
    
    fputcsv($output, ["SAHU INNOVATION PVT. LTD."]);
    fputcsv($output, ["STAFF FINANCIAL STATEMENT - " . $periodLabel]);
    fputcsv($output, ["Employee Name:", $user['name']]);
    fputcsv($output, ["Employee ID:", $user['employee_id']]);
    fputcsv($output, []);
    
    // Disbursements Section
    fputcsv($output, ["--- SALARY & ADVANCE DISBURSEMENTS ---"]);
    fputcsv($output, ["Date", "Type", "Amount (INR)", "Notes"]);
    
    $stmt = $db->prepare("SELECT * FROM salary_disbursements WHERE $whereDisburse ORDER BY created_at ASC");
    $stmt->execute($paramsDisburse);
    $disbursedLogs = $stmt->fetchAll();
    
    $totalDisbursed = 0.00;
    foreach ($disbursedLogs as $d) {
        fputcsv($output, [
            date('Y-m-d', strtotime($d['created_at'])),
            ucfirst($d['type']),
            $d['amount'],
            $d['notes']
        ]);
        $totalDisbursed += $d['amount'];
    }
    fputcsv($output, ["", "Total Disbursed:", $totalDisbursed]);
    fputcsv($output, []);
    
    fclose($output);
    exit();
}

// GUI View Logic
$stmt = $db->prepare("SELECT * FROM salary_disbursements WHERE $whereDisburse ORDER BY created_at DESC");
$stmt->execute($paramsDisburse);
$disbursements = $stmt->fetchAll();

$sumDisbursed = array_sum(array_column($disbursements, 'amount'));

// Fetch unique years for filter
$stmt = $db->prepare("SELECT DISTINCT YEAR(created_at) as yr FROM (
    SELECT created_at FROM salary_disbursements WHERE user_id = ?
    UNION
    SELECT created_at FROM fund_allocations WHERE director_id = ?
) combined ORDER BY yr DESC");
$stmt->execute([$userId, $userId]);
$years = $stmt->fetchAll(PDO::FETCH_COLUMN);

if (empty($years)) {
    $years = [date('Y')];
}

$pageTitle = "My Financial Statement & Report";
include __DIR__ . '/../includes/header.php';
?>

<div class="panel-header">
    <div class="panel-title">
        <h1>My Financial Statement & Report</h1>
        <p>View and export your salary, advance disbursements, and financial statement.</p>
    </div>
</div>

<!-- Filter Bar -->
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

        <!-- Custom Range Inputs -->
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

        <div style="display: flex; gap: 8px;">
            <button type="submit" class="btn btn-primary" style="height: 38px; padding: 0 16px; font-size: 13px;">
                <i class="fa fa-filter"></i> Apply Filter
            </button>
            <a href="report.php" class="btn" style="height: 38px; padding: 0 12px; line-height: 36px; border: 1px solid var(--border); font-size: 13px; text-decoration: none; color: var(--text-main);">
                Reset
            </a>
            <a href="report.php?<?= http_build_query(array_merge($_GET, ['export' => 'csv'])) ?>" class="btn" style="height: 38px; padding: 0 16px; line-height: 36px; background: #059669; color: white; font-size: 13px; text-decoration: none; font-weight: 600;">
                <i class="fa fa-file-excel"></i> Export CSV
            </a>
        </div>
    </form>
</div>

<!-- Statement Cards -->
<div class="grid grid-2" style="margin-bottom: 30px;">
    <div class="desktop-card" style="border-left: 4px solid var(--accent);">
        <div style="font-size: 11px; color: var(--text-muted); text-transform: uppercase; margin-bottom: 6px;">Disbursements Received (Period)</div>
        <div style="font-size: 24px; font-weight: 800; color: var(--accent);"><?= formatCurrency($sumDisbursed) ?></div>
        <div style="font-size: 11px; color: var(--text-muted); margin-top: 4px;">Statement for <?= h($periodLabel) ?></div>
    </div>
</div>

<!-- Table -->
<div class="desktop-card" style="padding: 0;">
    <div style="padding: 20px; border-bottom: 1px solid var(--border);">
        <h3 style="font-size: 16px; font-weight: 700; margin: 0;">Salary & Advance Disbursements Statement</h3>
    </div>
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Notes / Reference</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($disbursements)): ?>
                    <tr><td colspan="4" style="text-align: center; color: var(--text-muted); padding: 40px;">No disbursements found for this period.</td></tr>
                <?php else:
                    foreach ($disbursements as $d): ?>
                        <tr>
                            <td data-label="Date"><?= date('d M Y', strtotime($d['created_at'])) ?></td>
                            <td data-label="Type">
                                <span class="badge badge-<?= $d['type'] === 'salary' ? 'success' : 'info' ?>">
                                    <?= ucfirst(h($d['type'])) ?>
                                </span>
                            </td>
                            <td data-label="Amount" style="font-weight: 800; color: var(--accent);"><?= formatCurrency($d['amount']) ?></td>
                            <td data-label="Notes / Reference" style="font-size: 13px;"><?= h($d['notes']) ?: '-' ?></td>
                        </tr>
                    <?php endforeach;
                endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function handleFilterTypeChange() {
    const type = document.getElementById('filter_type').value;
    document.getElementById('year-filter-group').style.display = type === 'year' ? 'block' : 'none';
    document.getElementById('month-filter-group').style.display = type === 'month' ? 'block' : 'none';
    document.getElementById('range-filter-group').style.display = type === 'range' ? 'flex' : 'none';
}
document.addEventListener('DOMContentLoaded', handleFilterTypeChange);
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>
