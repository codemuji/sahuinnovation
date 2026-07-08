<?php
require_once __DIR__ . '/../../app/core/Auth.php';
Auth::requireRole('admin');

$db = Database::getInstance()->getConnection();

// Determine Filter inputs
$filterType = $_GET['filter_type'] ?? 'year';
$selectedYear = $_GET['year'] ?? date('Y');
$selectedMonth = $_GET['month'] ?? date('Y-m');
$fromDate = $_GET['from_date'] ?? date('Y-m-01');
$toDate = $_GET['to_date'] ?? date('Y-m-d');

$periodLabel = "";
$whereAlloc = "YEAR(a.created_at) = ?";
$paramsAlloc = [$selectedYear];
$whereUsage = "YEAR(u.resolved_at) = ?";
$paramsUsage = [$selectedYear];

if ($filterType === 'month') {
    $whereAlloc = "DATE_FORMAT(a.created_at, '%Y-%m') = ?";
    $paramsAlloc = [$selectedMonth];
    $whereUsage = "DATE_FORMAT(u.resolved_at, '%Y-%m') = ?";
    $paramsUsage = [$selectedMonth];
    $periodLabel = date('F Y', strtotime($selectedMonth . '-01'));
} elseif ($filterType === 'range') {
    $whereAlloc = "DATE(a.created_at) BETWEEN ? AND ?";
    $paramsAlloc = [$fromDate, $toDate];
    $whereUsage = "DATE(u.resolved_at) BETWEEN ? AND ?";
    $paramsUsage = [$fromDate, $toDate];
    $periodLabel = date('d M Y', strtotime($fromDate)) . ' to ' . date('d M Y', strtotime($toDate));
} else { // 'year'
    $periodLabel = "Year " . $selectedYear;
}

