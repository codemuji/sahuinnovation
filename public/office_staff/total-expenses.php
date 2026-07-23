<?php
require_once __DIR__ . '/../../app/core/Auth.php';
Auth::requireRole('office_staff');

$db = Database::getInstance()->getConnection();

// Query to get each office staff member's total approved expenses
$stmt = $db->query("SELECT u.id, u.name, u.employee_id, 
       COALESCE(SUM(CASE WHEN f.status = 'approved' THEN f.amount ELSE 0 END), 0) as total_approved_expense
FROM users u
LEFT JOIN fund_usages f ON u.id = f.director_id
WHERE u.role = 'office_staff' AND u.is_active = 1
GROUP BY u.id
ORDER BY total_approved_expense DESC");
$directorsExpenses = $stmt->fetchAll();

// Calculate the grand total across all office staff
$grandTotal = array_sum(array_column($directorsExpenses, 'total_approved_expense'));

// Query to get total allocations
$totalAllocationsStmt = $db->query("SELECT SUM(a.amount) FROM fund_allocations a JOIN users u ON a.director_id = u.id WHERE u.role = 'office_staff' AND u.is_active = 1");
$totalAllocations = $totalAllocationsStmt->fetchColumn() ?? 0.00;

// Query to get total wallet balance
$totalBalanceStmt = $db->query("SELECT SUM(w.balance) FROM wallets w JOIN users u ON w.user_id = u.id WHERE u.role = 'office_staff' AND u.is_active = 1");
$totalBalance = $totalBalanceStmt->fetchColumn() ?? 0.00;

// Pagination for transactions list
$limitTx = 10;
$pageTx = isset($_GET['page_tx']) ? max(1, intval($_GET['page_tx'])) : 1;
$offsetTx = ($pageTx - 1) * $limitTx;

// Get total count of transactions for pagination
$countTxStmt = $db->query("SELECT COUNT(*) FROM wallet_transactions wt JOIN users u ON wt.user_id = u.id WHERE u.role = 'director' AND u.is_active = 1 AND wt.ref_type != 'salary_disbursement'");
$totalTx = $countTxStmt->fetchColumn();
$totalPagesTx = ceil($totalTx / $limitTx);

// Fetch transactions page
$txStmt = $db->prepare("SELECT wt.*, u.name as director_name FROM wallet_transactions wt 
    JOIN users u ON wt.user_id = u.id 
    WHERE u.role = 'director' AND u.is_active = 1 AND wt.ref_type != 'salary_disbursement' 
    ORDER BY wt.created_at DESC 
    LIMIT $limitTx OFFSET $offsetTx");
$txStmt->execute();
$transactions = $txStmt->fetchAll();

$pageTitle = "Total Expenses";
include __DIR__ . '/../includes/header.php';
?>

<div class="panel-header">
    <div class="panel-title">
        <h1>Total Expenses</h1>
        <p>Comparative summary of approved expenditures for all Directors in the company.</p>
    </div>
</div>

<!-- Grand Total Cards -->
<div class="grid grid-3" style="margin-bottom: 40px;">
    <div class="desktop-card" style="border-left: 4px solid var(--accent); grid-column: span 1;">
        <div style="font-size: 12px; color: var(--text-muted); text-transform: uppercase; margin-bottom: 8px; letter-spacing: 0.5px;">All Directors Total Allocated</div>
        <div style="font-size: 28px; font-weight: 800; color: var(--accent); font-family: 'Outfit', sans-serif;"><?= formatCurrency($totalAllocations) ?></div>
        <div style="font-size: 11px; color: var(--text-muted); margin-top: 8px;">Sum of all allocations from admin</div>
    </div>
    <div class="desktop-card" style="border-left: 4px solid var(--danger); grid-column: span 1;">
        <div style="font-size: 12px; color: var(--text-muted); text-transform: uppercase; margin-bottom: 8px; letter-spacing: 0.5px;">All Directors Total Expenses</div>
        <div style="font-size: 28px; font-weight: 800; color: var(--primary); font-family: 'Outfit', sans-serif;"><?= formatCurrency($grandTotal) ?></div>
        <div style="font-size: 11px; color: var(--text-muted); margin-top: 8px;">Sum of all verified director payouts</div>
    </div>
    <div class="desktop-card" style="border-left: 4px solid var(--success); grid-column: span 1;">
        <div style="font-size: 12px; color: var(--text-muted); text-transform: uppercase; margin-bottom: 8px; letter-spacing: 0.5px;">All Directors Wallet Balance</div>
        <div style="font-size: 28px; font-weight: 800; color: var(--success); font-family: 'Outfit', sans-serif;"><?= formatCurrency($totalBalance) ?></div>
        <div style="font-size: 11px; color: var(--text-muted); margin-top: 8px;">Remaining funds available in director wallets</div>
    </div>
</div>

<!-- Directors Expenses Table -->
<div class="desktop-card" style="padding: 0; margin-bottom: 40px;">
    <div style="padding: 20px; border-bottom: 1px solid var(--border);">
        <h3 style="font-size: 16px; font-weight: 700; margin: 0;">Expenditures by Director</h3>
    </div>
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Director Name</th>
                    <th>Employee ID</th>
                    <th style="text-align: right; padding-right: 30px;">Total Approved Expense</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($directorsExpenses)): ?>
                    <tr><td colspan="3" style="text-align: center; color: var(--text-muted); padding: 30px;">No active directors found.</td></tr>
                <?php else:
                    foreach ($directorsExpenses as $de): ?>
                        <tr style="<?= $de['id'] == Auth::userId() ? 'background-color: #f8fafc; font-weight: 500;' : '' ?>">
                            <td data-label="Director Name">
                                <?= h($de['name']) ?>
                                <?php if ($de['id'] == Auth::userId()): ?>
                                    <span style="font-size: 10px; background: #e0f2fe; color: #0369a1; padding: 2px 6px; border-radius: 4px; font-weight: 700; margin-left: 6px;">YOU</span>
                                <?php endif; ?>
                            </td>
                            <td data-label="Employee ID"><?= h($de['employee_id']) ?: '<span style="color: var(--text-muted);">N/A</span>' ?></td>
                            <td data-label="Total Expense" style="text-align: right; padding-right: 30px; font-weight: 700; color: var(--success);"><?= formatCurrency($de['total_approved_expense']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <!-- Totals Row -->
                    <tr style="background: var(--background); font-weight: 700; border-top: 2px solid var(--border);">
                        <td>Grand Total</td>
                        <td></td>
                        <td style="text-align: right; padding-right: 30px; font-size: 16px; color: var(--primary); font-weight: 800;"><?= formatCurrency($grandTotal) ?></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- All Directors Transactions Table -->
<div class="desktop-card" style="padding: 0; margin-bottom: 40px;">
    <div style="padding: 20px; border-bottom: 1px solid var(--border);">
        <h3 style="font-size: 16px; font-weight: 700; margin: 0;">All Directors' Transactions (Credit & Debit)</h3>
        <p style="font-size: 12px; color: var(--text-muted); margin-top: 4px;">Historical credit allocations and approved debit expenses across all active directors.</p>
    </div>
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Date/Time</th>
                    <th>Director</th>
                    <th>Type</th>
                    <th>Reference</th>
                    <th>Amount</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($transactions)): ?>
                    <tr><td colspan="6" style="text-align: center; color: var(--text-muted); padding: 40px;">No transaction logs found.</td></tr>
                <?php else:
                    foreach ($transactions as $t): ?>
                        <tr>
                            <td data-label="Date/Time"><?= date('d M Y H:i', strtotime($t['created_at'])) ?></td>
                            <td data-label="Director">
                                <strong><?= h($t['director_name']) ?></strong>
                                <?php if ($t['user_id'] == Auth::userId()): ?>
                                    <span style="font-size: 10px; background: #e0f2fe; color: #0369a1; padding: 2px 6px; border-radius: 4px; font-weight: 700; margin-left: 4px;">YOU</span>
                                <?php endif; ?>
                            </td>
                            <td data-label="Type">
                                <?php
                                $typeBg = $t['type'] === 'credit' ? '#d1fae5' : '#fee2e2';
                                $typeFg = $t['type'] === 'credit' ? '#065f46' : '#991b1b';
                                ?>
                                <span class="badge" style="background: <?= $typeBg ?>; color: <?= $typeFg ?>; font-size: 10px;">
                                    <?= strtoupper($t['type']) ?>
                                </span>
                            </td>
                            <td data-label="Reference">
                                <span style="font-size: 12px; font-weight: 600; text-transform: capitalize; color: var(--text-muted);">
                                    <?= str_replace('_', ' ', $t['ref_type']) ?> #<?= $t['ref_id'] ?>
                                </span>
                            </td>
                            <td data-label="Amount" style="font-weight: 700; color: <?= $t['type'] === 'credit' ? 'var(--success)' : 'var(--text-main)' ?>;">
                                <?= ($t['type'] === 'credit' ? '+' : '-') . formatCurrency($t['amount']) ?>
                            </td>
                            <td data-label="Description" style="font-size: 13px; color: var(--text-muted);"><?= h($t['description']) ?></td>
                        </tr>
                    <?php endforeach;
                endif; ?>
            </tbody>
        </table>
    </div>
    
    <!-- Pagination for Transactions -->
    <?php if ($totalPagesTx > 1): ?>
        <div style="padding: 20px; display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--border);">
            <div style="font-size: 13px; color: var(--text-muted);">
                Showing <?= $offsetTx + 1 ?> to <?= min($offsetTx + $limitTx, $totalTx) ?> of <?= $totalTx ?> transactions
            </div>
            <div style="display: flex; gap: 5px;">
                <?php if ($pageTx > 1): ?>
                    <a href="?page_tx=<?= $pageTx - 1 ?>" class="btn" style="width: auto; height: 32px; padding: 0 12px; font-size: 12px; line-height: 32px; border: 1px solid var(--border); text-decoration: none; color: var(--text-main); background: white;">Previous</a>
                <?php endif; ?>
                
                <?php for ($i = 1; $i <= $totalPagesTx; $i++): ?>
                    <a href="?page_tx=<?= $i ?>" class="btn" style="width: auto; height: 32px; padding: 0 12px; font-size: 12px; line-height: 32px; border: 1px solid <?= $i === $pageTx ? 'var(--accent)' : 'var(--border)' ?>; text-decoration: none; color: <?= $i === $pageTx ? 'white' : 'var(--text-main)' ?>; background: <?= $i === $pageTx ? 'var(--accent)' : 'white' ?>;"><?= $i ?></a>
                <?php endfor; ?>
                
                <?php if ($pageTx < $totalPagesTx): ?>
                    <a href="?page_tx=<?= $pageTx + 1 ?>" class="btn" style="width: auto; height: 32px; padding: 0 12px; font-size: 12px; line-height: 32px; border: 1px solid var(--border); text-decoration: none; color: var(--text-main); background: white;">Next</a>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
