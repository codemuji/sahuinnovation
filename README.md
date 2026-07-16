# Sahu Innovation Pvt. Ltd. — Customer & Incentive Management System (DMS)

A premium, role-based platform designed to coordinate clean energy surveying, technical site profiling, 11-stage PM Surya Ghar project progression, and streamlined field-incentive payouts for modern solar solutions.

---

## 📖 Table of Contents
1. [Portfolio & Resume Highlights](#-portfolio--resume-highlights)
2. [Overview & Project Workflow](#-overview--project-workflow)
3. [The 11-Stage PM Surya Ghar Pipeline](#-the-11-stage-pm-surya-ghar-pipeline)
4. [Role-Based Workspaces & Responsibilities](#-role-based-workspaces--responsibilities)
5. [Incentive & Payout Architecture](#-incentive--payout-architecture)
6. [Key Features & Aesthetics](#-key-features--aesthetics)
7. [Technical Architecture](#-technical-architecture)
8. [Directory Structure](#-directory-structure)
9. [Installation & Setup](#-installation--setup)
10. [License](#-license)

---

## 💼 Portfolio & Resume Highlights

* **Project Type:** Enterprise Role-Based Demand/Incentive Management System (DMS), 11-Stage Workflow Engine & Financial Portal.
* **Complexity Level:** Intermediate to Advanced (multi-role workflow enforcement, stage-locked state transitions, financial transaction consistency, and dynamic document verification).
* **Core Engineering Accomplishments:**
  * **Stage-Locked Workflow Progression:** Built an 11-stage state pipeline (`APPLICATION` through `CUSTOMER FEEDBACK`) enforcing role separation—where Staff progresses site verification stages while the Managing Director/Admin exclusively controls financial disbursement checkpoints.
  * **Direct Ledger Credit Engine:** Streamlined incentive distribution by eliminating intermediary wallet withdrawal friction; approvals at Stage 5 (`DM/Agent Payment`) directly credit the agent's Total Received balance and record permanent audit trails.
  * **Role-Based Workspaces & Dynamic ID Cards:** Designed secure multi-role dashboards (Managing Director/Admin, Staff, District Manager, Project Executive, Field Surveyor) with public QR-code employee identity verification (`html2canvas`, `jsPDF`).
  * **Transactional Concurrency Safety:** Guaranteed atomic financial records (`INSERT ... ON DUPLICATE KEY UPDATE` and transactional locking) to prevent ledger discrepancies and double-crediting.

---

## 🌟 Overview & Project Workflow

The **Sahu Innovation DMS** streamlines solar energy installations under national initiatives like the **PM Surya Ghar** scheme. The workflow connects lead capture, site surveys, technical evaluation, banking verification, subsidy disbursement, and direct agent payouts into a unified digital ecosystem.

### End-to-End Operational Flow
1. **Consumer & Survey Capture:** Field Surveyors and DMs capture initial consumer utility data, roof specifications, and documents via mobile/desktop panels.
2. **Staff Review & Pipeline Induction:** Internal Staff reviews application completeness and advances approved consumers into the technical project pipeline.
3. **Multi-Stage Execution:** Applications move systematically through banking verification, loan disbursement, installation, and APDCL activation.
4. **Stage 5 Payout Milestone:** Once an application crosses **Stage 4 (Loan Disbursement)**, it enters the Managing Director's exclusive payout queue. The Managing Director records the Stage 5 payment (with optional receipt proof upload), immediately crediting the DM/PE agent's payout history without requiring manual withdrawal requests.
5. **Project Completion:** Applications progress through subsidy disbursement and conclude at **Stage 11 (Customer Feedback)**.

---

## ⚡ The 11-Stage PM Surya Ghar Pipeline

Every technical application progresses through an 11-stage milestone tracker with color-coded visual cues (**Orange** while in progress up to Stage 10; **Green** only after successfully completing all 11 stages):

| Stage # | Stage Name | Managing Role | Milestone Description |
| :---: | :--- | :---: | :--- |
| **1** | **APPLICATION** | Staff / DM | Initial registration and documentation check. |
| **2** | **APPLY ON OFFICIAL SITE** | Staff | Submission to the national portal (`pmsuryaghar.gov.in`). |
| **3** | **LOAN PROCESS TO BANK** | Staff | Forwarding application file and sanction details to bank. |
| **4** | **LOAN DISBURSEMENT** | Staff | Bank releases 1st tranche loan sanction (`disbursement_1_amount`). |
| **5** | **DM/AGENT PAYMENT** | **Managing Director** | **Financial Checkpoint:** Managing Director inputs payout amount, remarks, and optional payment receipt to credit the agent. |
| **6** | **INSTALLATION** | Staff | Physical solar structure mounting and inverter setup. |
| **7** | **ACTIVATION BY APDCL** | Staff | Grid inspection and net-metering commissioning by APDCL. |
| **8** | **SUBSIDY REQUEST** | Staff | Filing official government subsidy claim after activation. |
| **9** | **SUBSIDY DISBURSEMENT** | Staff | Government transfers subsidy directly to consumer bank account. |
| **10** | **LOAN 2ND DISBURSEMENT** | Staff | Bank releases final loan tranche (`disbursement_2_amount`). |
| **11** | **CUSTOMER FEEDBACK** | Staff | Final project sign-off and customer satisfaction review (**Status turns Green**). |

---

## 👥 Role-Based Workspaces & Responsibilities

* **Managing Director / Admin:**
  * System-wide overview, user management, and annual budget reports.
  * **Exclusive Stage 5 Payout Control:** Processes agent payments after Stage 4 (`disburse-salary.php`, `stage5-payouts.php`).
  * Expense Management, fund allocation, salary/advance issuance, and director-wise reporting.
* **Staff Panel:**
  * Application review for incoming surveys and technical submissions.
  * Advances customer applications across pipeline stages (1-4 and 6-11), logging disbursement dates, remarks, and status updates.
* **DM / PE (District Manager & Project Executive):**
  * Adds and manages consumers (`add-customer.php`).
  * Views real-time pipeline progression of their applications.
  * **Payouts History:** Directly tracks **Total Received Amount** credited from Stage 5 approvals along with a complete transaction ledger (no withdrawal forms needed).
* **Surveyor Panel:**
  * Mobile-optimized interface for quick door-to-door solar site surveys.
  * Generates and downloads official employee ID cards with live QR verification.

---

## 💰 Incentive & Payout Architecture

To ensure speed and zero accounting friction, the system utilizes a **Direct Credit Payout Model**:
1. **No Pending Wallets / Withdrawal Friction:** Agents do not need to submit withdrawal requests or wait for separate approval cycles.
2. **Automated Stage 5 Crediting:** When the Managing Director records a payout at Stage 5 (`DM/Agent Payment`), the transaction is immediately recorded with status `'approved'` and type `'credit'`.
3. **Transparent Ledgers:** Agents view their cumulative earnings (`Total Received Amount`) and line-by-line payout history linked directly to consumer names and stage approvals.

---

## 🚀 Key Features & Aesthetics

* **Curated Visual System:** Built with modern CSS custom properties, responsive desktop grids, and clean mobile cards.
* **Visual Status Badges:** Status pills and stage indicators dynamically highlight project health (Orange/Warning while underway, Green/Success on Step 11 completion, Red/Danger on rejection).
* **Secure Document & Receipt Handling:** Optional file uploads (payment receipts, survey photos, ID proofs) served and validated through strict backend proxies.
* **Dynamic ID Card & QR Verification:** Public verification portal (`verify.php`) allowing customers to scan and confirm agent identities instantly.

---

## 🛠 Technical Architecture

* **Backend:** PHP 8.x (Procedural action handlers + OOP core structure, PDO database abstraction).
* **Database:** MySQL 8.x (Relational schema with foreign keys linking users, customers, wallet transactions, and fund usages).
* **Frontend:** Vanilla HTML5, CSS3 Custom Properties (Design system tokens), ES6 JavaScript, `html2canvas`, and `jsPDF`.
* **Security:** Prepared statements (PDO) against SQL injection, `bcrypt` password hashing, and role-enforcement middleware (`Auth::requireRole`).

---

## 📁 Directory Structure

```text
├── app/                       # Backend Application logic
│   ├── actions/               # Endpoint controllers (login, stage advances, stage 5 payouts, rejections)
│   ├── config/                # Database singleton (`Database.php`)
│   └── core/                  # Authentication (`Auth.php`) & helper functions
├── database/                  # MySQL schema migrations (`schema.sql`)
├── public/                    # Web Root
│   ├── admin/                 # Managing Director panel (Stage 5 payouts, user & expense management)
│   ├── assets/                # Modular CSS (`main.css`, `desktop.css`), JS, & icons
│   ├── director/              # Director reporting & profile views
│   ├── dm/                    # DM/PE consumer management & Payouts History
│   ├── includes/              # Unified navigation sidebar & topbar (`header.php`, `footer.php`)
│   ├── staff/                 # Staff review & 11-stage pipeline tracking
│   ├── surveyer/              # Mobile field surveyor panel
│   ├── verify.php             # Public employee QR verification page
│   └── index.php              # Landing & portal entry
└── uploads/                   # Secured directory storing user & payment receipts
```

---

## ⚙️ Installation & Setup

1. **Clone the Repository:**
   ```bash
   git clone https://github.com/codemuji/sahuinnovation.git
   cd sahuinnovation
   ```

2. **Database Configuration:**
   * Import the database schema from `database/schema.sql` into your MySQL instance.
   * Open `app/config/database.php` and configure your credentials:
     ```php
     private $host = 'localhost';
     private $user = 'your_username';
     private $pass = 'your_password';
     private $dbname = 'sahuinnovation_dms';
     ```

3. **Server Settings:**
   * Ensure `uploads/` is writeable by the web server (`chmod 755` or equivalent).
   * Host using Apache/Nginx or XAMPP (`c:\xampp\htdocs\sahuinnovation`).

4. **Default Login:**
   * **URL:** `http://localhost/sahuinnovation/public/login.php`
   * **Managing Director (Admin):** `admin@dms.com` / `admin123`

---

## 📄 License
This project is proprietary software developed for **Sahu Innovation Pvt. Ltd.** All rights reserved.
