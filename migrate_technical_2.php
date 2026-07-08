<?php
require_once __DIR__ . '/app/config/database.php';

try {
    $db = Database::getInstance()->getConnection();
    
    $queries = [
        "ALTER TABLE technical_customers ADD COLUMN post_office VARCHAR(150) AFTER district",
        "ALTER TABLE technical_customers ADD COLUMN police_station VARCHAR(150) AFTER post_office"
    ];

    foreach ($queries as $query) {
        try {
            $db->exec($query);
            echo "Executed: $query\n";
        } catch (PDOException $e) {
            echo "Error executing $query: " . $e->getMessage() . "\n";
        }
    }
    
    echo "Migration completed.\n";
} catch (Exception $e) {
    echo "Connection error: " . $e->getMessage() . "\n";
}
