<?php
/**
 * Add Fund Usage (Expense) Action
 */

require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../config/database.php';

Auth::requireRole(['director', 'office_staff']);
$basePath = Auth::userRole() === 'office_staff' ? 'public/office_staff/' : 'public/director/';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = Database::getInstance()->getConnection();
    $directorId = Auth::userId();

    $amount = floatval($_POST['amount'] ?? 0);
    $purpose = trim($_POST['purpose'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if ($amount <= 0 || empty($purpose)) {
        setFlash('danger', 'Please enter a valid amount and purpose.');
        redirect(site_url($basePath . 'add-usage.php'));
    }

    // Verify sufficient wallet balance before allowing entry
    $stmt = $db->prepare("SELECT balance FROM wallets WHERE user_id = ?");
    $stmt->execute([$directorId]);
    $wallet = $stmt->fetch();
    $balance = $wallet['balance'] ?? 0.00;

    if ($amount > $balance) {
        setFlash('danger', 'Insufficient wallet balance. You cannot log an expense exceeding your current balance.');
        redirect(site_url($basePath . 'add-usage.php'));
    }

    // Verify file upload
    if (!isset($_FILES['payment_proof']) || $_FILES['payment_proof']['error'] !== UPLOAD_ERR_OK) {
        setFlash('danger', 'Payment proof (receipt/invoice) is required.');
        redirect(site_url($basePath . 'add-usage.php'));
    }

    try {
        $db->beginTransaction();

        // Upload payment proof
        $targetDir = __DIR__ . '/../../uploads/expense_docs/';
        $upload = uploadFile($_FILES['payment_proof'], $targetDir);

        if (!isset($upload['success'])) {
            throw new Exception("Failed to upload payment proof: " . $upload['error']);
        }

        $paymentProof = $upload['path'];

        // Insert Fund Usage record in pending state
        $stmt = $db->prepare("INSERT INTO fund_usages (director_id, amount, purpose, description, payment_proof, status) 
            VALUES (?, ?, ?, ?, ?, 'pending')");
        $stmt->execute([$directorId, $amount, $purpose, $description, $paymentProof]);

        $db->commit();
        setFlash('success', 'Expense logged successfully. Sent for MD review.');
        redirect(site_url($basePath . 'usages.php'));

    } catch (Exception $e) {
        if ($db->inTransaction()) $db->rollBack();
        setFlash('danger', 'Error: ' . $e->getMessage());
        redirect(site_url($basePath . 'add-usage.php'));
    }
} else {
    redirect(site_url($basePath . 'dashboard.php'));
}
