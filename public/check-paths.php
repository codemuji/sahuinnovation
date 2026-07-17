<?php
/**
 * Hostinger Upload Paths & Files Diagnostic Tool
 * Admin Only
 */

require_once __DIR__ . '/../app/core/Auth.php';
Auth::requireRole('admin');

$pageTitle = "Hostinger Uploads & Path Diagnostic";
include __DIR__ . '/includes/header.php';

$uploadFolders = [
    'Expense Documents' => __DIR__ . '/../uploads/expense_docs',
    'Survey Documents' => __DIR__ . '/../uploads/survey_docs',
    'Technical Documents' => __DIR__ . '/../uploads/technical_docs',
    'Profile Pictures' => __DIR__ . '/../uploads/profile_pics',
    'Payout Proofs' => __DIR__ . '/../uploads/payouts',
    'Uploads Root' => __DIR__ . '/../uploads',
    'Public Uploads' => __DIR__ . '/uploads',
];
?>

<div class="panel-header">
    <div class="panel-title">
        <h1>Hostinger Server Path Diagnostic</h1>
        <p>Exact physical server locations and files currently stored on this hosting server.</p>
    </div>
</div>

<div class="desktop-card" style="margin-bottom: 24px;">
    <h3 style="margin-bottom: 12px; font-size: 16px;">Server Information</h3>
    <div style="font-family: monospace; font-size: 13px; background: var(--background); padding: 16px; border-radius: var(--radius); border: 1px solid var(--border); line-height: 1.6;">
        <div><strong>Current Script Path (__DIR__):</strong> <?= h(__DIR__) ?></div>
        <div><strong>Document Root:</strong> <?= h($_SERVER['DOCUMENT_ROOT'] ?? 'N/A') ?></div>
        <div><strong>PHP OS / Version:</strong> <?= PHP_OS ?> / <?= PHP_VERSION ?></div>
    </div>
</div>

<div class="desktop-card" style="padding: 0;">
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Folder Category</th>
                    <th>Target Relative Path</th>
                    <th>Resolved Physical Server Path</th>
                    <th>Folder Exists? / Perms</th>
                    <th>Files Currently Inside Folder</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($uploadFolders as $label => $path): 
                    $realPath = realpath($path);
                    $exists = is_dir($path);
                    $perms = $exists ? substr(sprintf('%o', fileperms($path)), -4) : 'N/A';
                    $files = $exists ? array_diff(scandir($path), ['.', '..']) : [];
                ?>
                    <tr>
                        <td style="font-weight: 700;"><?= h($label) ?></td>
                        <td style="font-family: monospace; font-size: 12px;"><?= h(str_replace(realpath(__DIR__ . '/..') ?: __DIR__, '[ProjectRoot]', $path)) ?></td>
                        <td style="font-family: monospace; font-size: 12px; color: <?= $realPath ? 'var(--primary)' : 'var(--danger)' ?>;">
                            <?= h($realPath ?: $path . ' (Not created/found yet)') ?>
                        </td>
                        <td>
                            <?php if ($exists): ?>
                                <span class="badge" style="background: #d1fae5; color: #065f46;">YES (<?= $perms ?>)</span>
                            <?php else: ?>
                                <span class="badge" style="background: #fee2e2; color: #991b1b;">NO</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (!$exists): ?>
                                <span style="color: var(--text-muted); font-style: italic;">Folder not created on this server</span>
                            <?php elseif (empty($files)): ?>
                                <span style="color: var(--text-muted); font-style: italic;">0 files inside</span>
                            <?php else: ?>
                                <div style="font-size: 12px; font-weight: 600; color: var(--success); margin-bottom: 6px;">
                                    Found <?= count($files) ?> file(s):
                                </div>
                                <ul style="margin: 0; padding-left: 16px; font-family: monospace; font-size: 11px; max-height: 120px; overflow-y: auto;">
                                    <?php foreach ($files as $f): ?>
                                        <li><?= h($f) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
