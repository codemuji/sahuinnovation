<?php
require_once __DIR__ . '/../../app/core/Auth.php';
Auth::requireRole(['staff', 'admin']);

if (Auth::userRole() === 'subcontract_staff') {
    redirect(site_url('public/staff/subcontract-list.php'));
}

$db = Database::getInstance()->getConnection();

// Get counts for Survey pipeline
$stmt = $db->query("SELECT status, COUNT(*) as count FROM survey_customers GROUP BY status");
$surveyCounts = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

// Get counts for Technical pipeline
$stmt = $db->query("SELECT status, COUNT(*) as count FROM technical_customers GROUP BY status");
$techCounts = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
$techPending = ($techCounts['pending'] ?? 0) + ($techCounts['APPLICATION'] ?? 0);
$techApproved = 0;
foreach ($techCounts as $stg => $cnt) {
    if (!in_array($stg, ['pending', 'APPLICATION', 'revert_back', 'rejected'])) {
        $techApproved += $cnt;
    }
}

$userId = Auth::userId();
$stmt = $db->prepare("SELECT SUM(amount) FROM salary_disbursements WHERE user_id = ? AND type = 'salary'");
$stmt->execute([$userId]);
$totalStaffSalary = $stmt->fetchColumn() ?: 0.00;

$stmt = $db->prepare("SELECT SUM(amount) FROM salary_disbursements WHERE user_id = ? AND type = 'advance'");
$stmt->execute([$userId]);
$totalStaffAdvance = $stmt->fetchColumn() ?: 0.00;

$pageTitle = "Staff Dashboard";
include __DIR__ . '/../includes/header.php';
?>

<div class="panel-header">
    <div class="panel-title">
        <h1>Staff Overview</h1>
        <p>Monitor pending reviews and view your salary and advance disbursements.</p>
    </div>
</div>

<div class="grid grid-2" style="margin-bottom: 30px;">
    <div class="desktop-card" style="border-left: 4px solid var(--success);">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <div style="font-size: 11px; color: var(--text-muted); text-transform: uppercase; margin-bottom: 4px;">Total Salary Received</div>
                <div style="font-size: 24px; font-weight: 800; color: var(--success);"><?= formatCurrency($totalStaffSalary) ?></div>
            </div>
            <a href="salary-advance.php" class="btn btn-primary" style="width: auto; height: 34px; font-size: 12px; padding: 0 12px; line-height: 34px; text-decoration: none;">
                Salary History
            </a>
        </div>
    </div>
    <div class="desktop-card" style="border-left: 4px solid var(--info);">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <div style="font-size: 11px; color: var(--text-muted); text-transform: uppercase; margin-bottom: 4px;">Total Advance Received</div>
                <div style="font-size: 24px; font-weight: 800; color: var(--info);"><?= formatCurrency($totalStaffAdvance) ?></div>
            </div>
            <a href="report.php" class="btn" style="width: auto; height: 34px; font-size: 12px; padding: 0 12px; line-height: 32px; text-decoration: none; border: 1px solid var(--border); background: var(--background); color: var(--text-main);">
                My Report
            </a>
        </div>
    </div>
</div>

