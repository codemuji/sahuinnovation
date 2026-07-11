<?php
require_once __DIR__ . '/../../app/core/Auth.php';
Auth::requireRole('admin');

$db = Database::getInstance()->getConnection();

$directorId = $_GET['director_id'] ?? null;
$director = null;

if ($directorId) {
    // Fetch director details
    $stmt = $db->prepare("SELECT u.*, w.balance FROM users u 
        LEFT JOIN wallets w ON u.id = w.user_id 
        WHERE u.id = ? AND u.role = 'director'");
    $stmt->execute([$directorId]);
    $director = $stmt->fetch();
    
    if (!$director) {
        setFlash('danger', 'Director not found.');
        redirect(site_url('public/admin/director-reports.php'));
    }
}

// If director is selected, handle period filters & export
if ($director) {
    $filterType = $_GET['filter_type'] ?? 'year';
    $selectedYear = $_GET['year'] ?? date('Y');
    $selectedMonth = $_GET['month'] ?? date('Y-m');
    $fromDate = $_GET['from_date'] ?? date('Y-m-01');
    $toDate = $_GET['to_date'] ?? date('Y-m-d');
    
    $periodLabel = "";
    $whereAlloc = "a.director_id = ? AND YEAR(a.created_at) = ?";
    $paramsAlloc = [$directorId, $selectedYear];
    $whereUsage = "u.director_id = ? AND u.status = 'approved' AND YEAR(u.resolved_at) = ?";
    $paramsUsage = [$directorId, $selectedYear];
    
    if ($filterType === 'month') {
        $whereAlloc = "a.director_id = ? AND DATE_FORMAT(a.created_at, '%Y-%m') = ?";
        $paramsAlloc = [$directorId, $selectedMonth];
        $whereUsage = "u.director_id = ? AND u.status = 'approved' AND DATE_FORMAT(u.resolved_at, '%Y-%m') = ?";
        $paramsUsage = [$directorId, $selectedMonth];
        $periodLabel = date('F Y', strtotime($selectedMonth . '-01'));
    } elseif ($filterType === 'range') {
        $whereAlloc = "a.director_id = ? AND DATE(a.created_at) BETWEEN ? AND ?";
        $paramsAlloc = [$directorId, $fromDate, $toDate];
        $whereUsage = "u.director_id = ? AND u.status = 'approved' AND DATE(u.resolved_at) BETWEEN ? AND ?";
        $paramsUsage = [$directorId, $fromDate, $toDate];
        $periodLabel = date('d M Y', strtotime($fromDate)) . ' to ' . date('d M Y', strtotime($toDate));
    } else { // 'year'
        $periodLabel = "Year " . $selectedYear;
    }
    
    // CSV Export Logic
    if (isset($_GET['export']) && $_GET['export'] === 'csv') {
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=Budget-Report-' . str_replace(' ', '_', $director['name']) . '-' . str_replace(' ', '_', $periodLabel) . '.csv');
        
        $output = fopen('php://output', 'w');
        
        fputcsv($output, ["SAHU INNOVATION PVT. LTD."]);
        fputcsv($output, ["DIRECTOR BUDGET REPORT - " . $periodLabel]);
        fputcsv($output, ["Director Name:", $director['name']]);
        fputcsv($output, ["Employee ID:", $director['employee_id']]);
        fputcsv($output, ["Current Wallet Balance:", $director['balance'] ?? 0.00]);
        fputcsv($output, ["Generated At:", date('Y-m-d H:i')]);
        fputcsv($output, []);
        
        // Allocations Section
        fputcsv($output, ["--- BUDGET ALLOCATIONS LOG ---"]);
        fputcsv($output, ["Date", "Allocated By", "Amount (INR)", "Notes"]);
        
        $stmt = $db->prepare("SELECT a.*, ad.name as admin_name FROM fund_allocations a 
            JOIN users ad ON a.admin_id = ad.id 
            WHERE $whereAlloc ORDER BY a.created_at ASC");
        $stmt->execute($paramsAlloc);
        $allocLogs = $stmt->fetchAll();
        
        $totalAlloc = 0.00;
        foreach ($allocLogs as $al) {
            fputcsv($output, [
                date('Y-m-d H:i', strtotime($al['created_at'])),
                $al['admin_name'],
                $al['amount'],
                $al['notes']
            ]);
            $totalAlloc += $al['amount'];
        }
        fputcsv($output, ["", "Total Allocated:", $totalAlloc]);
        fputcsv($output, []);
        
        // Approved Expenses Section
        fputcsv($output, ["--- APPROVED EXPENSES LOG ---"]);
        fputcsv($output, ["Approval Date", "Purpose Category", "Description", "Amount (INR)"]);
        
        $stmt = $db->prepare("SELECT u.* FROM fund_usages u 
            WHERE $whereUsage ORDER BY u.resolved_at ASC");
        $stmt->execute($paramsUsage);
        $expLogs = $stmt->fetchAll();
        
        $totalExp = 0.00;
        foreach ($expLogs as $el) {
            fputcsv($output, [
                date('Y-m-d H:i', strtotime($el['resolved_at'])),
                $el['purpose'],
                $el['description'],
                $el['amount']
            ]);
            $totalExp += $el['amount'];
        }
        fputcsv($output, ["", "", "Total Spent:", $totalExp]);
        fputcsv($output, []);
        
        // Summary
        fputcsv($output, ["--- PERIOD SUMMARY ---"]);
        fputcsv($output, ["Allocated Funds", $totalAlloc]);
        fputcsv($output, ["Approved Expenses", $totalExp]);
        fputcsv($output, ["Remaining Wallet Balance", $director['balance'] ?? 0.00]);
        
        fclose($output);
        exit();
    }
    
    // Fetch data for GUI
    // 1. Allocations
    $stmt = $db->prepare("SELECT a.*, ad.name as admin_name FROM fund_allocations a 
        JOIN users ad ON a.admin_id = ad.id 
        WHERE $whereAlloc ORDER BY a.created_at DESC");
    $stmt->execute($paramsAlloc);
    $allocations = $stmt->fetchAll();
    
    // 2. Expenses
    $stmt = $db->prepare("SELECT u.* FROM fund_usages u 
        WHERE $whereUsage ORDER BY u.resolved_at DESC");
    $stmt->execute($paramsUsage);
    $expenses = $stmt->fetchAll();
    
    $totalAlloc = array_sum(array_column($allocations, 'amount'));
    $totalExp = array_sum(array_column($expenses, 'amount'));
    
    // Fetch distinct years for filters
    $stmt = $db->prepare("SELECT DISTINCT YEAR(created_at) as yr FROM (
        SELECT created_at FROM fund_allocations WHERE director_id = ?
        UNION
        SELECT resolved_at as created_at FROM fund_usages WHERE director_id = ? AND status = 'approved' AND resolved_at IS NOT NULL
    ) combined ORDER BY yr DESC");
    $stmt->execute([$directorId, $directorId]);
    $years = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    if (empty($years)) {
        $years = [date('Y')];
    }
} else {
    // Fetch all active directors with balances
    $stmt = $db->query("SELECT u.id, u.name, u.employee_id, u.email, u.phone, w.balance FROM users u 
        LEFT JOIN wallets w ON u.id = w.user_id 
        WHERE u.role = 'director' AND u.is_active = 1 
        ORDER BY u.name ASC");
    $directors = $stmt->fetchAll();
}

$pageTitle = $director ? "Report for " . h($director['name']) : "Director-wise Reports";
include __DIR__ . '/../includes/header.php';
?>

<div class="panel-header">
    <div class="panel-title">
        <h1>Director-wise Reports</h1>
        <p><?= $director ? 'Detailed financial statement and history of allocations and expenses for ' . h($director['name']) : 'Select a Director to view their specific financial statements and transaction logs.' ?></p>
    </div>
</div>

<?php if (!$director): ?>
    <!-- LIST VIEW: All Directors -->
    <div class="desktop-card" style="padding: 0;">
        <div style="padding: 20px; border-bottom: 1px solid var(--border);">
            <h3 style="font-size: 16px; font-weight: 700; margin: 0;">Active Directors Directory</h3>
        </div>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Director Name</th>
                        <th>Employee ID</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Wallet Balance</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($directors)): ?>
                        <tr><td colspan="6" style="text-align: center; color: var(--text-muted); padding: 40px;">No active directors found.</td></tr>
                    <?php else:
                        foreach ($directors as $d): ?>
                            <tr>
                                <td style="font-weight: 600;"><?= h($d['name']) ?></td>
                                <td><?= h($d['employee_id']) ?: '<span style="color: var(--text-muted);">N/A</span>' ?></td>
                                <td><?= h($d['email']) ?></td>
                                <td><?= h($d['phone']) ?: '-' ?></td>
                                <td style="font-weight: 700; color: var(--primary);"><?= formatCurrency($d['balance'] ?? 0.00) ?></td>
                                <td>
                                    <a href="director-reports.php?director_id=<?= $d['id'] ?>" class="btn btn-primary" style="width: auto; height: 30px; font-size: 12px; line-height: 30px; padding: 0 15px; text-decoration: none;">
                                        <i class="fa fa-chart-line"></i> View Report
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach;
                    endif; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php else: ?>
    <!-- DETAILED VIEW: Selected Director -->
    <div style="margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center;">
        <a href="director-reports.php" style="color: var(--text-muted); text-decoration: none; font-size: 14px; font-weight: 500;">
            <i class="fa fa-arrow-left"></i> Back to Directors List
        </a>
    </div>

    <!-- Director Meta & Filters Box -->
    <div class="desktop-card" style="margin-bottom: 30px; padding: 20px;">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 20px; margin-bottom: 20px; padding-bottom: 20px; border-bottom: 1px solid var(--border);">
            <div>
                <h2 style="font-size: 22px; font-weight: 800; color: var(--primary); margin: 0;"><?= h($director['name']) ?></h2>
                <div style="display: flex; gap: 15px; margin-top: 6px; font-size: 13px; color: var(--text-muted);">
                    <span>Emp ID: <strong><?= h($director['employee_id']) ?: 'N/A' ?></strong></span>
                    <span>|</span>
                    <span>Email: <strong><?= h($director['email']) ?></strong></span>
                    <span>|</span>
                    <span>Phone: <strong><?= h($director['phone']) ?: '-' ?></strong></span>
                </div>
            </div>
            <div>
                <div style="text-align: right;">
                    <div style="font-size: 11px; text-transform: uppercase; color: var(--text-muted); font-weight: 600;">Current Wallet Balance</div>
                    <div style="font-size: 24px; font-weight: 800; color: var(--primary);"><?= formatCurrency($director['balance'] ?? 0.00) ?></div>
                </div>
            </div>
        </div>

        <form method="GET" style="display: flex; flex-wrap: wrap; gap: 15px; align-items: flex-end;">
            <input type="hidden" name="director_id" value="<?= $director['id'] ?>">
            
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
                <a href="director-reports.php?director_id=<?= $director['id'] ?>&filter_type=<?= $filterType ?>&year=<?= $selectedYear ?>&month=<?= $selectedMonth ?>&from_date=<?= $fromDate ?>&to_date=<?= $toDate ?>&export=csv" class="btn" style="width: auto; height: 38px; line-height: 38px; padding: 0 20px; font-size: 13px; border: 1px solid var(--accent); color: var(--accent); background: transparent; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 6px;">
                    <i class="fa fa-file-csv"></i> Export CSV for CA
                </a>
            </div>
        </form>
    </div>

    <!-- Period Header Badge -->
    <div style="margin-bottom: 25px;">
        <span style="font-size: 13px; font-weight: 600; text-transform: uppercase; color: var(--text-muted); letter-spacing: 0.5px;">Active Reporting Period:</span>
        <h2 style="font-size: 18px; font-weight: 800; color: var(--primary); margin-top: 4px;"><?= h($periodLabel) ?></h2>
    </div>

    <!-- Financial Summary Widgets -->
    <div class="grid grid-3" style="margin-bottom: 40px;">
        <div class="desktop-card" style="border-left: 4px solid var(--accent);">
            <div style="font-size: 11px; color: var(--text-muted); text-transform: uppercase; margin-bottom: 6px;">Total Budget Allocated (In Period)</div>
            <div style="font-size: 22px; font-weight: 800; color: var(--accent);"><?= formatCurrency($totalAlloc) ?></div>
        </div>
        <div class="desktop-card" style="border-left: 4px solid var(--success);">
            <div style="font-size: 11px; color: var(--text-muted); text-transform: uppercase; margin-bottom: 6px;">Approved Expenses (In Period)</div>
            <div style="font-size: 22px; font-weight: 800; color: var(--success);"><?= formatCurrency($totalExp) ?></div>
        </div>
        <div class="desktop-card" style="border-left: 4px solid var(--primary);">
            <div style="font-size: 11px; color: var(--text-muted); text-transform: uppercase; margin-bottom: 6px;">Net Period Balance</div>
            <div style="font-size: 22px; font-weight: 800; color: var(--primary);"><?= formatCurrency($totalAlloc - $totalExp) ?></div>
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
                        <?php if (empty($expenses)): ?>
                            <tr><td colspan="4" style="text-align: center; color: var(--text-muted); padding: 30px;">No approved expenses for this period.</td></tr>
                        <?php else:
                            foreach ($expenses as $e): ?>
                                <tr>
                                    <td><?= date('d M Y', strtotime($e['resolved_at'])) ?></td>
                                    <td><span style="font-size: 12px; font-weight: 600;"><?= h($e['purpose']) ?></span></td>
                                    <td style="font-weight: 700;"><?= formatCurrency($e['amount']) ?></td>
                                    <td>
                                        <a href="<?= site_url('public/file.php?type=expense&file=' . urlencode($e['payment_proof'])) ?>" target="_blank" style="font-size: 11px; color: var(--accent); text-decoration: underline;">
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
<?php endif; ?>

<?php include __DIR__ . '/../includes/footer.php'; ?>