// CSV Export Logic
if (isset($_GET['export']) && $_GET['export'] === 'csv') {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=Master-Budget-Report-' . str_replace(' ', '_', $periodLabel) . '.csv');
    
    $output = fopen('php://output', 'w');
    
    fputcsv($output, ["SAHU INNOVATION PVT. LTD."]);
    fputcsv($output, ["MASTER ANNUAL BUDGET REPORT - " . $periodLabel]);
    fputcsv($output, ["Generated At:", date('Y-m-d H:i')]);
    fputcsv($output, []);
    
    // Summary by Directors
    fputcsv($output, ["--- DIRECTORS BUDGET OVERVIEW ---"]);
    fputcsv($output, ["Director Name", "Employee ID", "Allocated (INR)", "Approved Expenses (INR)", "Remaining Wallet Balance (INR)"]);
    
    $stmt = $db->query("SELECT u.id, u.name, u.employee_id, w.balance FROM users u 
        LEFT JOIN wallets w ON u.id = w.user_id 
        WHERE u.role = 'director' AND u.is_active = 1 
        ORDER BY u.name ASC");
    $directorsList = $stmt->fetchAll();
    
    $totalCompanyAllocated = 0.00;
    $totalCompanyExpensed = 0.00;
    $totalCompanyWallet = 0.00;
    
    foreach ($directorsList as $dir) {
        // Calculate allocated in selected period
        if ($filterType === 'month') {
            $st = $db->prepare("SELECT SUM(amount) FROM fund_allocations WHERE director_id = ? AND DATE_FORMAT(created_at, '%Y-%m') = ?");
            $st->execute([$dir['id'], $selectedMonth]);
        } elseif ($filterType === 'range') {
            $st = $db->prepare("SELECT SUM(amount) FROM fund_allocations WHERE director_id = ? AND DATE(created_at) BETWEEN ? AND ?");
            $st->execute([$dir['id'], $fromDate, $toDate]);
        } else {
            $st = $db->prepare("SELECT SUM(amount) FROM fund_allocations WHERE director_id = ? AND YEAR(created_at) = ?");
            $st->execute([$dir['id'], $selectedYear]);
        }
        $dirAlloc = $st->fetchColumn() ?? 0.00;
        
        // Calculate expensed in selected period
        if ($filterType === 'month') {
            $st = $db->prepare("SELECT SUM(amount) FROM fund_usages WHERE director_id = ? AND status = 'approved' AND DATE_FORMAT(resolved_at, '%Y-%m') = ?");
            $st->execute([$dir['id'], $selectedMonth]);
        } elseif ($filterType === 'range') {
            $st = $db->prepare("SELECT SUM(amount) FROM fund_usages WHERE director_id = ? AND status = 'approved' AND DATE(resolved_at) BETWEEN ? AND ?");
            $st->execute([$dir['id'], $fromDate, $toDate]);
        } else {
            $st = $db->prepare("SELECT SUM(amount) FROM fund_usages WHERE director_id = ? AND status = 'approved' AND YEAR(resolved_at) = ?");
            $st->execute([$dir['id'], $selectedYear]);
        }
        $dirExp = $st->fetchColumn() ?? 0.00;
        
        fputcsv($output, [
            $dir['name'],
            $dir['employee_id'],
            $dirAlloc,
            $dirExp,
            $dir['balance']
        ]);
        
        $totalCompanyAllocated += $dirAlloc;
        $totalCompanyExpensed += $dirExp;
        $totalCompanyWallet += $dir['balance'];
    }
    
    fputcsv($output, [
        "Company Totals:",
        "",
        $totalCompanyAllocated,
        $totalCompanyExpensed,
        $totalCompanyWallet
    ]);
    fputcsv($output, []);
    
    // Master Allocation Logs
    fputcsv($output, ["--- BUDGET ALLOCATIONS LOGS ---"]);
    fputcsv($output, ["Date", "Director Name", "Allocated By", "Amount (INR)", "Notes"]);
    
    $stmt = $db->prepare("SELECT a.*, d.name as director_name, ad.name as admin_name FROM fund_allocations a 
        JOIN users d ON a.director_id = d.id 
        JOIN users ad ON a.admin_id = ad.id 
        WHERE $whereAlloc ORDER BY a.created_at ASC");
    $stmt->execute($paramsAlloc);
    $allocLogs = $stmt->fetchAll();
    
    foreach ($allocLogs as $al) {
        fputcsv($output, [
            date('Y-m-d H:i', strtotime($al['created_at'])),
            $al['director_name'],
            $al['admin_name'],
            $al['amount'],
            $al['notes']
        ]);
    }
    fputcsv($output, []);
    
    // Master Approved Expenses Logs
    fputcsv($output, ["--- APPROVED EXPENSES LOGS ---"]);
    fputcsv($output, ["Approval Date", "Director Name", "Purpose Category", "Description", "Amount (INR)"]);
    
    $stmt = $db->prepare("SELECT u.*, d.name as director_name FROM fund_usages u 
        JOIN users d ON u.director_id = d.id 
        WHERE u.status = 'approved' AND $whereUsage ORDER BY u.resolved_at ASC");
    $stmt->execute($paramsUsage);
    $expLogs = $stmt->fetchAll();
    
    foreach ($expLogs as $el) {
        fputcsv($output, [
            date('Y-m-d H:i', strtotime($el['resolved_at'])),
            $el['director_name'],
            $el['purpose'],
            $el['description'],
            $el['amount']
        ]);
    }
    
    fclose($output);
    exit();
}

// Fetch all active directors and calculate period stats
$stmt = $db->query("SELECT u.id, u.name, u.employee_id, w.balance FROM users u 
    LEFT JOIN wallets w ON u.id = w.user_id 
    WHERE u.role = 'director' AND u.is_active = 1 
    ORDER BY u.name ASC");
$directorsData = $stmt->fetchAll();

$directorSummaries = [];
$totalAlloc = 0.00;
$totalExp = 0.00;

foreach ($directorsData as $d) {
    // Get allocations based on filter
    if ($filterType === 'month') {
        $st = $db->prepare("SELECT SUM(amount) FROM fund_allocations WHERE director_id = ? AND DATE_FORMAT(created_at, '%Y-%m') = ?");
        $st->execute([$d['id'], $selectedMonth]);
    } elseif ($filterType === 'range') {
        $st = $db->prepare("SELECT SUM(amount) FROM fund_allocations WHERE director_id = ? AND DATE(created_at) BETWEEN ? AND ?");
        $st->execute([$d['id'], $fromDate, $toDate]);
    } else {
        $st = $db->prepare("SELECT SUM(amount) FROM fund_allocations WHERE director_id = ? AND YEAR(created_at) = ?");
        $st->execute([$d['id'], $selectedYear]);
    }
    $allocAmt = $st->fetchColumn() ?? 0.00;

    // Get expenses based on filter
    if ($filterType === 'month') {
        $st = $db->prepare("SELECT SUM(amount) FROM fund_usages WHERE director_id = ? AND status = 'approved' AND DATE_FORMAT(resolved_at, '%Y-%m') = ?");
        $st->execute([$d['id'], $selectedMonth]);
    } elseif ($filterType === 'range') {
        $st = $db->prepare("SELECT SUM(amount) FROM fund_usages WHERE director_id = ? AND status = 'approved' AND DATE(resolved_at) BETWEEN ? AND ?");
        $st->execute([$d['id'], $fromDate, $toDate]);
    } else {
        $st = $db->prepare("SELECT SUM(amount) FROM fund_usages WHERE director_id = ? AND status = 'approved' AND YEAR(resolved_at) = ?");
        $st->execute([$d['id'], $selectedYear]);
    }
    $expAmt = $st->fetchColumn() ?? 0.00;

    $directorSummaries[] = [
        'name' => $d['name'],
        'employee_id' => $d['employee_id'],
        'allocated' => $allocAmt,
        'expensed' => $expAmt,
        'wallet' => $d['balance'] ?? 0.00
    ];

    $totalAlloc += $allocAmt;
    $totalExp += $expAmt;
}

// Fetch distinct years
$stmt = $db->query("SELECT DISTINCT YEAR(created_at) as yr FROM (
    SELECT created_at FROM fund_allocations
    UNION
    SELECT resolved_at as created_at FROM fund_usages WHERE status = 'approved' AND resolved_at IS NOT NULL
) combined ORDER BY yr DESC");
$years = $stmt->fetchAll(PDO::FETCH_COLUMN);

if (empty($years)) {
    $years = [date('Y')];
}

$pageTitle = "Annual Budget Report";
include __DIR__ . '/../includes/header.php';
?>

<div class="panel-header">
    <div class="panel-title">
        <h1>Master Budget Report</h1>
        <p>Unified overview of fund allocations, expenditures, and wallet balances across all Directors.</p>
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
            <a href="budget-report.php?filter_type=<?= $filterType ?>&year=<?= $selectedYear ?>&month=<?= $selectedMonth ?>&from_date=<?= $fromDate ?>&to_date=<?= $toDate ?>&export=csv" class="btn" style="width: auto; height: 38px; line-height: 38px; padding: 0 20px; font-size: 13px; border: 1px solid var(--accent); color: var(--accent); background: transparent; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 6px;">
                <i class="fa fa-file-csv"></i> Export Master CSV for CA
            </a>
        </div>
    </form>
</div>

<!-- Period Header Badge -->
<div style="margin-bottom: 25px;">
    <span style="font-size: 13px; font-weight: 600; text-transform: uppercase; color: var(--text-muted); letter-spacing: 0.5px;">Active Master Reporting Period:</span>
    <h2 style="font-size: 20px; font-weight: 800; color: var(--primary); margin-top: 4px;"><?= h($periodLabel) ?></h2>
</div>

<!-- Progress Metrics -->
<div class="grid grid-3" style="margin-bottom: 40px;">
    <div class="desktop-card">
        <div style="font-size: 12px; color: var(--text-muted); text-transform: uppercase; margin-bottom: 8px;">Total Budget Allocated</div>
        <div style="font-size: 26px; font-weight: 800; color: var(--accent);"><?= formatCurrency($totalAlloc) ?></div>
    </div>
    <div class="desktop-card">
        <div style="font-size: 12px; color: var(--text-muted); text-transform: uppercase; margin-bottom: 8px;">Total Spent (Approved)</div>
        <div style="font-size: 26px; font-weight: 800; color: var(--success);"><?= formatCurrency($totalExp) ?></div>
    </div>
    <div class="desktop-card">
        <div style="font-size: 12px; color: var(--text-muted); text-transform: uppercase; margin-bottom: 8px;">Budget Utilization Rate</div>
        <?php
        $percent = $totalAlloc > 0 ? min(round(($totalExp / $totalAlloc) * 100), 100) : 0;
        ?>
        <div style="font-size: 26px; font-weight: 800; color: var(--primary); display: flex; align-items: center; gap: 10px;">
            <?= $percent ?>%
            <div style="flex-grow: 1; height: 8px; background-color: var(--border); border-radius: 999px; overflow: hidden; max-width: 150px;">
                <div style="width: <?= $percent ?>%; height: 100%; background-color: var(--success);"></div>
            </div>
        </div>
    </div>
</div>

<!-- Master Director Summary Card -->
<div class="desktop-card" style="padding: 0; margin-bottom: 40px;">
    <div style="padding: 20px; border-bottom: 1px solid var(--border);">
        <h3 style="font-size: 16px; font-weight: 700; margin: 0;">Director Balances & Expenses</h3>
    </div>
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Director Name</th>
                    <th>Employee ID</th>
                    <th>Allocated (In Period)</th>
                    <th>Expensed (In Period)</th>
                    <th>Current Wallet Balance</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($directorSummaries)): ?>
                    <tr><td colspan="5" style="text-align: center; color: var(--text-muted); padding: 30px;">No directors found in database.</td></tr>
                <?php else:
                    foreach ($directorSummaries as $ds): ?>
                        <tr>
                            <td style="font-weight: 600;"><?= h($ds['name']) ?></td>
                            <td><?= h($ds['employee_id']) ?></td>
                            <td style="font-weight: 700; color: var(--accent);"><?= formatCurrency($ds['allocated']) ?></td>
                            <td style="font-weight: 700; color: var(--success);"><?= formatCurrency($ds['expensed']) ?></td>
                            <td style="font-weight: 800; color: var(--primary);"><?= formatCurrency($ds['wallet']) ?></td>
                        </tr>
                    <?php endforeach;
                endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="grid grid-2">
    <!-- Recent Allocations -->
    <div class="desktop-card" style="padding: 0;">
        <div style="padding: 20px; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center;">
            <h3 style="font-size: 15px; font-weight: 700; margin: 0;">Allocations Log</h3>
            <a href="allocate-funds.php" style="font-size: 12px; color: var(--accent); text-decoration: none; font-weight: 600;">Allocate Funds &rarr;</a>
        </div>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Director</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch allocations based on active filter
                    $whereAllocList = "YEAR(a.created_at) = ?";
                    $paramsAllocList = [$selectedYear];
                    if ($filterType === 'month') {
                        $whereAllocList = "DATE_FORMAT(a.created_at, '%Y-%m') = ?";
                        $paramsAllocList = [$selectedMonth];
                    } elseif ($filterType === 'range') {
                        $whereAllocList = "DATE(a.created_at) BETWEEN ? AND ?";
                        $paramsAllocList = [$fromDate, $toDate];
                    }

                    $stmt = $db->prepare("SELECT a.*, d.name as director_name FROM fund_allocations a 
                        JOIN users d ON a.director_id = d.id 
                        WHERE $whereAllocList ORDER BY a.created_at DESC LIMIT 5");
                    $stmt->execute($paramsAllocList);
                    $allocs = $stmt->fetchAll();
                    if (empty($allocs)): ?>
                        <tr><td colspan="3" style="text-align: center; color: var(--text-muted); padding: 20px;">No allocations in this period.</td></tr>
                    <?php else:
                        foreach ($allocs as $al): ?>
                            <tr>
                                <td><?= date('d M Y', strtotime($al['created_at'])) ?></td>
                                <td style="font-weight: 600;"><?= h($al['director_name']) ?></td>
                                <td style="font-weight: 700; color: var(--accent);"><?= formatCurrency($al['amount']) ?></td>
                            </tr>
                        <?php endforeach;
                    endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Recent Expenses -->
    <div class="desktop-card" style="padding: 0;">
        <div style="padding: 20px; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center;">
            <h3 style="font-size: 15px; font-weight: 700; margin: 0;">Approved Expenses Log</h3>
            <a href="expense-reviews.php" style="font-size: 12px; color: var(--accent); text-decoration: none; font-weight: 600;">Review Board &rarr;</a>
        </div>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Approval Date</th>
                        <th>Director</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch expenses based on active filter
                    $whereUsageList = "YEAR(f.resolved_at) = ?";
                    $paramsUsageList = [$selectedYear];
                    if ($filterType === 'month') {
                        $whereUsageList = "DATE_FORMAT(f.resolved_at, '%Y-%m') = ?";
                        $paramsUsageList = [$selectedMonth];
                    } elseif ($filterType === 'range') {
                        $whereUsageList = "DATE(f.resolved_at) BETWEEN ? AND ?";
                        $paramsUsageList = [$fromDate, $toDate];
                    }

                    $stmt = $db->prepare("SELECT f.*, d.name as director_name FROM fund_usages f 
                        JOIN users d ON f.director_id = d.id 
                        WHERE f.status = 'approved' AND $whereUsageList 
                        ORDER BY f.resolved_at DESC LIMIT 5");
                    $stmt->execute($paramsUsageList);
                    $exps = $stmt->fetchAll();
                    if (empty($exps)): ?>
                        <tr><td colspan="3" style="text-align: center; color: var(--text-muted); padding: 20px;">No expenses approved in this period.</td></tr>
                    <?php else:
                        foreach ($exps as $el): ?>
                            <tr>
                                <td><?= date('d M Y', strtotime($el['resolved_at'])) ?></td>
                                <td style="font-weight: 600;"><?= h($el['director_name']) ?></td>
                                <td style="font-weight: 700; color: var(--success);"><?= formatCurrency($el['amount']) ?></td>
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
