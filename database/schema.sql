-- DMS Customer & Incentive Management System Schema

-- Users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employee_id VARCHAR(20) UNIQUE,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('surveyer', 'dm', 'pe', 'staff', 'admin', 'director', 'office_staff') NOT NULL,
    phone VARCHAR(20),
    profile_pic VARCHAR(255),
    bank_name VARCHAR(150),
    account_holder_name VARCHAR(150),
    account_number VARCHAR(50),
    ifsc_code VARCHAR(20),
    upi_id VARCHAR(100),
    address TEXT,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Survey Customers table
CREATE TABLE IF NOT EXISTS survey_customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    surveyer_id INT NOT NULL,
    name VARCHAR(150) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    consumer_number VARCHAR(100),
    age_dob VARCHAR(50),
    gender VARCHAR(20),
    email VARCHAR(150),
    occupation VARCHAR(100),
    address TEXT NOT NULL,
    house_type ENUM('Building', 'Assam Model', 'Kutcha House'),
    property_type VARCHAR(100),
    property_area VARCHAR(100),
    customer_opinion ENUM('Interested', 'Not Interested'),
    electricity_bill_amount VARCHAR(50),
    meter_type ENUM('Owned', 'Rented'),
    land_type ENUM('Owned', 'Rented'),
    annual_income VARCHAR(100),
    notes TEXT,
    status ENUM('pending', 'approved', 'rejected', 'revert_back') DEFAULT 'pending',
    rejection_reason TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (surveyer_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Survey Documents table
CREATE TABLE IF NOT EXISTS survey_documents (
    id INT AUTO_INCREMENT PRIMARY KEY,
    survey_customer_id INT NOT NULL,
    doc_type ENUM('bank_passbook', 'aadhaar', 'pan', 'electricity_bill', 'signature', 'gps_photo', 'house_photo') NOT NULL,
    file_path VARCHAR(500) NOT NULL,
    original_name VARCHAR(255) NOT NULL,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (survey_customer_id) REFERENCES survey_customers(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Technical Customers table
CREATE TABLE IF NOT EXISTS technical_customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    dm_id INT NOT NULL,
    name VARCHAR(150) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    address TEXT NOT NULL,
    survey_number VARCHAR(100),
    plot_area VARCHAR(100),
    road_width VARCHAR(100),
    zone VARCHAR(100),
    remarks TEXT,
    status VARCHAR(100) DEFAULT 'APPLICATION',
    bank_details VARCHAR(255) NULL,
    sanction_amount DECIMAL(10, 2) NULL,
    disbursement_1_amount DECIMAL(10, 2) NULL,
    disbursement_1_date DATE NULL,
    disbursement_1_remarks TEXT NULL,
    payment_amount DECIMAL(10, 2) NULL,
    payment_receipt VARCHAR(255) NULL,
    disbursement_2_amount DECIMAL(10, 2) NULL,
    disbursement_2_date DATE NULL,
    disbursement_2_remarks TEXT NULL,
    customer_feedback TEXT NULL,
    rejection_reason TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (dm_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Technical Documents table
CREATE TABLE IF NOT EXISTS technical_documents (
    id INT AUTO_INCREMENT PRIMARY KEY,
    technical_customer_id INT NOT NULL,
    doc_type VARCHAR(100) NOT NULL,
    file_path VARCHAR(500) NOT NULL,
    original_name VARCHAR(255) NOT NULL,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (technical_customer_id) REFERENCES technical_customers(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Wallets table
CREATE TABLE IF NOT EXISTS wallets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNIQUE NOT NULL,
    balance DECIMAL(10, 2) DEFAULT 0.00,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Wallet Transactions table
CREATE TABLE IF NOT EXISTS wallet_transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    ref_type ENUM('survey', 'technical') NOT NULL,
    ref_id INT NOT NULL,
    type ENUM('credit', 'debit') NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    description VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Withdrawal Requests table
CREATE TABLE IF NOT EXISTS withdrawal_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    upi_or_account VARCHAR(200) NOT NULL,
    status ENUM('pending', 'paid', 'rejected') DEFAULT 'pending',
    admin_note TEXT,
    requested_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    resolved_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Salary & Advance Disbursements table
CREATE TABLE IF NOT EXISTS salary_disbursements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    admin_id INT NOT NULL,
    user_id INT NOT NULL,
    type ENUM('salary', 'advance') NOT NULL DEFAULT 'salary',
    amount DECIMAL(10, 2) NOT NULL,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (admin_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Seed Admin User (password is 'admin123' - bcrypt hashed)
INSERT INTO users (name, email, password, role, phone) 
VALUES ('Admin', 'admin@dms.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', '1234567890');

-- Create wallet for admin
INSERT INTO wallets (user_id, balance) VALUES (1, 0.00);
