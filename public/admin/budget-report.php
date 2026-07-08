<?php
require_once __DIR__ . '/../../app/core/Auth.php';
Auth::requireRole('admin');

$db = Database::getInstance()->getConnection();

$selectedYear = $_GET['year'] ?? date('Y');

// CSV Export Logic
if (isset($_GET['export']) && $_GET['export'] === 'csv') {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=Master-Budget-Report-' . $selectedYear . '.csv');
    
    $output = fopen('php://output', 'w');
    
    fputcsv($output, ["SAHU INNOVATION PVT. LTD."]);
    fputcsv($output, ["MASTER ANNUAL BUDGET REPORT - " . $selectedYear]);
    fputcsv($output, ["Generated At:", date('Y-m-d H:i')]);
    fputcsv($output, []);
    
    // Summary by Directors
    fputcsv($output, ["--- DIRECTORS BUDGET OVERVIEW ---"]);
    fputcsv($output, ["Director Name", "Employee ID", "Total Allocated (INR)", "Total Approved Expenses (INR)", "Remaining Wallet Balance (INR)"]);
    
    $stmt = $db->prepare("SELECT u.id, u.name, u.employee_id, w.balance FROM users u 
        LEFT JOIN wallets w ON u.id = w.user_id 
        WHERE u.role = 'director' AND u.is_active = 1 
        ORDER BY u.name ASC");
    $stmt->execute();
    $directorsList = $stmt->fetchAll();
    
    $totalCompanyAllocated = 0.00;
    $totalCompanyExpensed = 0.00;
    $totalCompanyWallet = 0.00;
    
    foreach ($directorsList as $dir) {
        // Calculate total allocated in selected year
        $st = $db->prepare("SELECT SUM(amount) FROM fund_allocations WHERE director_id = ? AND YEAR(created_at) = ?");
        $st->execute([$dir['id'], $selectedYear]);
        $dirAlloc = $st->fetchColumn() ?? 0.00;
        
        // Calculate total expensed in selected year
        $st = $db->prepare("SELECT SUM(amount) FROM fund_usages WHERE director_id = ? AND status = 'approved' AND YEAR(resolved_at) = ?");
        $st->execute([$dir['id'], $selectedYear]);
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
    fputcsv($output, ["--- ALL BUDGET ALLOCATIONS LOGS ---"]);
    fputcsv($output, ["Date", "Director Name", "Allocated By", "Amount (INR)", "Notes"]);
    
    $stmt = $db->prepare("SELECT a.*, d.name as director_name, ad.name as admin_name FROM fund_allocations a 
        JOIN users d ON a.director_id = d.id 
        JOIN users ad ON a.admin_id = ad.id 
        WHERE YEAR(a.created_at) = ? ORDER BY a.created_at ASC");
    $stmt->execute([$selectedYear]);
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
    fputcsv($output, ["--- ALL APPROVED EXPENSES LOGS ---"]);
    fputcsv($output, ["Approval Date", "Director Name", "Purpose Category", "Description", "Amount (INR)"]);
    
    $stmt = $db->prepare("SELECT u.*, d.name as director_name FROM fund_usages u 
        JOIN users d ON u.director_id = d.id 
        WHERE u.status = 'approved' AND YEAR(u.resolved_at) = ? ORDER BY u.resolved_at ASC");
    $stmt->execute([$selectedYear]);
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

// Fetch all active directors and calculate stats
$stmt = $db->query("SELECT u.id, u.name, u.employee_id, w.balance FROM users u 
    LEFT JOIN wallets w ON u.id = w.user_id 
    WHERE u.role = 'director' AND u.is_active = 1 
    ORDER BY u.name ASC");
$directorsData = $stmt->fetchAll();

$directorSummaries = [];
$totalAlloc = 0.00;
$totalExp = 0.00;

foreach ($directorsData as $d) {
    // Get allocations
    $st = $db->prepare("SELECT SUM(amount) FROM fund_allocations WHERE director_id = ? AND YEAR(created_at) = ?");
    $st->execute([$d['id'], $selectedYear]);
    $allocAmt = $st->fetchColumn() ?? 0.00;

    // Get expenses
    $st = $db->prepare("SELECT SUM(amount) FROM fund_usages WHERE director_id = ? AND status = 'approved' AND YEAR(resolved_at) = ?");
    $st->execute([$d['id'], $selectedYear]);
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

<div class="panel-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
    <div class="panel-title">
        <h1>Master Annual Budget Report (<?= h($selectedYear) ?>)</h1>
        <p>Unified overview of fund allocations, expenditures, and wallet balances across all Directors.</p>
    </div>
    <div style="display: flex; gap: 10px; align-items: center;">
        <form method="GET" style="display: flex; gap: 5px;">
            <select name="year" class="form-control" style="width: auto; height: 36px; padding: 0 10px; font-size: 13px;" onchange="this.form.submit()">
                <?php foreach ($years as $yr): ?>
                    <option value="<?= $yr ?>" <?= $yr == $selectedYear ? 'selected' : '' ?>><?= $yr ?></option>
                <?php endforeach; ?>
            </select>
        </form>
        <a href="budget-report.php?year=<?= $selectedYear ?>&export=csv" class="btn btn-primary" style="width: auto; height: 36px; line-height: 36px; padding: 0 15px; font-size: 13px;">
            <i class="fa fa-file-csv" style="margin-right: 8px;"></i> Export Master CSV for CA
        </a>
    </div>
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
                    <th>Total Allocated (<?= h($selectedYear) ?>)</th>
                    <th>Total Expensed (<?= h($selectedYear) ?>)</th>
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
            <h3 style="font-size: 15px; font-weight: 700; margin: 0;">Recent Allocations Log</h3>
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
                    $stmt = $db->prepare("SELECT a.*, d.name as director_name FROM fund_allocations a 
                        JOIN users d ON a.director_id = d.id 
                        WHERE YEAR(a.created_at) = ? ORDER BY a.created_at DESC LIMIT 5");
                    $stmt->execute([$selectedYear]);
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
                    $stmt = $db->prepare("SELECT f.*, d.name as director_name FROM fund_usages f 
                        JOIN users d ON f.director_id = d.id 
                        WHERE f.status = 'approved' AND YEAR(f.resolved_at) = ? 
                        ORDER BY f.resolved_at DESC LIMIT 5");
                    $stmt->execute([$selectedYear]);
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

<?php include __DIR__ . '/../includes/footer.php'; ?>
