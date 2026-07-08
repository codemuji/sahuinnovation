<?php
/**
 * Add Survey Customer Action
 */

require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../config/database.php';

Auth::requireRole('surveyer');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = Database::getInstance()->getConnection();
    $userId = Auth::userId();

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
    
    // Legacy fields (optional now or defaulted)
    $property_type = $_POST['property_type'] ?? '';
    $property_area = trim($_POST['property_area'] ?? '');
    $notes = trim($_POST['notes'] ?? '');

    if (empty($name) || empty($phone) || empty($address) || empty($district) || empty($occupation) || empty($post_office) || empty($police_station) || empty($house_type) || empty($customer_opinion) || empty($electricity_bill_amount) || empty($land_type) || empty($annual_income)) {
        setFlash('danger', 'Please fill in all required fields.');
        redirect(site_url('public/surveyer/add-customer.php'));
    }

    try {
        $db->beginTransaction();

        // 1. Insert Customer
        $stmt = $db->prepare("INSERT INTO survey_customers 
            (surveyer_id, name, phone, consumer_number, age_dob, gender, email, occupation, district, post_office, police_station, state, address, house_type, property_type, property_area, customer_opinion, electricity_bill_amount, meter_type, land_type, annual_income, notes, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending')");
        
        $stmt->execute([
            $userId, $name, $phone, $consumer_number, $age_dob, $gender, $email, $occupation, $district, $post_office, $police_station, $state, $address, $house_type, $property_type, $property_area, $customer_opinion, $electricity_bill_amount, $meter_type, $land_type, $annual_income, $notes
        ]);
        
        $customerId = $db->lastInsertId();

        // 2. Handle Document Uploads
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
        if (!is_dir($targetDir)) mkdir($targetDir, 0755, true);

        // iOS Safari fallback: GPS photo sent as base64 when DataTransfer API is unsupported
        $gpsB64 = trim($_POST['doc_gps_photo_b64'] ?? '');
        if (!empty($gpsB64) && 
            (!isset($_FILES['doc_gps_photo']) || $_FILES['doc_gps_photo']['error'] !== UPLOAD_ERR_OK)) {
            // Strip the data URI prefix: "data:image/jpeg;base64,..."
            if (preg_match('/^data:image\/(jpeg|png|jpg|webp);base64,(.+)$/i', $gpsB64, $matches)) {
                $imageData = base64_decode($matches[2]);
                if ($imageData !== false) {
                    $ext      = strtolower($matches[1]) === 'png' ? 'png' : 'jpg';
                    $fileName = 'gps_' . uniqid() . '_' . time() . '.' . $ext;
                    $filePath = $targetDir . $fileName;
                    if (file_put_contents($filePath, $imageData) !== false) {
                        $relPath = 'uploads/survey_docs/' . $fileName;
                        $stmt = $db->prepare("INSERT INTO survey_documents (survey_customer_id, doc_type, file_path, original_name) VALUES (?, ?, ?, ?)");
                        $stmt->execute([$customerId, 'gps_photo', $relPath, $fileName]);
                        // Remove from docs array so we don't try to upload it again below
                        unset($docs['doc_gps_photo']);
                    }
                }
            }
        }

        foreach ($docs as $inputName => $docType) {
            if (isset($_FILES[$inputName]) && $_FILES[$inputName]['error'] === UPLOAD_ERR_OK) {
                $upload = uploadFile($_FILES[$inputName], $targetDir);
                
                if (isset($upload['success'])) {
                    $stmt = $db->prepare("INSERT INTO survey_documents (survey_customer_id, doc_type, file_path, original_name) VALUES (?, ?, ?, ?)");
                    $stmt->execute([$customerId, $docType, $upload['path'], $upload['original_name']]);
                } else {
                    throw new Exception("Failed to upload {$docType}: " . $upload['error']);
                }
            } else {
                // For legacy documents, we check if they are required. GPS and House photo are new and might be optional for now in the code but let's check.
                // In the form, I didn't mark them as 'required' explicitly for all, but let's keep consistency.
                // Documents are optional
                if (in_array($inputName, ['doc_bank_passbook', 'doc_aadhaar', 'doc_pan', 'doc_electricity_bill', 'doc_signature'])) {
                     // Do nothing, they are optional
                }
            }
        }

        // 3. Create Pending Wallet Transaction
        $stmt = $db->prepare("INSERT INTO wallet_transactions (user_id, ref_type, ref_id, type, amount, status, description) VALUES (?, 'survey', ?, 'credit', 30.00, 'pending', ?)");
        $stmt->execute([$userId, $customerId, "Survey incentive for customer: {$name}"]);

        $db->commit();
        setFlash('success', 'Survey data and documents submitted successfully.');
        redirect(site_url('public/surveyer/dashboard.php'));

    } catch (Exception $e) {
        $db->rollBack();
        setFlash('danger', 'Error: ' . $e->getMessage());
        redirect(site_url('public/surveyer/add-customer.php'));
    }
} else {
    redirect(site_url('public/surveyer/dashboard.php'));
}
