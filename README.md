# Sahu Innovation Pvt. Ltd. — Customer & Incentive Management System (DMS)

A premium, role-based platform designed to coordinate clean energy surveying, technical site profiling, and field-incentive distribution for modern solar solutions.

---

## 📖 Table of Contents
1. [Overview](#-overview)
2. [The Problem It Solves](#-the-problem-it-solves)
3. [Impact on the Work Field](#-impact-on-the-work-field)
4. [Key Features](#-key-features)
5. [Technical Architecture](#-technical-architecture)
6. [Directory Structure](#-directory-structure)
7. [Installation & Setup](#-installation--setup)
8. [License](#-license)

---

## 🌟 Overview

The **DMS (Development/Demand Management System)** is a lightweight, high-performance web portal built to scale solar energy installations under national initiatives like the **PM Surya Ghar** scheme. 

The application streamlines the collection of consumer utilities data and technical site parameters, while motivating field teams through transparent, real-time financial incentives managed via an internal wallet ledger.

---

## ⚡ The Problem It Solves

### 1. Paper-Heavy and Fragmented Field Audits
Traditional solar installation leads rely on paper forms, photos sent over messaging apps, and manual ledger entries. This platform digitizes the process, enforcing data completion and document uploads directly from the field.

### 2. Trust and Security in Door-to-Door Field Work
Homeowners are hesitant to share sensitive documents (e.g. Aadhaar cards, bank details, electricity bills) with visiting agents. By implementing a **Digital ID Card with live QR verification**, homeowners can scan the agent's ID to instantly verify their credentials on the company’s official website without logging in.

### 3. Agent Motivation & Retention
Field surveyors and technical estimators are often compensated through opaque, delayed bonus systems. The platform tracks submissions and links them to instant incentives (e.g. ₹30 for basic surveys, up to ₹20,000 for complex technical site plans). Approved leads immediately credit the agent's wallet, allowing transparent withdrawal tracking.

### 4. Admin and Financial Audit Overhead
Processing hundreds of individual incentive payments manually creates significant accounting bottlenecks. This platform centralizes withdrawal requests and allows admins to pay in batches, upload payout receipts, and keep a clean ledger for end-of-year tax audits.

---

## 📈 Impact on the Work Field

* **Accelerated Solar Deployment:** Minimizing the cycle time from field survey to technical design, allowing engineering teams to get accurate layout metrics faster.
* **Higher Data Accuracy:** Review steps by internal staff ensure that utility numbers, roof types, and meter categories are correct before sending proposals to customers.
* **Professional Agency Representation:** Empowers agents with professional tools (like downloadable PDFs of their ID cards) that elevate company branding and consumer trust.
* **Developer Accountability:** Clear segregation of duties between DMs (District Managers), PEs (Project Executives), and surveyors makes it easy to spot bottlenecks in lead pipelines.

---

## 🚀 Key Features

* **Role-Based Workspaces:** Dedicated interfaces for Admins, Staff, DMs, PEs, and Surveyors.
* **Responsive Layout Modes:** 
  * *Desktop Layout:* Rich tabular controls, visual status highlights, and analytics widgets for administrators and reviewers.
  * *Mobile Layout:* Bottom tab navigation and thumb-optimized forms for field agents working on mobile web browsers.
* **Dynamic ID Card Generator:** Instantly renders high-definition profile cards using `html2canvas` and `jsPDF` for PDF/PNG exports.
* **Integrated Wallet Ledger:** Real-time ledger records credits (earned incentives) and debits (withdrawn funds) linked directly to validated customer IDs.
* **Secure Document Proxy:** System uploads are stored securely and proxied via script checks, defending files against direct URL discovery or traversal attacks.

---

## 🛠 Technical Architecture

* **Backend:** PHP 8.x (Procedural action handlers + OOP core architecture).
* **Database:** MySQL 8.x (Relational schema enforcing foreign key cascades for wallets, transactions, and documents).
* **Frontend:** Vanilla HTML5, CSS3 Custom Properties (Design system variables), and ES6 JavaScript.
* **Security:** 
  * Prepared statements (PDO) to protect against SQL Injection.
  * Cryptographic password storage using `bcrypt`.
  * `realpath()` verification for file-serving isolation.

---

## 📁 Directory Structure

```text
├── app/                       # Backend Application logic
│   ├── actions/               # Endpoint controllers (login, additions, approvals, payouts)
│   ├── config/                # Database class using PDO singleton patterns
│   └── core/                  # Middleware (Auth and helpers)
├── database/                  # Schema setups & migrations
├── public/                    # Root folder exposed to the web
│   ├── admin/                 # Admin operations and payout clearances
│   ├── assets/                # Modular CSS styles, client-side JS, logos
│   ├── dm/                    # District Manager panels (technical inputs)
│   ├── includes/              # Common headers/footers for panels and landing pages
│   ├── staff/                 # Internal Staff survey review panels
│   ├── surveyer/              # Field Surveyor mobile actions
│   ├── verify.php             # Public employee QR verification page
│   └── index.php              # Public Landing page
└── uploads/                   # Secured directory storing user uploads
```

---

## ⚙️ Installation & Setup

1. **Clone the Repository:**
   ```bash
   git clone https://github.com/codemuji/sahuinnovation.git
   cd sahuinnovation
   ```

2. **Database Configuration:**
   * Import the database schema from `database/schema.sql` into your MySQL server.
   * Open `app/config/database.php` and set your credentials:
     ```php
     private $host = 'localhost';
     private $user = 'your_username';
     private $pass = 'your_password';
     private $dbname = 'sahuinnovation_dms';
     ```

3. **Apache Settings:**
   * Make sure `uploads/` folder is writeable by the server (`chmod 755` or equivalent).
   * Host the project using a local stack like XAMPP or Nginx.

4. **Default Admin Login:**
   * **URL:** `http://localhost/sahuinnovation/public/login.php`
   * **Email:** `admin@dms.com`
   * **Password:** `admin123`

---

## 📄 License
This project is proprietary software developed for Sahu Innovation Pvt. Ltd. All rights reserved.
