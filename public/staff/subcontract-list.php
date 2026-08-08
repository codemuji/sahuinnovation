<?php
require_once __DIR__ . '/../../app/core/Auth.php';
Auth::requireRole(['subcontract_staff', 'admin']);

$db = Database::getInstance()->getConnection();
ensureSubcontractTables($db);

$userRole = Auth::userRole();
$userId = Auth::userId();

// Fetch all active Subcontractors for project assignment (Admin view)
$subcontractors = [];
if ($userRole === 'admin') {
    $stmt = $db->query("SELECT id, name, employee_id FROM users WHERE role = 'subcontractor' AND is_active = 1 ORDER BY name ASC");
    $subcontractors = $stmt->fetchAll();
}

// Fetch Subcontract Projects
if ($userRole === 'subcontract_staff') {
    $currentUser = Auth::user();
    $contractorId = $currentUser['subcontractor_id'] ?? 0;
    $stmt = $db->prepare("SELECT p.*, c.name as contractor_name, s.name as staff_name 
        FROM subcontract_projects p 
        JOIN users c ON p.contractor_id = c.id 
        JOIN users s ON p.created_by_staff_id = s.id 
        WHERE p.contractor_id = ?
        ORDER BY p.created_at DESC");
    $stmt->execute([$contractorId]);
    $projects = $stmt->fetchAll();
} else {
    $stmt = $db->query("SELECT p.*, c.name as contractor_name, s.name as staff_name 
        FROM subcontract_projects p 
        JOIN users c ON p.contractor_id = c.id 
        JOIN users s ON p.created_by_staff_id = s.id 
        ORDER BY p.created_at DESC");
    $projects = $stmt->fetchAll();
}

$pageTitle = "Sub-Contract Management";
include __DIR__ . '/../includes/header.php';
?>

<div class="panel-header">
    <div class="panel-title">
        <h1>Sub-Contract Management</h1>
        <p><?= $userRole === 'admin' ? 'Assign new sub-contract installation jobs and manage workflow stage progression.' : 'View assigned sub-contract jobs and update stage workflow progression.' ?></p>
    </div>
</div>

<div class="<?= $userRole === 'admin' ? 'grid grid-3' : 'grid grid-1' ?>" style="margin-bottom: 40px; align-items: start;">
    <?php if ($userRole === 'admin'): ?>
    <!-- Create Sub-Contract Form (1 Column - Admin Only) -->
    <div class="desktop-card" style="grid-column: span 1;">
        <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 20px; border-bottom: 1px solid var(--border); padding-bottom: 10px;">New Sub-Contract Job</h3>
        
        <form action="<?= site_url('app/actions/subcontract_actions.php') ?>" method="POST">
            <input type="hidden" name="action" value="create_project">
            
            <div class="form-group">
                <label class="form-label" for="contractor_id">Select Sub-Contractor <span style="color: var(--danger);">*</span></label>
                <select class="form-control" id="contractor_id" name="contractor_id" required>
                    <option value="">-- Select Subcontractor --</option>
                    <?php foreach ($subcontractors as $sc): ?>
                        <option value="<?= $sc['id'] ?>"><?= h($sc['name']) ?> (<?= h($sc['employee_id']) ?>)</option>
                    <?php endforeach; ?>
                </select>
                <?php if (empty($subcontractors)): ?>
                    <small style="color: var(--danger); font-size: 11px;">No active Subcontractor accounts. Please create one in User Management first.</small>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label class="form-label" for="customer_name">Customer Name <span style="color: var(--danger);">*</span></label>
                <input type="text" class="form-control" id="customer_name" name="customer_name" required placeholder="Full Name">
            </div>

            <div class="form-group">
                <label class="form-label" for="phone">Phone Number <span style="color: var(--danger);">*</span></label>
                <input type="tel" class="form-control" id="phone" name="phone" required placeholder="Mobile Number">
            </div>

            <div class="form-group">
                <label class="form-label" for="consumer_number">Consumer Number</label>
                <input type="text" class="form-control" id="consumer_number" name="consumer_number" placeholder="APDCL Consumer Number">
            </div>

            <div class="form-group">
                <label class="form-label" for="address">Installation Address <span style="color: var(--danger);">*</span></label>
                <textarea class="form-control" id="address" name="address" rows="3" required placeholder="Full Site Address"></textarea>
            </div>

            <div class="form-group">
                <label class="form-label" for="contract_type">Contract Flow Model <span style="color: var(--danger);">*</span></label>
                <select class="form-control" id="contract_type" name="contract_type" required>
                    <option value="12_step">Standard 12-Step Sub-Contract</option>
                    <option value="part_pay">Part Pay Sub-Contract</option>
                </select>
            </div>

            <div style="margin-top: 25px;">
                <button type="submit" class="btn btn-primary" style="width: 100%;"><i class="fa fa-plus" style="margin-right: 6px;"></i> Assign Sub-Contract</button>
            </div>
        </form>
    </div>
    <?php endif; ?>

    <!-- Projects Table -->
    <div class="desktop-card" style="grid-column: <?= $userRole === 'admin' ? 'span 2' : 'span 1' ?>; padding: 0;">
        <div style="padding: 20px; border-bottom: 1px solid var(--border);">
            <h3 style="font-size: 16px; font-weight: 700; margin: 0;">Active Sub-Contract Projects</h3>
        </div>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Subcontractor</th>
                        <th>Flow Model</th>
                        <th>Current Stage</th>
                        <th style="text-align: right;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($projects)): ?>
                        <tr><td colspan="5" style="text-align: center; color: var(--text-muted); padding: 40px;">No sub-contract jobs assigned yet.</td></tr>
                    <?php else:
                        foreach ($projects as $p): ?>
                            <tr>
                                <td data-label="Customer">
                                    <strong><?= h($p['customer_name']) ?></strong>
                                    <div style="font-size: 11px; color: var(--text-muted);"><?= h($p['phone']) ?></div>
                                </td>
                                <td data-label="Subcontractor">
                                    <strong><?= h($p['contractor_name']) ?></strong>
                                </td>
                                <td data-label="Model">
                                    <span class="badge" style="background: <?= $p['contract_type'] === '12_step' ? '#e0f2fe' : '#f3e8ff' ?>; color: <?= $p['contract_type'] === '12_step' ? '#0369a1' : '#6b21a8' ?>; font-size: 10px;">
                                        <?= $p['contract_type'] === '12_step' ? '12-STEP' : 'PART PAY' ?>
                                    </span>
                                </td>
                                <td data-label="Stage">
                                    <span class="badge" style="background: #f8fafc; color: var(--primary); font-weight: 700; font-size: 11px;">
                                        <?= h($p['status']) ?>
                                    </span>
                                </td>
                                <td data-label="Action" style="text-align: right;">
                                    <a href="subcontract-detail.php?id=<?= $p['id'] ?>" class="btn" style="width: auto; height: 30px; line-height: 30px; padding: 0 12px; font-size: 12px; border: 1px solid var(--accent); color: var(--accent); background: transparent; text-decoration: none; font-weight: 600;">
                                        Manage Stage
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

<?php include __DIR__ . '/../includes/footer.php'; ?>
