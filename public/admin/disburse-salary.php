<?php
require_once __DIR__ . '/../../app/core/Auth.php';
Auth::requireRole('admin');

$db = Database::getInstance()->getConnection();

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

// Fetch all active directors and office staff
$stmt = $db->query("SELECT id, name, employee_id, role FROM users WHERE role IN ('director', 'office_staff') AND is_active = 1 ORDER BY name ASC");
$directors = $stmt->fetchAll();

$pageTitle = "Disburse Salary & Advance";
include __DIR__ . '/../includes/header.php';
?>

<div class="panel-header">
    <div class="panel-title">
        <h1>Disburse Salary / Advance</h1>
        <p>Transfer salary or advance payments directly to a Director or Office Staff member.</p>
    </div>
</div>

<div class="grid grid-2">
    <!-- Disbursement Form -->
    <div class="desktop-card">
        <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 20px; border-bottom: 1px solid var(--border); padding-bottom: 10px;">New Salary / Advance Disbursement</h3>
        <form action="<?= site_url('app/actions/disburse_salary.php') ?>" method="POST">
            <div class="form-group">
                <label class="form-label" for="user_id">Select Director / Office Staff <span style="color: var(--danger);">*</span></label>
                <select class="form-control" id="user_id" name="user_id" required>
                    <option value="">-- Select Recipient --</option>
                    <?php foreach ($directors as $emp): ?>
                        <option value="<?= $emp['id'] ?>"><?= h($emp['name']) ?> (<?= h($emp['employee_id']) ?> - <?= strtoupper(h($emp['role'])) ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label" for="type">Disbursement Type <span style="color: var(--danger);">*</span></label>
                <select class="form-control" id="type" name="type" required>
                    <option value="salary">Salary Payment</option>
                    <option value="advance">Advance Payment</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label" for="amount">Disbursement Amount (₹) <span style="color: var(--danger);">*</span></label>
                <input type="number" step="0.01" min="0.01" class="form-control" id="amount" name="amount" required placeholder="0.00">
            </div>

            <div class="form-group">
                <label class="form-label" for="notes">Notes / Payment Reference</label>
                <textarea class="form-control" id="notes" name="notes" rows="3" style="height: auto; padding: 12px;" placeholder="e.g., 'July 2026 Salary' or 'Festival Advance'..."></textarea>
            </div>

            <div style="margin-top: 25px;">
                <button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane" style="margin-right: 8px;"></i> Disburse Payment</button>
            </div>
        </form>
    </div>

    <!-- Recent Disbursements Table -->
    <div class="desktop-card" style="padding: 0;">
        <div style="padding: 20px; border-bottom: 1px solid var(--border);">
            <h3 style="font-size: 16px; font-weight: 700; margin: 0;">Recent Salary / Advance Disbursements</h3>
        </div>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Recipient</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt = $db->query("SELECT s.*, u.name as employee_name, u.role FROM salary_disbursements s JOIN users u ON s.user_id = u.id ORDER BY s.created_at DESC LIMIT 8");
                    $disbursements = $stmt->fetchAll();
                    if (empty($disbursements)): ?>
                        <tr><td colspan="5" style="text-align: center; color: var(--text-muted); padding: 40px;">No salary or advance disbursements recorded yet.</td></tr>
                    <?php else:
                        foreach ($disbursements as $d): ?>
                            <tr>
                                <td><?= date('d M Y', strtotime($d['created_at'])) ?></td>
                                <td style="font-weight: 600;">
                                    <?= h($d['employee_name']) ?>
                                    <div style="font-size: 11px; color: var(--text-muted);"><?= strtoupper(h($d['role'])) ?></div>
                                </td>
                                <td>
                                    <span class="badge badge-<?= $d['type'] === 'salary' ? 'success' : 'info' ?>">
                                        <?= ucfirst(h($d['type'])) ?>
                                    </span>
                                </td>
                                <td style="font-weight: 800; color: var(--accent);"><?= formatCurrency($d['amount']) ?></td>
                                <td style="font-size: 12px; max-width: 140px;"><?= h($d['notes']) ?: '-' ?></td>
                            </tr>
                        <?php endforeach;
                    endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
