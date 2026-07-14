<?php
require_once __DIR__ . '/../../app/core/Auth.php';
Auth::requireRole('director');

$db = Database::getInstance()->getConnection();
$userId = Auth::userId();

// Ensure table exists
$db->exec("CREATE TABLE IF NOT EXISTS salary_disbursements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    admin_id INT NOT NULL,
    user_id INT NOT NULL,
    type ENUM('salary', 'advance') NOT NULL DEFAULT 'salary',
    amount DECIMAL(10, 2) NOT NULL,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

// Total Salary
$stmt = $db->prepare("SELECT SUM(amount) FROM salary_disbursements WHERE user_id = ? AND type = 'salary'");
$stmt->execute([$userId]);
$totalSalary = $stmt->fetchColumn() ?: 0.00;

// Total Advance
$stmt = $db->prepare("SELECT SUM(amount) FROM salary_disbursements WHERE user_id = ? AND type = 'advance'");
$stmt->execute([$userId]);
$totalAdvance = $stmt->fetchColumn() ?: 0.00;

// Total Combined
$totalDisbursed = $totalSalary + $totalAdvance;

// All Disbursements
$stmt = $db->prepare("SELECT * FROM salary_disbursements WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$userId]);
$disbursements = $stmt->fetchAll();

$pageTitle = "My Salary & Advance";
include __DIR__ . '/../includes/header.php';
?>

<div class="panel-header">
    <div class="panel-title">
        <h1>My Salary & Advance</h1>
        <p>Complete history of salary and advance disbursements received from Admin.</p>
    </div>
</div>

<div class="grid grid-3" style="margin-bottom: 30px;">
    <div class="desktop-card">
        <div style="font-size: 12px; color: var(--text-muted); text-transform: uppercase; margin-bottom: 8px; letter-spacing: 0.5px;">Total Salary Received</div>
        <div style="font-size: 26px; font-weight: 800; color: var(--success); font-family: 'Outfit', sans-serif;"><?= formatCurrency($totalSalary) ?></div>
        <div style="font-size: 11px; color: var(--text-muted); margin-top: 8px;">Credited to your wallet</div>
    </div>
    <div class="desktop-card">
        <div style="font-size: 12px; color: var(--text-muted); text-transform: uppercase; margin-bottom: 8px; letter-spacing: 0.5px;">Total Advance Received</div>
        <div style="font-size: 26px; font-weight: 800; color: var(--info); font-family: 'Outfit', sans-serif;"><?= formatCurrency($totalAdvance) ?></div>
        <div style="font-size: 11px; color: var(--text-muted); margin-top: 8px;">Credited to your wallet</div>
    </div>
    <div class="desktop-card">
        <div style="font-size: 12px; color: var(--text-muted); text-transform: uppercase; margin-bottom: 8px; letter-spacing: 0.5px;">Total Disbursed</div>
        <div style="font-size: 26px; font-weight: 800; color: var(--primary); font-family: 'Outfit', sans-serif;"><?= formatCurrency($totalDisbursed) ?></div>
        <div style="font-size: 11px; color: var(--text-muted); margin-top: 8px;">Overall salary + advance</div>
    </div>
</div>

<div class="desktop-card" style="padding: 0;">
    <div style="padding: 20px; border-bottom: 1px solid var(--border);">
        <h3 style="font-size: 16px; font-weight: 700; margin: 0;">Disbursement History</h3>
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
                    <tr>
                        <td colspan="4" style="text-align: center; color: var(--text-muted); padding: 40px;">No salary or advance disbursements received yet.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($disbursements as $d): ?>
                        <tr>
                            <td data-label="Date"><?= date('d M Y, h:i A', strtotime($d['created_at'])) ?></td>
                            <td data-label="Type">
                                <span class="badge badge-<?= $d['type'] === 'salary' ? 'success' : 'info' ?>">
                                    <?= ucfirst(h($d['type'])) ?>
                                </span>
                            </td>
                            <td data-label="Amount" style="font-weight: 800; color: var(--accent);"><?= formatCurrency($d['amount']) ?></td>
                            <td data-label="Notes / Reference" style="font-size: 13px;"><?= h($d['notes']) ?: '-' ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
