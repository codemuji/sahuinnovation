<?php
/**
 * Update Technical Customer Status & Stage Details Action
 */

require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../config/database.php';

Auth::requireRole(['staff', 'admin', 'dm', 'pe']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = Database::getInstance()->getConnection();
    $id = intval($_POST['id'] ?? 0);
    $status = trim($_POST['status'] ?? '');
    $role = Auth::userRole();
    $userId = Auth::userId();

    if (!$id) {
        setFlash('danger', 'Invalid customer ID.');
        redirect(site_url('public/index.php'));
    }

    try {
        $db->beginTransaction();

        $stmt = $db->prepare("SELECT t.*, u.role as dm_role FROM technical_customers t JOIN users u ON t.dm_id = u.id WHERE t.id = ?");
        $stmt->execute([$id]);
        $customer = $stmt->fetch();

        if (!$customer) {
            throw new Exception("Customer not found.");
        }

        $dmId = $customer['dm_id'];

        // If DM or PE, verify ownership and only allow updating customer feedback / stage 11
        if (in_array($role, ['dm', 'pe'])) {
            if ($dmId != $userId) {
                throw new Exception("Unauthorized access to this customer.");
            }
            $feedback = trim($_POST['customer_feedback'] ?? '');
            $newStatus = ($status === 'CUSTOMER FEEDBACK' || !empty($feedback)) ? 'CUSTOMER FEEDBACK' : $customer['status'];
            
            $stmt = $db->prepare("UPDATE technical_customers SET customer_feedback = ?, status = ? WHERE id = ?");
            $stmt->execute([$feedback, $newStatus, $id]);
            
            $db->commit();
            setFlash('success', 'Customer feedback updated successfully.');
            redirect(site_url("public/staff/technical-detail.php?id={$id}"));
        }

        // For Staff and Admin:
        if ($status === 'DM/AGENT PAYMENT' && $role !== 'admin') {
            throw new Exception("Only Admin can update status to DM/AGENT PAYMENT and disburse payment.");
        }

        // Collect optional stage fields
        $bank_details = isset($_POST['bank_details']) ? trim($_POST['bank_details']) : $customer['bank_details'];
        $sanction_amount = isset($_POST['sanction_amount']) && $_POST['sanction_amount'] !== '' ? floatval($_POST['sanction_amount']) : $customer['sanction_amount'];
        $disbursement_1_amount = isset($_POST['disbursement_1_amount']) && $_POST['disbursement_1_amount'] !== '' ? floatval($_POST['disbursement_1_amount']) : $customer['disbursement_1_amount'];
        $disbursement_1_date = !empty($_POST['disbursement_1_date']) ? $_POST['disbursement_1_date'] : $customer['disbursement_1_date'];
        $payment_amount = isset($_POST['payment_amount']) && $_POST['payment_amount'] !== '' ? floatval($_POST['payment_amount']) : $customer['payment_amount'];
        $disbursement_2_amount = isset($_POST['disbursement_2_amount']) && $_POST['disbursement_2_amount'] !== '' ? floatval($_POST['disbursement_2_amount']) : $customer['disbursement_2_amount'];
        $disbursement_2_date = !empty($_POST['disbursement_2_date']) ? $_POST['disbursement_2_date'] : $customer['disbursement_2_date'];
        $customer_feedback = isset($_POST['customer_feedback']) ? trim($_POST['customer_feedback']) : $customer['customer_feedback'];

        // If no status passed, keep current
        if (empty($status)) {
            $status = $customer['status'];
        }

        // Update technical_customers record
        $sql = "UPDATE technical_customers SET 
            status = ?, 
            bank_details = ?, 
            sanction_amount = ?, 
            disbursement_1_amount = ?, 
            disbursement_1_date = ?, 
            payment_amount = ?, 
            disbursement_2_amount = ?, 
            disbursement_2_date = ?, 
            customer_feedback = ?
            WHERE id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            $status,
            $bank_details,
            $sanction_amount,
            $disbursement_1_amount,
            $disbursement_1_date,
            $payment_amount,
            $disbursement_2_amount,
            $disbursement_2_date,
            $customer_feedback,
            $id
        ]);

        // If Admin is updating to DM/AGENT PAYMENT or adjusting payment amount
        if ($role === 'admin' && $status === 'DM/AGENT PAYMENT' && $payment_amount !== null && $payment_amount >= 0) {
            $stmt = $db->prepare("SELECT * FROM wallet_transactions WHERE ref_type = 'technical' AND ref_id = ? AND user_id = ?");
            $stmt->execute([$id, $dmId]);
            $trans = $stmt->fetch();

            if ($trans) {
                if ($trans['status'] === 'approved') {
                    // Adjust wallet balance by the difference
                    $diff = $payment_amount - floatval($trans['amount']);
                    if ($diff != 0) {
                        $stmt = $db->prepare("INSERT INTO wallets (user_id, balance) VALUES (?, ?) ON DUPLICATE KEY UPDATE balance = balance + ?");
                        $stmt->execute([$dmId, $payment_amount, $diff]);
                    }
                } else {
                    // First time approving payment
                    $stmt = $db->prepare("INSERT INTO wallets (user_id, balance) VALUES (?, ?) ON DUPLICATE KEY UPDATE balance = balance + ?");
                    $stmt->execute([$dmId, $payment_amount, $payment_amount]);
                }
                // Update transaction row
                $stmt = $db->prepare("UPDATE wallet_transactions SET amount = ?, status = 'approved', description = ? WHERE id = ?");
                $stmt->execute([$payment_amount, "Technical incentive (Manual Admin Payment) for customer: " . $customer['name'], $trans['id']]);
            } else {
                // Insert new approved transaction
                $stmt = $db->prepare("INSERT INTO wallet_transactions (user_id, ref_type, ref_id, type, amount, status, description) VALUES (?, 'technical', ?, 'credit', ?, 'approved', ?)");
                $stmt->execute([$dmId, $id, $payment_amount, "Technical incentive (Manual Admin Payment) for customer: " . $customer['name']]);
                
                $stmt = $db->prepare("INSERT INTO wallets (user_id, balance) VALUES (?, ?) ON DUPLICATE KEY UPDATE balance = balance + ?");
                $stmt->execute([$dmId, $payment_amount, $payment_amount]);
            }
        }

        $db->commit();
        setFlash('success', 'Customer status and stage details updated to: ' . h($status));
        redirect(site_url("public/staff/technical-detail.php?id={$id}"));

    } catch (Exception $e) {
        $db->rollBack();
        setFlash('danger', 'Error: ' . $e->getMessage());
        redirect(site_url("public/staff/technical-detail.php?id={$id}"));
    }
} else {
    redirect(site_url('public/index.php'));
}
