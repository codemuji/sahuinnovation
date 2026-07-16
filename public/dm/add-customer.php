<?php
require_once __DIR__ . '/../../app/core/Auth.php';
Auth::requireRole(['dm', 'pe']);

$docTypes = [
    'Allottee Letter', 'Partition Deed', 'Mutation Certificate', 'Share Certificate with NOC',
    'Flat Allotment Letter', 'Occupancy Certificate', 'Letter of Possession', 'NOC from Society',
    'Property Tax Receipt', 'Panchayat Letter', 'Land Records', 'Land Possession Certificate',
    'Copy of Sale Deed', 'Lease Deed', 'Government Grant / Allotment related documents'
];

$pageTitle = "Add Technical Customer";
include __DIR__ . '/../includes/header.php';
?>

<div class="panel-header">
    <div class="panel-title">
        <h1>Add Consumer</h1>
        <p>Enter comprehensive consumer and technical data and upload required documents.</p>
    </div>
    <a href="dashboard.php" class="btn" style="width: auto; background: var(--border); color: var(--text-main);">
        <i class="fa fa-arrow-left" style="margin-right: 8px;"></i> Back
    </a>
</div>

<form action="<?= site_url('app/actions/add_technical_customer.php') ?>" method="POST" enctype="multipart/form-data">
    <div class="grid grid-2" style="align-items: start;">
        <!-- Left Column: Consumer & Technical Information -->
        <div class="desktop-card">
            <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 24px; color: var(--primary);">1. Consumer Information</h3>
            
            <div class="grid grid-2">
                <div class="form-group">
                    <label class="form-label">1. Consumer Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">2. Consumer Number</label>
                    <input type="text" name="consumer_number" class="form-control">
                </div>
            </div>

            <div class="grid grid-2">
                <div class="form-group">
                    <label class="form-label">3. Date Of Birth</label>
                    <input type="date" name="dob" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">4. Gender</label>
                    <select name="gender" class="form-control" required>
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-2">
                <div class="form-group">
                    <label class="form-label">5. Mobile Number</label>
                    <input type="tel" name="phone" class="form-control" required pattern="[0-9]{10}">
                </div>
                <div class="form-group">
                    <label class="form-label">6. Email ID</label>
                    <input type="email" name="email" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">7. Occupation</label>
                <input type="text" name="occupation" class="form-control" required>
            </div>

            <div class="grid grid-2">
                <div class="form-group">
                    <label class="form-label">8. State</label>
                    <input type="text" name="state" class="form-control" value="Assam" required>
                </div>
                <div class="form-group">
                    <label class="form-label">9. District</label>
                    <input type="text" name="district" class="form-control" required>
                </div>
            </div>

            <div class="grid grid-2">
                <div class="form-group">
                    <label class="form-label">Post Office</label>
                    <input type="text" name="post_office" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Police Station</label>
                    <input type="text" name="police_station" class="form-control" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">10. Electrical Subdivision</label>
                <input type="text" name="electrical_subdivision" class="form-control" required>
            </div>

            <div class="form-group">
                <label class="form-label">11. Full Address</label>
                <textarea name="address" class="form-control" style="height: 80px; padding-top: 12px;" required></textarea>
            </div>

            <div class="grid grid-2">
                <div class="form-group">
                    <label class="form-label">12. Type Of House Structure</label>
                    <select name="house_type" class="form-control" required>
                        <option value="">Select House Structure</option>
                        <option value="Building">Building</option>
                        <option value="Assam Model">Assam Model</option>
                        <option value="Kutcha House">Kutcha House</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">13. Meter Type</label>
                    <select name="meter_type" class="form-control" required>
                        <option value="">Select Meter Type</option>
                        <option value="Smart">Smart</option>
                        <option value="Normal">Normal</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">14. Annual Income Approx (Rs.)</label>
                <input type="number" name="annual_income" class="form-control" required>
            </div>

            <h3 style="font-size: 16px; font-weight: 700; margin: 32px 0 24px; color: var(--primary);">2. Additional Technical Details</h3>

            <div class="grid grid-2">
                <div class="form-group">
                    <label class="form-label">Survey Number (If any)</label>
                    <input type="text" name="survey_number" class="form-control">
                </div>
                <div class="form-group">
                    <label class="form-label">Plot Area</label>
                    <input type="text" name="plot_area" class="form-control">
                </div>
            </div>

            <div class="grid grid-2">
                <div class="form-group">
                    <label class="form-label">Road Width</label>
                    <input type="text" name="road_width" class="form-control">
                </div>
                <div class="form-group">
                    <label class="form-label">Zone</label>
                    <input type="text" name="zone" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Remarks</label>
                <textarea name="remarks" class="form-control" style="height: 60px; padding-top: 12px;"></textarea>
            </div>
        </div>

        <!-- Right Column: Documents -->
        <div class="desktop-card">
            <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 24px; color: var(--primary);">3. Required Documents</h3>
            <p style="font-size: 12px; color: var(--text-muted); margin-bottom: 20px;">Please upload all mandatory documents (JPG/PNG/PDF, Max 5MB).</p>

            <div class="form-group">
                <label class="form-label">1. Aadhaar Card <span style="color: var(--danger);">*</span></label>
                <input type="file" name="doc_aadhaar" class="form-control" accept="image/*,application/pdf" required>
            </div>

            <div class="form-group">
                <label class="form-label">2. Pan Card <span style="color: var(--danger);">*</span></label>
                <input type="file" name="doc_pan" class="form-control" accept="image/*,application/pdf" required>
            </div>

            <div class="form-group">
                <label class="form-label">3. Bank Passbook <span style="color: var(--danger);">*</span></label>
                <input type="file" name="doc_bank_passbook" class="form-control" accept="image/*,application/pdf" required>
            </div>

            <div class="form-group">
                <label class="form-label">4. Electricity Bill <span style="color: var(--danger);">*</span></label>
                <input type="file" name="doc_electricity_bill" class="form-control" accept="image/*,application/pdf" required>
            </div>

            <div class="form-group">
                <label class="form-label">5. Signature <span style="color: var(--danger);">*</span></label>
                <input type="file" name="doc_signature" class="form-control" accept="image/*,application/pdf" required>
            </div>

            <h3 style="font-size: 16px; font-weight: 700; margin: 32px 0 24px; color: var(--primary);">4. Land Ownership Document</h3>
            <div class="form-group">
                <label class="form-label">6. Select Document Type <span style="color: var(--danger);">*</span></label>
                <select name="land_ownership_type" class="form-control" required>
                    <option value="">Select Document Type</option>
                    <?php foreach ($docTypes as $type): ?>
                        <option value="<?= $type ?>"><?= $type ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Upload Land Ownership Document <span style="color: var(--danger);">*</span></label>
                <input type="file" name="doc_land_ownership" class="form-control" accept="image/*,application/pdf" required>
            </div>
            
            <div style="margin-top: 32px; padding-top: 24px; border-top: 1px solid var(--border);">
                <button type="submit" class="btn btn-primary">Submit Technical Data</button>
            </div>
        </div>
    </div>
</form>

<?php include __DIR__ . '/../includes/footer.php'; ?>
