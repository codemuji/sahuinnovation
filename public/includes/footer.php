    </main>

    <?php if (Auth::userRole() === 'surveyer'): ?>
    <nav class="mobile-nav">
        <a href="<?= site_url('public/surveyer/dashboard.php') ?>" class="mobile-nav-item <?= strpos($_SERVER['PHP_SELF'], 'dashboard.php') !== false ? 'active' : '' ?>">
            <i class="fa fa-home"></i>
            <span>Home</span>
        </a>
        <a href="<?= site_url('public/surveyer/add-customer.php') ?>" class="mobile-nav-item <?= strpos($_SERVER['PHP_SELF'], 'add-customer.php') !== false ? 'active' : '' ?>">
            <i class="fa fa-plus-circle"></i>
            <span>Add</span>
        </a>
        <a href="<?= site_url('public/surveyer/my-customers.php') ?>" class="mobile-nav-item <?= strpos($_SERVER['PHP_SELF'], 'my-customers.php') !== false ? 'active' : '' ?>">
            <i class="fa fa-users"></i>
            <span>Customers</span>
        </a>
        <a href="<?= site_url('public/surveyer/wallet.php') ?>" class="mobile-nav-item <?= strpos($_SERVER['PHP_SELF'], 'wallet.php') !== false ? 'active' : '' ?>">
            <i class="fa fa-wallet"></i>
            <span>Wallet</span>
        </a>
        <a href="<?= site_url('public/surveyer/profile.php') ?>" class="mobile-nav-item <?= strpos($_SERVER['PHP_SELF'], 'profile.php') !== false ? 'active' : '' ?>">
            <i class="fa fa-user-circle"></i>
            <span>Profile</span>
        </a>
    </nav>
    <?php endif; ?>

    <?php if (in_array(Auth::userRole(), ['director', 'office_staff'])):
        $panelDir = Auth::userRole() === 'office_staff' ? 'office_staff' : 'director';
    ?>
    <nav class="director-mobile-nav">
        <a href="<?= site_url('public/' . $panelDir . '/dashboard.php') ?>" class="director-nav-item <?= strpos($_SERVER['PHP_SELF'], 'dashboard.php') !== false ? 'active' : '' ?>">
            <i class="fa fa-home"></i>
            <span>Home</span>
        </a>
        <a href="<?= site_url('public/' . $panelDir . '/add-usage.php') ?>" class="director-nav-item <?= strpos($_SERVER['PHP_SELF'], 'add-usage.php') !== false ? 'active' : '' ?>">
            <i class="fa fa-plus-circle"></i>
            <span>Add</span>
        </a>
        <a href="<?= site_url('public/' . $panelDir . '/usages.php') ?>" class="director-nav-item <?= strpos($_SERVER['PHP_SELF'], 'usages.php') !== false ? 'active' : '' ?>">
            <i class="fa fa-receipt"></i>
            <span>Expenses</span>
        </a>
        <a href="<?= site_url('public/' . $panelDir . '/total-expenses.php') ?>" class="director-nav-item <?= strpos($_SERVER['PHP_SELF'], 'total-expenses.php') !== false ? 'active' : '' ?>">
            <i class="fa fa-calculator"></i>
            <span>Total</span>
        </a>
        <a href="<?= site_url('public/' . $panelDir . '/profile.php') ?>" class="director-nav-item <?= strpos($_SERVER['PHP_SELF'], 'profile.php') !== false ? 'active' : '' ?>">
            <i class="fa fa-user-circle"></i>
            <span>Profile</span>
        </a>
    </nav>
    <?php endif; ?>

<?php if (Auth::userRole() !== 'surveyer'): ?>
</div> <!-- .dashboard-container -->
<?php endif; ?>

<script src="<?= asset_url('js/app.js') ?>"></script>
</body>
</html>
