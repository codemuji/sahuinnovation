<?php
require_once __DIR__ . '/../app/core/Auth.php';

Auth::logout();
setFlash('success', 'You have been logged out successfully.');
redirect(site_url('public/login.php'));
