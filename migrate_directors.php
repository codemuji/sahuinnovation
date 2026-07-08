<?php
/**
 * Database Migration for Director Panel
 */
require_once __DIR__ . '/app/config/database.php';

try {
    $db = Database::getInstance()->getConnection();
    
    $queries = [
        // 1. Extend user roles
        "ALTER TABLE users MODIFY COLUMN role ENUM('surveyer', 'dm', 'pe', 'staff', 'admin', 'director') NOT NULL",

        // 2. Create fund_allocations table
        "CREATE TABLE IF NOT EXISTS fund_allocations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            admin_id INT NOT NULL,
            director_id INT NOT NULL,
            amount DECIMAL(10, 2) NOT NULL,
            notes TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (admin_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (director_id) REFERENCES users(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

        // 3. Create fund_usages table
        "CREATE TABLE IF NOT EXISTS fund_usages (
            id INT AUTO_INCREMENT PRIMARY KEY,
            director_id INT NOT NULL,
            amount DECIMAL(10, 2) NOT NULL,
            purpose VARCHAR(150) NOT NULL,
            description TEXT,
            payment_proof VARCHAR(255),
            status ENUM('pending', 'approved', 'revert_back') DEFAULT 'pending',
            admin_note TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            resolved_at TIMESTAMP NULL,
            FOREIGN KEY (director_id) REFERENCES users(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

        // 4. Extend wallet_transactions references
        "ALTER TABLE wallet_transactions MODIFY COLUMN ref_type ENUM('survey', 'technical', 'withdrawal', 'fund_allocation', 'fund_usage') NOT NULL"
    ];

    foreach ($queries as $query) {
        try {
            $db->exec($query);
            echo "Executed: " . substr($query, 0, 80) . "...\n";
        } catch (PDOException $e) {
            echo "Error executing query: " . $e->getMessage() . "\n";
        }
    }
    
    echo "Migration completed.\n";
} catch (Exception $e) {
    echo "Connection error: " . $e->getMessage() . "\n";
}
