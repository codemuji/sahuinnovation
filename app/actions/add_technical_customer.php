<?php
/**
 * Add Technical Customer Action
 */

require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../config/database.php';

Auth::requireRole(['dm', 'pe']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = Database::getInstance()->getConnection();
    $userId = Auth::userId();
    $role = Auth::userRole();

    // Incentive amount based on role
    $incentiveAmount = ($role === 'dm') ? 20000.00 : 15000.00;

    // Consumer Information
    $name = trim($_POST['name'] ?? '');
    $consumer_number = trim($_POST['consumer_number'] ?? '');
    $dob = trim($_POST['dob'] ?? '');
    $gender = trim($_POST['gender'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $occupation = trim($_POST['occupation'] ?? '');
    $state = trim($_POST['state'] ?? '');
    $district = trim($_POST['district'] ?? '');
    $post_office = trim($_POST['post_office'] ?? '');
    $police_station = trim($_POST['police_station'] ?? '');
    $electrical_subdivision = trim($_POST['electrical_subdivision'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $house_type = trim($_POST['house_type'] ?? '');
    $meter_type = trim($_POST['meter_type'] ?? '');
    $annual_income = trim($_POST['annual_income'] ?? '');

    // Technical Details
    $survey_number = trim($_POST['survey_number'] ?? '');
    $plot_area = trim($_POST['plot_area'] ?? '');
    $road_width = trim($_POST['road_width'] ?? '');
    $zone = trim($_POST['zone'] ?? '');
    $remarks = trim($_POST['remarks'] ?? '');

    // Basic Validation
    if (empty($name) || empty($phone) || empty($occupation) || empty($address) || empty($state) || empty($district) || empty($post_office) || empty($police_station) || empty($electrical_subdivision)) {
        setFlash('danger', 'Please fill in all mandatory consumer fields (Name, Phone, Occupation, Address, District, Post Office, Police Station, State, Subdivision).');
        redirect(site_url('public/dm/add-customer.php'));
    }

    try {
        $db->beginTransaction();

        // 1. Insert Customer
        $sql = "INSERT INTO technical_customers (
            dm_id, name, consumer_number, dob, gender, phone, email, occupation, 
            state, district, post_office, police_station, electrical_subdivision, address, house_type, 
            meter_type, annual_income, survey_number, plot_area, road_width, 
            zone, remarks, status
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'APPLICATION')";
        
        $stmt = $db->prepare($sql);
        $stmt->execute([
            $userId, $name, $consumer_number, $dob, $gender, $phone, $email, $occupation,
            $state, $district, $post_office, $police_station, $electrical_subdivision, $address, $house_type,
            $meter_type, $annual_income, $survey_number, $plot_area, $road_width,
            $zone, $remarks
        ]);
        $customerId = $db->lastInsertId();

        // 2. Handle Document Uploads
        $targetDir = __DIR__ . '/../../uploads/technical_docs/';
        
        // Required Documents Mapping
        $requiredDocs = [
            'doc_aadhaar' => 'Aadhaar Card',
            'doc_pan' => 'Pan Card',
            'doc_bank_passbook' => 'Bank Passbook',
            'doc_electricity_bill' => 'Electricity Bill',
            'doc_signature' => 'Signature'
        ];

        foreach ($requiredDocs as $inputName => $docType) {
            if (!isset($_FILES[$inputName]) || $_FILES[$inputName]['error'] !== UPLOAD_ERR_OK) {
                throw new Exception("Missing required document: {$docType}");
            }
            
            $upload = uploadFile($_FILES[$inputName], $targetDir);
            if (isset($upload['success'])) {
                $stmt = $db->prepare("INSERT INTO technical_documents (technical_customer_id, doc_type, file_path, original_name) VALUES (?, ?, ?, ?)");
                $stmt->execute([$customerId, $docType, $upload['path'], $upload['original_name']]);
            } else {
                throw new Exception("Failed to upload {$docType}: " . $upload['error']);
            }
        }

        // Land Ownership Document
        $landDocType = $_POST['land_ownership_type'] ?? '';
        if (empty($landDocType) || !isset($_FILES['doc_land_ownership']) || $_FILES['doc_land_ownership']['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("Please select and upload a Land Ownership document.");
        }

        $upload = uploadFile($_FILES['doc_land_ownership'], $targetDir);
        if (isset($upload['success'])) {
            $stmt = $db->prepare("INSERT INTO technical_documents (technical_customer_id, doc_type, file_path, original_name) VALUES (?, ?, ?, ?)");
            $stmt->execute([$customerId, $landDocType, $upload['path'], $upload['original_name']]);
        } else {
            throw new Exception("Failed to upload Land Ownership document: " . $upload['error']);
        }

        // 3. Create Pending Wallet Transaction (amount set to 0.00 until Admin sets manual payment during DM/AGENT PAYMENT status)
        $stmt = $db->prepare("INSERT INTO wallet_transactions (user_id, ref_type, ref_id, type, amount, status, description) VALUES (?, 'technical', ?, 'credit', 0.00, 'pending', ?)");
        $stmt->execute([$userId, $customerId, "Technical incentive for customer: {$name} (Consumer #: {$consumer_number}) - Awaiting Admin Payment"]);

        $db->commit();
        setFlash('success', 'Technical data and documents submitted successfully.');
        redirect(site_url('public/dm/dashboard.php'));

    } catch (Exception $e) {
        $db->rollBack();
        setFlash('danger', 'Error: ' . $e->getMessage());
        redirect(site_url('public/dm/add-customer.php'));
    }
} else {
    redirect(site_url('public/dm/dashboard.php'));
}
