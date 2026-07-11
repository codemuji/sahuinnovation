<?php
require_once __DIR__ . '/../../app/core/Auth.php';
Auth::requireRole('director');

$db = Database::getInstance()->getConnection();

// Query to get each director's total approved expenses
$stmt = $db->query("SELECT u.id, u.name, u.employee_id, 
       COALESCE(SUM(CASE WHEN f.status = 'approved' THEN f.amount ELSE 0 END), 0) as total_approved_expense
FROM users u
LEFT JOIN fund_usages f ON u.id = f.director_id
WHERE u.role = 'director' AND u.is_active = 1
GROUP BY u.id
ORDER BY total_approved_expense DESC");
$directorsExpenses = $stmt->fetchAll();

// Calculate the grand total across all directors
$grandTotal = array_sum(array_column($directorsExpenses, 'total_approved_expense'));

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
        <div style="font-size: 12px; color: var(--text-muted); text-transform: uppercase; margin-bottom: 8px; letter-spacing: 0.5px;">All Directors Total Expenses</div>
        <div style="font-size: 28px; font-weight: 800; color: var(--primary); font-family: 'Outfit', sans-serif;"><?= formatCurrency($grandTotal) ?></div>
        <div style="font-size: 11px; color: var(--text-muted); margin-top: 8px;">Sum of all verified director payouts</div>
    </div>
</div>

<!-- Directors Expenses Table -->
<div class="desktop-card" style="padding: 0;">
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
                            <td>
                                <?= h($de['name']) ?>
                                <?php if ($de['id'] == Auth::userId()): ?>
                                    <span style="font-size: 10px; background: #e0f2fe; color: #0369a1; padding: 2px 6px; border-radius: 4px; font-weight: 700; margin-left: 6px;">YOU</span>
                                <?php endif; ?>
                            </td>
                            <td><?= h($de['employee_id']) ?: '<span style="color: var(--text-muted);">N/A</span>' ?></td>
                            <td style="text-align: right; padding-right: 30px; font-weight: 700; color: var(--success);"><?= formatCurrency($de['total_approved_expense']) ?></td>
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

<?php include __DIR__ . '/../includes/footer.php'; ?>
