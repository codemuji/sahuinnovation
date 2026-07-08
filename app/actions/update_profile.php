<?php
/**
 * Update Profile Action
 */

require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../config/database.php';

Auth::requireRole(['surveyer', 'dm', 'pe', 'staff', 'admin']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = Database::getInstance()->getConnection();
    $userId = Auth::userId();

    // Text Data
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $address = trim($_POST['address'] ?? '');
    
    // Bank Data
    $bank_name = trim($_POST['bank_name'] ?? '');
    $account_holder_name = trim($_POST['account_holder_name'] ?? '');
    $account_number = trim($_POST['account_number'] ?? '');
    $ifsc_code = trim($_POST['ifsc_code'] ?? '');
    $upi_id = trim($_POST['upi_id'] ?? '');

    if (empty($name) || empty($email)) {
        setFlash('danger', 'Name and Email are required.');
        redirect(site_url('public/'.Auth::userRole().'/profile.php'));
    }

    try {
        $db->beginTransaction();

        // 1. Handle Profile Picture Upload
        $profilePic = null;
        if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {
            $targetDir = __DIR__ . '/../../uploads/profile_pics/';
            $upload = uploadFile($_FILES['profile_pic'], $targetDir, ['jpg', 'jpeg', 'png']);
            
            if (isset($upload['success'])) {
                $profilePic = $upload['path'];
                
                // Optional: Delete old profile pic if exists
                $stmt = $db->prepare("SELECT profile_pic FROM users WHERE id = ?");
                $stmt->execute([$userId]);
                $oldPic = $stmt->fetchColumn();
                if ($oldPic && file_exists($targetDir . $oldPic)) {
                    unlink($targetDir . $oldPic);
                }
            } else {
                throw new Exception("Profile picture upload failed: " . $upload['error']);
            }
        }

        // 2. Update User Record
        $sql = "UPDATE users SET name = ?, email = ?, phone = ?, address = ?, bank_name = ?, account_holder_name = ?, account_number = ?, ifsc_code = ?, upi_id = ?";
        $params = [$name, $email, $phone, $address, $bank_name, $account_holder_name, $account_number, $ifsc_code, $upi_id];
        
        if ($profilePic) {
            $sql .= ", profile_pic = ?";
            $params[] = $profilePic;
        }
        
        $sql .= " WHERE id = ?";
        $params[] = $userId;
        
        $stmt = $db->prepare($sql);
        $stmt->execute($params);

        $db->commit();
        
        // Refresh session data if name/role/email changed
        $_SESSION['user']['name'] = $name;
        $_SESSION['user']['email'] = $email;
        if ($profilePic) $_SESSION['user']['profile_pic'] = $profilePic;

        setFlash('success', 'Profile updated successfully.');
        redirect(site_url('public/'.Auth::userRole().'/profile.php'));

    } catch (Exception $e) {
        $db->rollBack();
        setFlash('danger', 'Error: ' . $e->getMessage());
        redirect(site_url('public/'.Auth::userRole().'/profile.php'));
    }
} else {
    redirect(site_url('public/dashboard.php'));
}
