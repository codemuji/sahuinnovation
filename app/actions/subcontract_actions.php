<?php
/**
 * Sub-Contract Actions Handler (Create, Progress Stage, MD Payments)
 */

require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../core/helpers.php';
require_once __DIR__ . '/../config/database.php';

Auth::requireRole(['staff', 'admin', 'director', 'subcontractor']);

$db = Database::getInstance()->getConnection();
$role = Auth::userRole();
$userId = Auth::userId();

// Ensure DB tables exist dynamically
$db->exec("ALTER TABLE users MODIFY COLUMN role ENUM('surveyer', 'dm', 'pe', 'staff', 'admin', 'director', 'office_staff', 'subcontractor') NOT NULL");

$db->exec("CREATE TABLE IF NOT EXISTS subcontract_projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    contractor_id INT NOT NULL,
    created_by_staff_id INT NOT NULL,
    customer_name VARCHAR(150) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    consumer_number VARCHAR(100),
    address TEXT NOT NULL,
    contract_type ENUM('12_step', 'part_pay') NOT NULL DEFAULT '12_step',
    status VARCHAR(100) DEFAULT '1. APPLICATION',
    payment_1_amount DECIMAL(10, 2) DEFAULT 0.00,
    payment_1_status ENUM('pending', 'approved', 'paid') DEFAULT 'pending',
    payment_1_date TIMESTAMP NULL,
    payment_1_notes TEXT,
    payment_2_amount DECIMAL(10, 2) DEFAULT 0.00,
    payment_2_status ENUM('pending', 'approved', 'paid') DEFAULT 'pending',
    payment_2_date TIMESTAMP NULL,
    payment_2_notes TEXT,
    part_pay_amount DECIMAL(10, 2) DEFAULT 0.00,
    part_pay_status ENUM('pending', 'approved', 'paid') DEFAULT 'pending',
    part_pay_date TIMESTAMP NULL,
    part_pay_notes TEXT,
    customer_feedback TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (contractor_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by_staff_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

$db->exec("CREATE TABLE IF NOT EXISTS subcontract_documents (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT NOT NULL,
    step_name VARCHAR(100) NOT NULL,
    file_path VARCHAR(500) NOT NULL,
    original_name VARCHAR(255) NOT NULL,
    uploaded_by INT NOT NULL,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (project_id) REFERENCES subcontract_projects(id) ON DELETE CASCADE,
    FOREIGN KEY (uploaded_by) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    try {
        if ($action === 'create_project') {
            if (!in_array($role, ['staff', 'admin'])) {
                throw new Exception("Only Staff and Admin can create Sub-Contract projects.");
            }

            $contractorId = intval($_POST['contractor_id'] ?? 0);
            $customerName = trim($_POST['customer_name'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $consumerNum = trim($_POST['consumer_number'] ?? '');
            $address = trim($_POST['address'] ?? '');
            $contractType = in_array($_POST['contract_type'] ?? '', ['12_step', 'part_pay']) ? $_POST['contract_type'] : '12_step';

            if (!$contractorId || empty($customerName) || empty($phone) || empty($address)) {
                throw new Exception("Please fill in all required customer and contractor fields.");
            }

            $initialStatus = ($contractType === 'part_pay') ? 'PART PAY INITIATED' : '1. APPLICATION';

            $stmt = $db->prepare("INSERT INTO subcontract_projects (contractor_id, created_by_staff_id, customer_name, phone, consumer_number, address, contract_type, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$contractorId, $userId, $customerName, $phone, $consumerNum, $address, $contractType, $initialStatus]);

            setFlash('success', "Sub-Contract project for {$customerName} created successfully.");
            redirect(site_url('public/staff/subcontract-list.php'));

        } elseif ($action === 'update_stage') {
            if (!in_array($role, ['staff', 'admin'])) {
                throw new Exception("Only Staff and Admin can update project stages.");
            }

            $projectId = intval($_POST['project_id'] ?? 0);
            $nextStatus = trim($_POST['status'] ?? '');
            $feedback = trim($_POST['customer_feedback'] ?? '');

            if (!$projectId || empty($nextStatus)) {
                throw new Exception("Invalid project or status parameters.");
            }

            $db->beginTransaction();

            $stmt = $db->prepare("SELECT * FROM subcontract_projects WHERE id = ?");
            $stmt->execute([$projectId]);
            $proj = $stmt->fetch();

            if (!$proj) {
                throw new Exception("Sub-contract project not found.");
            }

            // Handle optional document upload for the step
            if (isset($_FILES['step_doc']) && $_FILES['step_doc']['error'] === UPLOAD_ERR_OK) {
                $targetDir = __DIR__ . '/../../uploads/subcontract_docs/';
                $upload = uploadFile($_FILES['step_doc'], $targetDir);

                if (isset($upload['success'])) {
                    $stmt = $db->prepare("INSERT INTO subcontract_documents (project_id, step_name, file_path, original_name, uploaded_by) VALUES (?, ?, ?, ?, ?)");
                    $stmt->execute([$projectId, $nextStatus, $upload['path'], $upload['original_name'], $userId]);
                } else {
                    throw new Exception("Document upload failed: " . ($upload['error'] ?? 'Unknown error'));
                }
            }

            $sql = "UPDATE subcontract_projects SET status = ?";
            $params = [$nextStatus];

            if (!empty($feedback)) {
                $sql .= ", customer_feedback = ?";
                $params[] = $feedback;
            }

            $sql .= " WHERE id = ?";
            $params[] = $projectId;

            $stmt = $db->prepare($sql);
            $stmt->execute($params);

            $db->commit();
            setFlash('success', "Project stage updated to: {$nextStatus}");
            redirect(site_url("public/staff/subcontract-detail.php?id={$projectId}"));

        } elseif ($action === 'process_md_payment') {
            if (!in_array($role, ['admin', 'director'])) {
                throw new Exception("Only MD (Admin / Director) can disburse Sub-Contract payments.");
            }

            $projectId = intval($_POST['project_id'] ?? 0);
            $paymentType = $_POST['payment_type'] ?? '';
            $amount = floatval($_POST['amount'] ?? 0);
            $notes = trim($_POST['notes'] ?? '');

            if (!$projectId || $amount <= 0 || !in_array($paymentType, ['1st_payment', '2nd_payment', 'part_pay'])) {
                throw new Exception("Valid payment amount and payment type are required.");
            }

            $db->beginTransaction();

            $stmt = $db->prepare("SELECT * FROM subcontract_projects WHERE id = ?");
            $stmt->execute([$projectId]);
            $proj = $stmt->fetch();

            if (!$proj) {
                throw new Exception("Sub-contract project not found.");
            }

            $contractorId = $proj['contractor_id'];

            if ($paymentType === '1st_payment') {
                $stmt = $db->prepare("UPDATE subcontract_projects SET payment_1_amount = ?, payment_1_status = 'approved', payment_1_date = CURRENT_TIMESTAMP, payment_1_notes = ?, status = '6. INSTALLATION' WHERE id = ?");
                $stmt->execute([$amount, $notes, $projectId]);
                $desc = "Sub Contract 1st Payment for customer: " . $proj['customer_name'];
            } elseif ($paymentType === '2nd_payment') {
                $stmt = $db->prepare("UPDATE subcontract_projects SET payment_2_amount = ?, payment_2_status = 'approved', payment_2_date = CURRENT_TIMESTAMP, payment_2_notes = ?, status = '12. CUSTOMER FEEDBACK' WHERE id = ?");
                $stmt->execute([$amount, $notes, $projectId]);
                $desc = "Sub Contract 2nd Payment for customer: " . $proj['customer_name'];
            } else { // part_pay
                $stmt = $db->prepare("UPDATE subcontract_projects SET part_pay_amount = part_pay_amount + ?, part_pay_status = 'approved', part_pay_date = CURRENT_TIMESTAMP, part_pay_notes = ? WHERE id = ?");
                $stmt->execute([$amount, $notes, $projectId]);
                $desc = "Sub Contract Part Payment for customer: " . $proj['customer_name'];
            }

            // Credit Subcontractor's wallet balance
            $stmt = $db->prepare("INSERT INTO wallets (user_id, balance) VALUES (?, ?) ON DUPLICATE KEY UPDATE balance = balance + ?");
            $stmt->execute([$contractorId, $amount, $amount]);

            // Record transaction row
            $stmt = $db->prepare("INSERT INTO wallet_transactions (user_id, ref_type, ref_id, type, amount, status, description) VALUES (?, 'technical', ?, 'credit', ?, 'approved', ?)");
            $stmt->execute([$contractorId, $projectId, $amount, $desc]);

            $db->commit();
            setFlash('success', "Payment of " . formatCurrency($amount) . " processed successfully.");

            if ($role === 'admin') {
                redirect(site_url('public/admin/subcontract-payments.php'));
            } else {
                redirect(site_url("public/staff/subcontract-detail.php?id={$projectId}"));
            }

        } else {
            throw new Exception("Invalid action requested.");
        }

    } catch (Exception $e) {
        if ($db->inTransaction()) $db->rollBack();
        setFlash('danger', 'Error: ' . $e->getMessage());
        redirect(site_url('public/staff/subcontract-list.php'));
    }
} else {
    redirect(site_url('public/index.php'));
}
