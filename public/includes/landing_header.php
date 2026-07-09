<?php
require_once __DIR__ . '/../../app/core/Auth.php';
require_once __DIR__ . '/../../app/core/helpers.php';

$isLoggedIn = Auth::check();
$dashboardUrl = '';
if ($isLoggedIn) {
    $role = Auth::userRole();
    $dashboardUrl = site_url('public/' . ($role === 'pe' ? 'dm' : $role) . '/dashboard.php');
}
?>
<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title><?= isset($pageTitle) ? h($pageTitle) . ' | Sahu Innovation' : 'Sahu Innovation - Premium Solar Solutions' ?></title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 300, 'GRAD' 0, 'opsz' 24;
        }
        .ambient-shadow {
            box-shadow: 0 10px 30px -10px rgba(11, 31, 58, 0.05);
        }
        /* Scroll Animations */
        .animate-on-scroll {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }
        .animate-on-scroll.is-visible {
            opacity: 1;
            transform: translateY(0);
        }
        .delay-100 { transition-delay: 100ms; }
        .delay-200 { transition-delay: 200ms; }
        .delay-300 { transition-delay: 300ms; }
    </style>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "on-primary": "#ffffff",
                        "outline": "#75777e",
                        "on-surface": "#111c2c",
                        "primary-fixed": "#d6e3ff",
                        "inverse-primary": "#b5c7ea",
                        "secondary-container": "#feb234",
                        "tertiary": "#080603",
                        "surface": "#f9f9ff",
                        "tertiary-fixed": "#e8e2d8",
                        "on-secondary-fixed-variant": "#624000",
                        "on-primary-fixed": "#071c36",
                        "error-container": "#ffdad6",
                        "on-tertiary-fixed": "#1e1b16",
                        "primary-fixed-dim": "#b5c7ea",
                        "surface-container-low": "#f0f3ff",
                        "surface-variant": "#d8e3fa",
                        "tertiary-fixed-dim": "#ccc6bc",
                        "outline-variant": "#c4c6ce",
                        "secondary-fixed-dim": "#ffb94c",
                        "on-primary-container": "#7587a7",
                        "secondary": "#815500",
                        "surface-container-highest": "#d8e3fa",
                        "primary": "#000615",
                        "tertiary-container": "#211f19",
                        "on-tertiary-fixed-variant": "#4a463f",
                        "on-surface-variant": "#44474d",
                        "primary-container": "#0b1f3a",
                        "error": "#ba1a1a",
                        "on-secondary-fixed": "#291800",
                        "on-error-container": "#93000a",
                        "on-error": "#ffffff",
                        "inverse-on-surface": "#ebf1ff",
                        "surface-tint": "#4d5f7d",
                        "background": "#f9f9ff",
                        "surface-dim": "#cfdaf1",
                        "surface-bright": "#f9f9ff",
                        "on-tertiary": "#ffffff",
                        "surface-container": "#e7eeff",
                        "inverse-surface": "#263142",
                        "on-primary-fixed-variant": "#364764",
                        "on-background": "#111c2c",
                        "surface-container-lowest": "#ffffff",
                        "on-secondary-container": "#6d4700",
                        "on-tertiary-container": "#8b867e",
                        "secondary-fixed": "#ffddb2",
                        "surface-container-high": "#dee8ff",
                        "on-secondary": "#ffffff"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.25rem",
                        "xl": "0.5rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "margin-page": "48px",
                        "unit": "8px",
                        "gutter": "24px",
                        "section-padding": "80px",
                        "container-max": "1200px"
                    },
                    "fontFamily": {
                        "display": ["Outfit", "sans-serif"],
                        "headline-h1": ["Outfit", "sans-serif"],
                        "label-caps": ["Inter", "sans-serif"],
                        "headline-h2": ["Outfit", "sans-serif"],
                        "body-lg": ["Inter", "sans-serif"],
                        "headline-h3": ["Outfit", "sans-serif"],
                        "body-md": ["Inter", "sans-serif"]
                    },
                    "fontSize": {
                        "display": ["56px", { "lineHeight": "1.1", "letterSpacing": "-0.02em", "fontWeight": "700" }],
                        "headline-h1": ["40px", { "lineHeight": "1.2", "fontWeight": "700" }],
                        "label-caps": ["12px", { "lineHeight": "1", "letterSpacing": "0.1em", "fontWeight": "600" }],
                        "headline-h2": ["28px", { "lineHeight": "1.3", "fontWeight": "600" }],
                        "body-lg": ["16px", { "lineHeight": "1.6", "fontWeight": "400" }],
                        "headline-h3": ["20px", { "lineHeight": "1.4", "fontWeight": "600" }],
                        "body-md": ["15px", { "lineHeight": "1.6", "fontWeight": "400" }]
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-background text-on-background font-body-md antialiased selection:bg-secondary-container selection:text-on-secondary-container">

<nav class="sticky top-0 z-50 w-full bg-[#FAF9F6]/90 backdrop-blur-md border-b border-[#E5DED4] no-shadows scale-100 transition-transform">
    <div class="flex justify-between items-center w-full px-6 md:px-12 py-4 md:py-5 max-w-container-max mx-auto">
        <a class="text-xl font-display font-black tracking-tight text-[#0B1F3A]" href="<?= site_url('public/index.php') ?>">Sahu Innovation</a>
        
        <ul class="hidden lg:flex gap-8 font-body-md text-[15px] font-medium">
            <li><a class="text-[#0B1F3A]/70 hover:text-[#0B1F3A] transition-colors duration-300" href="<?= site_url('public/index.php') ?>">Home</a></li>
            <li><a class="text-[#0B1F3A]/70 hover:text-[#0B1F3A] transition-colors duration-300" href="<?= site_url('public/about.php') ?>">About</a></li>
            <li><a class="text-[#0B1F3A]/70 hover:text-[#0B1F3A] transition-colors duration-300" href="<?= site_url('public/how-it-works.php') ?>">Process</a></li>
            <li><a class="text-[#0B1F3A]/70 hover:text-[#0B1F3A] transition-colors duration-300" href="<?= site_url('public/savings-benefits.php') ?>">Savings</a></li>
            <li><a class="text-[#0B1F3A]/70 hover:text-[#0B1F3A] transition-colors duration-300" href="<?= site_url('public/pm-surya-ghar.php') ?>">Scheme</a></li>
        </ul>

        <div class="hidden md:flex items-center gap-6">
            <?php if ($isLoggedIn): ?>
                <a class="font-label-caps text-label-caps bg-primary-container text-on-primary px-6 py-2.5 rounded-lg hover:bg-primary transition-colors hover:-translate-y-[1px] shadow-sm" href="<?= $dashboardUrl ?>">Dashboard</a>
            <?php else: ?>
                <a class="font-label-caps text-label-caps text-primary-container hover:opacity-70 transition-opacity" href="<?= site_url('public/login.php') ?>">Sign In</a>
                <a class="font-label-caps text-label-caps bg-primary-container text-on-primary px-6 py-2.5 rounded-lg hover:bg-primary transition-colors hover:-translate-y-[1px] shadow-sm" href="<?= site_url('public/login.php') ?>">Get Started</a>
            <?php endif; ?>
        </div>

        <!-- Mobile Menu Toggle -->
        <button id="mobileMenuBtn" class="lg:hidden text-[#0B1F3A] p-2 hover:bg-[#0B1F3A]/5 rounded-lg transition-colors">
            <span class="material-symbols-outlined pointer-events-none">menu</span>
        </button>
    </div>
</nav>

<!-- Mobile Menu Overlay -->
<div id="mobileMenuOverlay" class="fixed inset-0 bg-[#0B1F3A]/30 backdrop-blur-sm z-[60] opacity-0 pointer-events-none transition-opacity duration-300"></div>

<!-- Mobile Menu Panel -->
<div id="mobileMenuPanel" class="fixed top-0 right-0 h-full w-[85%] max-w-[400px] bg-[#FAF9F6] shadow-2xl z-[70] translate-x-full transition-transform duration-300 flex flex-col">
    <div class="flex justify-between items-center p-6 border-b border-[#E5DED4]">
        <a class="text-xl font-display font-black tracking-tight text-[#0B1F3A]" href="<?= site_url('public/index.php') ?>">Sahu Innovation</a>
        <button id="mobileMenuClose" class="text-[#0B1F3A] p-2 hover:bg-[#0B1F3A]/5 rounded-lg transition-colors">
            <span class="material-symbols-outlined pointer-events-none">close</span>
        </button>
    </div>
    <div class="flex-1 overflow-y-auto p-6 flex flex-col gap-6">
        <ul class="flex flex-col gap-4 font-body-md text-lg font-medium text-[#0B1F3A]">
            <li><a class="block py-2 hover:text-primary transition-colors" href="<?= site_url('public/index.php') ?>">Home</a></li>
            <li><a class="block py-2 hover:text-primary transition-colors" href="<?= site_url('public/about.php') ?>">About</a></li>
            <li><a class="block py-2 hover:text-primary transition-colors" href="<?= site_url('public/how-it-works.php') ?>">Process</a></li>
            <li><a class="block py-2 hover:text-primary transition-colors" href="<?= site_url('public/savings-benefits.php') ?>">Savings</a></li>
            <li><a class="block py-2 hover:text-primary transition-colors" href="<?= site_url('public/pm-surya-ghar.php') ?>">Scheme</a></li>
        </ul>
        <div class="h-px w-full bg-[#E5DED4]"></div>
        <div class="flex flex-col gap-4">
            <?php if ($isLoggedIn): ?>
                <a class="text-center font-label-caps text-label-caps bg-primary-container text-on-primary px-6 py-3 rounded-lg" href="<?= $dashboardUrl ?>">Dashboard</a>
            <?php else: ?>
                <a class="text-center font-label-caps text-label-caps text-primary-container py-3 border border-primary-container rounded-lg" href="<?= site_url('public/login.php') ?>">Sign In</a>
                <a class="text-center font-label-caps text-label-caps bg-primary-container text-on-primary px-6 py-3 rounded-lg" href="<?= site_url('public/login.php') ?>">Get Started</a>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileMenuClose = document.getElementById('mobileMenuClose');
        const mobileMenuPanel = document.getElementById('mobileMenuPanel');
        const mobileMenuOverlay = document.getElementById('mobileMenuOverlay');

        function toggleMenu() {
            if (!mobileMenuPanel) return;
            const isClosed = mobileMenuPanel.classList.contains('translate-x-full');
            if (isClosed) {
                mobileMenuPanel.classList.remove('translate-x-full');
                mobileMenuOverlay.classList.remove('opacity-0', 'pointer-events-none');
                document.body.style.overflow = 'hidden'; // Prevent background scrolling
            } else {
                mobileMenuPanel.classList.add('translate-x-full');
                mobileMenuOverlay.classList.add('opacity-0', 'pointer-events-none');
                document.body.style.overflow = '';
            }
        }

        if (mobileMenuBtn) {
            mobileMenuBtn.addEventListener('click', toggleMenu);
            mobileMenuClose.addEventListener('click', toggleMenu);
            mobileMenuOverlay.addEventListener('click', toggleMenu);
        }
    });
</script>
