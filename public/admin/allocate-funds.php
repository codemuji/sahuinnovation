<?php
require_once __DIR__ . '/../../app/core/Auth.php';
Auth::requireRole('admin');

$db = Database::getInstance()->getConnection();

// Fetch all active directors and office staff
$stmt = $db->query("SELECT id, name, employee_id, role FROM users WHERE role IN ('director', 'office_staff') AND is_active = 1 ORDER BY name ASC");
$directors = $stmt->fetchAll();

$pageTitle = "Allocate Funds";
include __DIR__ . '/../includes/header.php';
?>

<div class="panel-header">
    <div class="panel-title">
        <h1>Allocate Funds</h1>
        <p>Transfer budget allocation directly to a Director or Office Staff virtual wallet.</p>
    </div>
</div>

<div class="grid grid-2">
    <!-- Allocation Form -->
    <div class="desktop-card">
        <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 20px; border-bottom: 1px solid var(--border); padding-bottom: 10px;">New Allocation</h3>
        <form action="<?= site_url('app/actions/allocate_fund.php') ?>" method="POST">
            <div class="form-group">
                <label class="form-label" for="director_id">Select Director / Office Staff <span style="color: var(--danger);">*</span></label>
                <select class="form-control" id="director_id" name="director_id" required>
                    <option value="">-- Select Recipient --</option>
                    <?php foreach ($directors as $d): ?>
                        <option value="<?= $d['id'] ?>"><?= h($d['name']) ?> (<?= h($d['employee_id']) ?> - <?= strtoupper(h($d['role'])) ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label" for="amount">Allocation Amount (₹) <span style="color: var(--danger);">*</span></label>
                <input type="number" step="0.01" min="0.01" class="form-control" id="amount" name="amount" required placeholder="0.00">
            </div>

            <div class="form-group">
                <label class="form-label" for="notes">Notes / Budget Reference</label>
                <textarea class="form-control" id="notes" name="notes" rows="4" style="height: auto; padding: 12px;" placeholder="Add details like 'Q3 Solar Equipment Budget' or 'Travel Allocation'..."></textarea>
            </div>

            <div style="margin-top: 25px;">
                <button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane" style="margin-right: 8px;"></i> Allocate Budget</button>
            </div>
        </form>
    </div>

    <!-- Recent Allocations Table -->
    <div class="desktop-card" style="padding: 0;">
        <div style="padding: 20px; border-bottom: 1px solid var(--border);">
            <h3 style="font-size: 16px; font-weight: 700; margin: 0;">Recent Allocations</h3>
        </div>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Director</th>
                        <th>Amount</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt = $db->query("SELECT a.*, u.name as director_name FROM fund_allocations a JOIN users u ON a.director_id = u.id ORDER BY a.created_at DESC LIMIT 6");
                    $allocations = $stmt->fetchAll();
                    if (empty($allocations)): ?>
                        <tr><td colspan="4" style="text-align: center; color: var(--text-muted); padding: 40px;">No budget allocations recorded yet.</td></tr>
                    <?php else:
                        foreach ($allocations as $a): ?>
                            <tr>
                                <td><?= date('d M Y', strtotime($a['created_at'])) ?></td>
                                <td style="font-weight: 600;"><?= h($a['director_name']) ?></td>
                                <td style="font-weight: 800; color: var(--accent);"><?= formatCurrency($a['amount']) ?></td>
                                <td style="font-size: 12px; max-width: 150px;"><?= h($a['notes']) ?: '-' ?></td>
                            </tr>
                        <?php endforeach;
                    endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