<div class="grid grid-2">
    <!-- Survey Pipeline Card -->
    <div class="desktop-card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
            <h3 style="font-size: 18px; font-weight: 700;">Application Review</h3>
            <a href="survey-list.php" class="btn btn-primary" style="width: auto; height: 36px; font-size: 13px;">Review All</a>
        </div>
        <div class="grid grid-4">
            <div style="text-align: center; padding: 15px; background: #fffbeb; border-radius: 8px;">
                <div style="font-size: 20px; font-weight: 700; color: var(--warning);"><?= $surveyCounts['pending'] ?? 0 ?></div>
                <div style="font-size: 11px; font-weight: 600; text-transform: uppercase;">Pending</div>
            </div>
            <div style="text-align: center; padding: 15px; background: #fdf2f8; border-radius: 8px;">
                <div style="font-size: 20px; font-weight: 700; color: #db2777;"><?= $surveyCounts['revert_back'] ?? 0 ?></div>
                <div style="font-size: 11px; font-weight: 600; text-transform: uppercase;">Reverted</div>
            </div>
            <div style="text-align: center; padding: 15px; background: #ecfdf5; border-radius: 8px;">
                <div style="font-size: 20px; font-weight: 700; color: var(--success);"><?= $surveyCounts['approved'] ?? 0 ?></div>
                <div style="font-size: 11px; font-weight: 600; text-transform: uppercase;">Approved</div>
            </div>
            <div style="text-align: center; padding: 15px; background: #fef2f2; border-radius: 8px;">
                <div style="font-size: 20px; font-weight: 700; color: var(--danger);"><?= $surveyCounts['rejected'] ?? 0 ?></div>
                <div style="font-size: 11px; font-weight: 600; text-transform: uppercase;">Rejected</div>
            </div>
        </div>
    </div>

    <!-- Technical Pipeline Card -->
    <div class="desktop-card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
            <h3 style="font-size: 18px; font-weight: 700;">PM Surya Ghar Application</h3>
            <a href="technical-list.php" class="btn btn-primary" style="width: auto; height: 36px; font-size: 13px;">Review All</a>
        </div>
        <div class="grid grid-4">
            <div style="text-align: center; padding: 15px; background: #fffbeb; border-radius: 8px;">
                <div style="font-size: 20px; font-weight: 700; color: var(--warning);"><?= $techPending ?></div>
                <div style="font-size: 11px; font-weight: 600; text-transform: uppercase;">Pending / Stage 1</div>
            </div>
            <div style="text-align: center; padding: 15px; background: #fdf2f8; border-radius: 8px;">
                <div style="font-size: 20px; font-weight: 700; color: #db2777;"><?= $techCounts['revert_back'] ?? 0 ?></div>
                <div style="font-size: 11px; font-weight: 600; text-transform: uppercase;">Reverted</div>
            </div>
            <div style="text-align: center; padding: 15px; background: #ecfdf5; border-radius: 8px;">
                <div style="font-size: 20px; font-weight: 700; color: var(--success);"><?= $techApproved ?></div>
                <div style="font-size: 11px; font-weight: 600; text-transform: uppercase;">In Progress / Done</div>
            </div>
            <div style="text-align: center; padding: 15px; background: #fef2f2; border-radius: 8px;">
                <div style="font-size: 20px; font-weight: 700; color: var(--danger);"><?= $techCounts['rejected'] ?? 0 ?></div>
                <div style="font-size: 11px; font-weight: 600; text-transform: uppercase;">Rejected</div>
            </div>
        </div>
    </div>
</div>

<div style="margin-top: 40px;">
    <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 20px;">Latest Pending Surveys</h3>
    <div class="desktop-card" style="padding: 0;">
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Surveyer</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt = $db->query("SELECT s.*, u.name as surveyer_name FROM survey_customers s JOIN users u ON s.surveyer_id = u.id WHERE s.status = 'pending' ORDER BY s.created_at ASC LIMIT 5");
                    $pendingSurveys = $stmt->fetchAll();
                    
                    if (empty($pendingSurveys)): ?>
                        <tr><td colspan="4" style="text-align: center; padding: 24px; color: var(--text-muted);">No pending surveys.</td></tr>
                    <?php else: ?>
                        <?php foreach ($pendingSurveys as $s): ?>
                            <tr>
                                <td style="font-weight: 600;"><?= h($s['name']) ?></td>
                                <td><?= h($s['surveyer_name']) ?></td>
                                <td><?= date('d M Y', strtotime($s['created_at'])) ?></td>
                                <td><a href="survey-detail.php?id=<?= $s['id'] ?>" class="btn" style="height: 32px; padding: 0 12px; font-size: 12px; width: auto; background: var(--primary); color: white;">Review</a></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
