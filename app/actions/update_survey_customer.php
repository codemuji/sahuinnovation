<?php
/**
 * Update Survey Customer Action (Resubmit)
 */

require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../config/database.php';

Auth::requireRole('surveyer');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = Database::getInstance()->getConnection();
    $userId = Auth::userId();
    $id = $_POST['id'] ?? 0;

    // Basic Data
    $name = trim($_POST['name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $district = trim($_POST['district'] ?? '');
    $state = trim($_POST['state'] ?? 'Assam');

    // New Fields
    $consumer_number = trim($_POST['consumer_number'] ?? '');
    $age_dob = trim($_POST['age_dob'] ?? '');
    $gender = $_POST['gender'] ?? '';
    $email = trim($_POST['email'] ?? '');
    $occupation = trim($_POST['occupation'] ?? '');
    $post_office = trim($_POST['post_office'] ?? '');
    $police_station = trim($_POST['police_station'] ?? '');
    $house_type = $_POST['house_type'] ?? null;
    $customer_opinion = $_POST['customer_opinion'] ?? null;
    $electricity_bill_amount = trim($_POST['electricity_bill_amount'] ?? '');
    $meter_type = $_POST['meter_type'] ?? null;
    $land_type = $_POST['land_type'] ?? null;
    $annual_income = trim($_POST['annual_income'] ?? '');

    $notes = trim($_POST['notes'] ?? '');

    if (empty($id) || empty($name) || empty($phone) || empty($address) || empty($district) || empty($occupation) || empty($post_office) || empty($police_station) || empty($house_type) || empty($customer_opinion) || empty($electricity_bill_amount) || empty($land_type) || empty($annual_income)) {
        setFlash('danger', 'Please fill in all required fields.');
        redirect(site_url("public/surveyer/edit-customer.php?id={$id}"));
    }

    try {
        $db->beginTransaction();

        // 1. Verify ownership and status
        $stmt = $db->prepare("SELECT * FROM survey_customers WHERE id = ? AND surveyer_id = ?");
        $stmt->execute([$id, $userId]);
        $customer = $stmt->fetch();

        if (!$customer || $customer['status'] !== 'revert_back') {
            throw new Exception("Invalid request or survey not in revert status.");
        }

        // 2. Update Customer
        $stmt = $db->prepare("UPDATE survey_customers SET 
            name = ?, phone = ?, consumer_number = ?, age_dob = ?, gender = ?, email = ?, 
            occupation = ?, district = ?, post_office = ?, police_station = ?, state = ?, address = ?, house_type = ?, customer_opinion = ?, 
            electricity_bill_amount = ?, meter_type = ?, land_type = ?, 
            annual_income = ?, notes = ?, status = 'pending', rejection_reason = NULL 
            WHERE id = ?");

        $stmt->execute([
            $name,
            $phone,
            $consumer_number,
            $age_dob,
            $gender,
            $email,
            $occupation,
            $district,
            $post_office,
            $police_station,
            $state,
            $address,
            $house_type,
            $customer_opinion,
            $electricity_bill_amount,
            $meter_type,
            $land_type,
            $annual_income,
            $notes,
            $id
        ]);

        // 3. Handle Document Uploads (Optional during edit)
        $docs = [
            'doc_bank_passbook' => 'bank_passbook',
            'doc_aadhaar' => 'aadhaar',
            'doc_pan' => 'pan',
            'doc_electricity_bill' => 'electricity_bill',
            'doc_signature' => 'signature',
            'doc_gps_photo' => 'gps_photo',
            'doc_house_photo' => 'house_photo'
        ];

        $targetDir = __DIR__ . '/../../uploads/survey_docs/';
        if (!is_dir($targetDir))
            mkdir($targetDir, 0755, true);

        // iOS Safari fallback: GPS photo sent as base64 when DataTransfer API is unsupported
        $gpsB64 = trim($_POST['doc_gps_photo_b64'] ?? '');
        if (
            !empty($gpsB64) &&
            (!isset($_FILES['doc_gps_photo']) || $_FILES['doc_gps_photo']['error'] !== UPLOAD_ERR_OK)
        ) {
            if (preg_match('/^data:image\/(jpeg|png|jpg|webp);base64,(.+)$/i', $gpsB64, $matches)) {
                $imageData = base64_decode($matches[2]);
                if ($imageData !== false) {
                    $ext = strtolower($matches[1]) === 'png' ? 'png' : 'jpg';
                    $fileName = 'gps_' . uniqid() . '_' . time() . '.' . $ext;
                    $filePath = $targetDir . $fileName;
                    if (file_put_contents($filePath, $imageData) !== false) {
                        $relPath = 'uploads/survey_docs/' . $fileName;

                        $stmt = $db->prepare("SELECT id FROM survey_documents WHERE survey_customer_id = ? AND doc_type = ?");
                        $stmt->execute([$id, 'gps_photo']);
                        $existingDoc = $stmt->fetch();

                        if ($existingDoc) {
                            $stmt = $db->prepare("UPDATE survey_documents SET file_path = ?, original_name = ? WHERE id = ?");
                            $stmt->execute([$relPath, $fileName, $existingDoc['id']]);
                        } else {
                            $stmt = $db->prepare("INSERT INTO survey_documents (survey_customer_id, doc_type, file_path, original_name) VALUES (?, ?, ?, ?)");
                            $stmt->execute([$id, 'gps_photo', $relPath, $fileName]);
                        }
                        unset($docs['doc_gps_photo']);
                    }
                }
            }
        }

        foreach ($docs as $inputName => $docType) {
            if (isset($_FILES[$inputName]) && $_FILES[$inputName]['error'] === UPLOAD_ERR_OK) {
                $upload = uploadFile($_FILES[$inputName], $targetDir);

                if (isset($upload['success'])) {
                    // Check if doc exists to update or insert
                    $stmt = $db->prepare("SELECT id FROM survey_documents WHERE survey_customer_id = ? AND doc_type = ?");
                    $stmt->execute([$id, $docType]);
                    $existingDoc = $stmt->fetch();

                    if ($existingDoc) {
                        $stmt = $db->prepare("UPDATE survey_documents SET file_path = ?, original_name = ? WHERE id = ?");
                        $stmt->execute([$upload['path'], $upload['original_name'], $existingDoc['id']]);
                    } else {
                        $stmt = $db->prepare("INSERT INTO survey_documents (survey_customer_id, doc_type, file_path, original_name) VALUES (?, ?, ?, ?)");
                        $stmt->execute([$id, $docType, $upload['path'], $upload['original_name']]);
                    }
                } else {
                    throw new Exception("Failed to upload {$docType}: " . $upload['error']);
                }
            }
        }

        // 4. Update Wallet Transaction back to pending
        $stmt = $db->prepare("UPDATE wallet_transactions SET status = 'pending', description = ? WHERE user_id = ? AND ref_type = 'survey' AND ref_id = ?");
        $stmt->execute(["Survey incentive for customer: {$name} (Resubmitted)", $userId, $id]);

        $db->commit();
        setFlash('success', 'Survey resubmitted successfully.');
        redirect(site_url('public/surveyer/my-customers.php'));

    } catch (Exception $e) {
        $db->rollBack();
        setFlash('danger', 'Error: ' . $e->getMessage());
        redirect(site_url("public/surveyer/edit-customer.php?id={$id}"));
    }
} else {
    redirect(site_url('public/surveyer/dashboard.php'));
}
