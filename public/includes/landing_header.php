<?php
require_once __DIR__ . '/../../app/core/Auth.php';
require_once __DIR__ . '/../../app/core/helpers.php';

$isLoggedIn = Auth::check();
$dashboardUrl = '';
if ($isLoggedIn && !empty(Auth::userRole())) {
    $role = Auth::userRole();
    $dashboardUrl = site_url('public/' . ($role === 'pe' ? 'dm' : $role) . '/dashboard.php');
}
?>
<!DOCTYPE html>
<html class="dark" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title><?= isset($pageTitle) ? h($pageTitle) . ' | Sahu Innovation - Architectural Solar Excellence' : 'Sahu Innovation - Premium Architectural Solar Solutions' ?></title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@400;500;600&family=Outfit:wght@400;500;600;700&family=Syne:wght@500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 300, 'GRAD' 0, 'opsz' 24;
        }
        /* Obsidian & Imperial Gold Design Tokens & Utilities */
        .gold-gradient-text {
            background: linear-gradient(135deg, #FFF4D0 0%, #E6C280 30%, #D4AF37 70%, #9A7B38 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .gold-border {
            border: 1px solid rgba(212, 175, 55, 0.25);
        }
        .gold-glow {
            box-shadow: 0 0 30px -5px rgba(212, 175, 55, 0.25);
        }
        .gold-glow-sm {
            box-shadow: 0 0 15px -3px rgba(212, 175, 55, 0.2);
        }
        .obsidian-card {
            background: linear-gradient(145deg, rgba(20, 24, 36, 0.88) 0%, rgba(11, 14, 20, 0.96) 100%);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(212, 175, 55, 0.18);
        }
        .obsidian-card-hover {
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .obsidian-card-hover:hover {
            transform: translateY(-5px);
            border-color: rgba(212, 175, 55, 0.45);
            box-shadow: 0 20px 40px -12px rgba(212, 175, 55, 0.18), 0 0 20px -5px rgba(0, 240, 255, 0.08);
        }
        .bg-grid-pattern {
            background-size: 40px 40px;
            background-image: linear-gradient(to right, rgba(255, 255, 255, 0.025) 1px, transparent 1px),
                              linear-gradient(to bottom, rgba(255, 255, 255, 0.025) 1px, transparent 1px);
        }
        .ambient-shadow {
            box-shadow: 0 15px 35px -10px rgba(0, 0, 0, 0.85);
        }
        /* Scroll & Stagger Animations */
        .animate-on-scroll {
            opacity: 0;
            transform: translateY(24px);
            transition: opacity 0.7s cubic-bezier(0.16, 1, 0.3, 1), transform 0.7s cubic-bezier(0.16, 1, 0.3, 1);
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
                        "obsidian-deep": "#0B0E14",
                        "charcoal-surface": "#141824",
                        "charcoal-light": "#1C2232",
                        "gold-imperial": "#D4AF37",
                        "gold-champagne": "#E6C280",
                        "gold-dim": "#9A7B38",
                        "cyan-pulse": "#00F0FF",
                        "emerald-trust": "#10B981",
                        "on-primary": "#0B0E14",
                        "outline": "#646B80",
                        "on-surface": "#F6F5F2",
                        "primary-fixed": "#E6C280",
                        "inverse-primary": "#9A7B38",
                        "secondary-container": "#1C2232",
                        "tertiary": "#00F0FF",
                        "surface": "#0B0E14",
                        "tertiary-fixed": "#10B981",
                        "outline-variant": "#282F44",
                        "on-primary-container": "#E6C280",
                        "secondary": "#9A7B38",
                        "surface-container-highest": "#1C2232",
                        "primary": "#D4AF37",
                        "tertiary-container": "#141824",
                        "on-surface-variant": "#A3A8B8",
                        "primary-container": "#141824",
                        "error": "#EF4444",
                        "on-error": "#ffffff",
                        "inverse-on-surface": "#0B0E14",
                        "background": "#0B0E14",
                        "on-background": "#F6F5F2",
                        "surface-container-lowest": "#141824",
                        "on-secondary-container": "#D4AF37",
                        "surface-container-high": "#1C2232"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.375rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "2xl": "1rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "margin-page": "48px",
                        "unit": "8px",
                        "gutter": "24px",
                        "section-padding": "96px",
                        "container-max": "1280px"
                    },
                    "fontFamily": {
                        "display": ["Syne", "Outfit", "sans-serif"],
                        "headline-h1": ["Syne", "sans-serif"],
                        "label-caps": ["Inter", "sans-serif"],
                        "headline-h2": ["Syne", "sans-serif"],
                        "body-lg": ["Outfit", "sans-serif"],
                        "headline-h3": ["Syne", "sans-serif"],
                        "body-md": ["Inter", "sans-serif"],
                        "serif-title": ["Cinzel", "serif"],
                        "mono-data": ["JetBrains Mono", "monospace"]
                    },
                    "fontSize": {
                        "display": ["56px", { "lineHeight": "1.08", "letterSpacing": "-0.02em", "fontWeight": "700" }],
                        "headline-h1": ["42px", { "lineHeight": "1.15", "letterSpacing": "-0.01em", "fontWeight": "700" }],
                        "label-caps": ["12px", { "lineHeight": "1", "letterSpacing": "0.12em", "fontWeight": "600" }],
                        "headline-h2": ["32px", { "lineHeight": "1.25", "letterSpacing": "-0.01em", "fontWeight": "700" }],
                        "body-lg": ["17px", { "lineHeight": "1.65", "fontWeight": "400" }],
                        "headline-h3": ["22px", { "lineHeight": "1.35", "fontWeight": "600" }],
                        "body-md": ["15px", { "lineHeight": "1.6", "fontWeight": "400" }]
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-obsidian-deep text-on-surface font-body-md antialiased selection:bg-gold-imperial selection:text-obsidian-deep min-h-screen flex flex-col relative overflow-x-hidden">

<!-- Atmospheric Top Banner for Govt Scheme -->
<div class="w-full bg-gradient-to-r from-charcoal-surface via-charcoal-light to-charcoal-surface border-b border-gold-imperial/30 py-2.5 px-4 text-center text-xs font-mono-data text-gold-champagne flex items-center justify-center gap-2 relative z-[60]">
    <span class="inline-block w-2 h-2 rounded-full bg-emerald-trust animate-pulse"></span>
    <span>PM SURYA GHAR MUFT BIJLI YOJANA: Claim <strong class="text-white">₹1,30,800 Subsidy</strong> + <strong class="text-white">300 Units/Month Free Power</strong>. Zero Down Payment Available.</span>
    <a href="<?= site_url('public/pm-surya-ghar.php') ?>" class="underline text-white hover:text-gold-imperial font-label-caps tracking-widest ml-1 transition-colors">Verify Eligibility &rarr;</a>
</div>

<!-- Glassmorphic Navigation Bar -->
<!-- Glassmorphic Navigation Bar -->
<nav class="sticky top-0 z-50 w-full bg-obsidian-deep/90 backdrop-blur-2xl border-b border-gold-imperial/20 shadow-xl transition-all duration-300">
    <div class="flex justify-between items-center w-full px-4 md:px-8 py-3 max-w-[1536px] mx-auto gap-4">
        <!-- Logo Display -->
        <a class="flex items-center gap-3 flex-shrink-0 group" href="<?= site_url('public/index.php') ?>">
            <img alt="Sahu Innovation Logo" class="h-10 w-auto object-contain drop-shadow-[0_0_10px_rgba(212,175,55,0.3)] transition-transform duration-300 group-hover:scale-105" src="<?= site_url('public/assets/img/logo.png') ?>"/>
            <div class="flex flex-col">
                <span class="text-xl font-display font-bold tracking-tight text-white leading-none">SAHU</span>
                <span class="gold-gradient-text font-serif-title text-[9px] font-semibold tracking-[0.22em] uppercase leading-tight mt-0.5">INNOVATION</span>
            </div>
        </a>
        
        <!-- Desktop Nav Links (Single Line Guarantee) -->
        <ul class="hidden lg:flex items-center gap-5 xl:gap-7 text-sm font-medium">
            <li><a class="whitespace-nowrap text-on-surface/80 hover:text-gold-imperial transition-colors duration-200 py-1" href="<?= site_url('public/index.php') ?>">Home</a></li>
            <li><a class="whitespace-nowrap text-on-surface/80 hover:text-gold-imperial transition-colors duration-200 py-1 relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:bg-gold-imperial hover:after:w-full after:transition-all after:duration-300" href="<?= site_url('public/about.php') ?>">About & Philosophy</a></li>
            <li><a class="whitespace-nowrap text-on-surface/80 hover:text-gold-imperial transition-colors duration-200 py-1" href="<?= site_url('public/how-it-works.php') ?>">11-Stage Process</a></li>
            <li><a class="whitespace-nowrap text-on-surface/80 hover:text-gold-imperial transition-colors duration-200 py-1" href="<?= site_url('public/savings-benefits.php') ?>">ROI & Savings</a></li>
            <li>
                <a class="whitespace-nowrap inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-gold-imperial/10 border border-gold-imperial/30 text-gold-champagne hover:border-gold-imperial hover:text-white transition-all duration-300 text-xs font-mono-data tracking-wide" href="<?= site_url('public/pm-surya-ghar.php') ?>">
                    <span class="material-symbols-outlined text-sm text-gold-imperial leading-none">verified</span>
                    <span>PM Surya Ghar (₹1.3L)</span>
                </a>
            </li>
        </ul>

        <!-- Action / Login Area (Single Line Guarantee) -->
        <div class="hidden lg:flex items-center gap-3 xl:gap-4 flex-shrink-0">
            <?php if ($isLoggedIn): ?>
                <a class="whitespace-nowrap font-label-caps text-xs bg-gradient-to-r from-gold-imperial via-gold-champagne to-gold-imperial text-obsidian-deep font-bold px-5 py-2 rounded-lg hover:shadow-lg hover:shadow-gold-imperial/25 transition-all duration-300 transform hover:-translate-y-0.5 tracking-wider uppercase leading-none" href="<?= $dashboardUrl ?>">Portal Dashboard</a>
            <?php else: ?>
                <!-- Role-based Login Dropdown -->
                <div class="relative group" id="desktopPortalDropdown">
                    <button id="desktopPortalBtn" class="whitespace-nowrap font-label-caps text-xs text-gold-champagne hover:text-white transition-colors flex items-center gap-1.5 py-2 px-3 rounded-lg hover:bg-charcoal-surface cursor-pointer border border-transparent hover:border-gold-imperial/20 focus:outline-none">
                        <span class="material-symbols-outlined text-sm leading-none">login</span>
                        <span>Staff Portal</span>
                        <span class="material-symbols-outlined text-sm leading-none transition-transform duration-200 group-hover:rotate-180" id="portalArrow">expand_more</span>
                    </button>
                    <!-- Invisible Bridge Wrapper to prevent hover gap drop -->
                    <div class="absolute right-0 top-full pt-2 w-72 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all duration-200 z-50" id="portalMenu">
                        <div class="bg-charcoal-surface rounded-xl shadow-2xl border border-gold-imperial/30 py-3 backdrop-blur-2xl">
                            <div class="px-4 py-1.5 text-[11px] font-mono-data text-gold-imperial uppercase tracking-wider border-b border-outline-variant/40 pb-2 mb-1">Select Operations Role</div>
                            <a href="<?= site_url('public/login.php?role=admin') ?>" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-on-surface hover:bg-charcoal-light hover:text-gold-champagne transition-colors">
                                <span class="material-symbols-outlined text-gold-imperial text-lg">admin_panel_settings</span>
                                <div>
                                    <div class="font-semibold leading-tight">Managing Director</div>
                                    <div class="text-[11px] text-on-surface-variant leading-tight">Admin & Stage 5 Payouts</div>
                                </div>
                            </a>
                            <a href="<?= site_url('public/login.php?role=director') ?>" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-on-surface hover:bg-charcoal-light hover:text-gold-champagne transition-colors">
                                <span class="material-symbols-outlined text-gold-imperial text-lg">corporate_fare</span>
                                <div>
                                    <div class="font-semibold leading-tight">Director Panel</div>
                                    <div class="text-[11px] text-on-surface-variant leading-tight">Reports & Performance</div>
                                </div>
                            </a>
                            <a href="<?= site_url('public/login.php?role=staff') ?>" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-on-surface hover:bg-charcoal-light hover:text-gold-champagne transition-colors">
                                <span class="material-symbols-outlined text-gold-imperial text-lg">badge</span>
                                <div>
                                    <div class="font-semibold leading-tight">Staff / Review Panel</div>
                                    <div class="text-[11px] text-on-surface-variant leading-tight">11-Stage Pipeline Tracking</div>
                                </div>
                            </a>
                            <a href="<?= site_url('public/login.php?role=dm') ?>" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-on-surface hover:bg-charcoal-light hover:text-gold-champagne transition-colors">
                                <span class="material-symbols-outlined text-gold-imperial text-lg">manage_accounts</span>
                                <div>
                                    <div class="font-semibold leading-tight">DM / PE Panel</div>
                                    <div class="text-[11px] text-on-surface-variant leading-tight">Consumer & Payouts History</div>
                                </div>
                            </a>
                            <a href="<?= site_url('public/login.php?role=surveyer') ?>" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-on-surface hover:bg-charcoal-light hover:text-gold-champagne transition-colors">
                                <span class="material-symbols-outlined text-gold-imperial text-lg">engineering</span>
                                <div>
                                    <div class="font-semibold leading-tight">Field Surveyor Panel</div>
                                    <div class="text-[11px] text-on-surface-variant leading-tight">Mobile Survey & ID Card</div>
                                </div>
                            </a>
                            <div class="h-px bg-outline-variant/40 my-2"></div>
                            <a href="<?= site_url('public/login.php') ?>" class="block px-4 py-2 text-xs font-mono-data text-center text-cyan-pulse hover:underline">
                                General Consumer Portal Login &rarr;
                            </a>
                        </div>
                    </div>
                </div>
                <a class="whitespace-nowrap font-label-caps text-xs bg-gradient-to-r from-gold-imperial via-gold-champagne to-gold-imperial text-obsidian-deep font-bold px-5 py-2 rounded-lg hover:shadow-lg hover:shadow-gold-imperial/25 transition-all duration-300 transform hover:-translate-y-0.5 tracking-wider uppercase leading-none flex items-center" href="<?= site_url('public/about.php#calculator') ?>">Get Free Quote</a>
            <?php endif; ?>
        </div>

        <!-- Mobile Menu Toggle -->
        <button id="mobileMenuBtn" class="lg:hidden text-gold-champagne p-2 hover:bg-charcoal-surface rounded-lg border border-gold-imperial/20 transition-colors flex-shrink-0">
            <span class="material-symbols-outlined pointer-events-none">menu</span>
        </button>
    </div>
</nav>

<!-- Mobile Menu Overlay -->
<div id="mobileMenuOverlay" class="fixed inset-0 bg-obsidian-deep/80 backdrop-blur-md z-[60] opacity-0 pointer-events-none transition-opacity duration-300"></div>

<!-- Mobile Menu Panel -->
<div id="mobileMenuPanel" class="fixed top-0 right-0 h-full w-[88%] max-w-[420px] bg-charcoal-surface border-l border-gold-imperial/30 shadow-2xl z-[70] translate-x-full transition-transform duration-300 flex flex-col">
    <div class="flex justify-between items-center p-6 border-b border-outline-variant/30">
        <a class="flex items-center gap-3" href="<?= site_url('public/index.php') ?>">
            <img alt="Sahu Innovation Logo" class="h-9 w-auto object-contain" src="<?= site_url('public/assets/img/logo.png') ?>"/>
            <span class="text-lg font-display font-bold tracking-tight text-white">SAHU <span class="gold-gradient-text font-serif-title text-xs font-semibold">INNOVATION</span></span>
        </a>
        <button id="mobileMenuClose" class="text-gold-champagne p-2 hover:bg-charcoal-light rounded-lg transition-colors">
            <span class="material-symbols-outlined pointer-events-none">close</span>
        </button>
    </div>
    <div class="flex-1 overflow-y-auto p-6 flex flex-col gap-6">
        <ul class="flex flex-col gap-4 font-display text-lg font-semibold text-white">
            <li><a class="block py-2.5 px-3 rounded-lg hover:bg-charcoal-light hover:text-gold-imperial transition-colors" href="<?= site_url('public/index.php') ?>">Home</a></li>
            <li><a class="block py-2.5 px-3 rounded-lg hover:bg-charcoal-light hover:text-gold-imperial transition-colors" href="<?= site_url('public/about.php') ?>">Company & Philosophy</a></li>
            <li><a class="block py-2.5 px-3 rounded-lg hover:bg-charcoal-light hover:text-gold-imperial transition-colors" href="<?= site_url('public/how-it-works.php') ?>">11-Stage Process</a></li>
            <li><a class="block py-2.5 px-3 rounded-lg hover:bg-charcoal-light hover:text-gold-imperial transition-colors" href="<?= site_url('public/savings-benefits.php') ?>">ROI & Savings</a></li>
            <li><a class="block py-2.5 px-3 rounded-lg bg-gold-imperial/10 border border-gold-imperial/30 text-gold-champagne hover:bg-gold-imperial/20 transition-colors" href="<?= site_url('public/pm-surya-ghar.php') ?>">PM Surya Ghar Scheme (₹1.3L Subsidy)</a></li>
        </ul>
        <div class="h-px w-full bg-outline-variant/30"></div>
        <div class="flex flex-col gap-4">
            <?php if ($isLoggedIn): ?>
                <a class="text-center font-label-caps bg-gradient-to-r from-gold-imperial via-gold-champagne to-gold-imperial text-obsidian-deep font-bold px-6 py-3.5 rounded-lg uppercase tracking-wider" href="<?= $dashboardUrl ?>">Portal Dashboard</a>
            <?php else: ?>
                <div class="border border-gold-imperial/30 rounded-xl overflow-hidden bg-obsidian-deep shadow-lg">
                    <div class="px-4 py-3 bg-charcoal-light text-xs font-mono-data font-bold text-gold-champagne uppercase tracking-wider flex justify-between items-center">
                        <span>Sign In by Operations Role</span>
                        <span class="material-symbols-outlined text-sm text-gold-imperial">login</span>
                    </div>
                    <div class="divide-y divide-outline-variant/20">
                        <a href="<?= site_url('public/login.php?role=admin') ?>" class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-on-surface hover:bg-charcoal-light transition-colors">
                            <span class="material-symbols-outlined text-gold-imperial text-base">admin_panel_settings</span>
                            <span>Managing Director (Admin)</span>
                        </a>
                        <a href="<?= site_url('public/login.php?role=director') ?>" class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-on-surface hover:bg-charcoal-light transition-colors">
                            <span class="material-symbols-outlined text-gold-imperial text-base">corporate_fare</span>
                            <span>Director Panel</span>
                        </a>
                        <a href="<?= site_url('public/login.php?role=staff') ?>" class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-on-surface hover:bg-charcoal-light transition-colors">
                            <span class="material-symbols-outlined text-gold-imperial text-base">badge</span>
                            <span>Staff / Review Panel</span>
                        </a>
                        <a href="<?= site_url('public/login.php?role=dm') ?>" class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-on-surface hover:bg-charcoal-light transition-colors">
                            <span class="material-symbols-outlined text-gold-imperial text-base">manage_accounts</span>
                            <span>DM / PE Panel</span>
                        </a>
                        <a href="<?= site_url('public/login.php?role=surveyer') ?>" class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-on-surface hover:bg-charcoal-light transition-colors">
                            <span class="material-symbols-outlined text-gold-imperial text-base">engineering</span>
                            <span>Field Surveyor Panel</span>
                        </a>
                    </div>
                </div>
                <a class="text-center font-label-caps bg-gradient-to-r from-gold-imperial via-gold-champagne to-gold-imperial text-obsidian-deep font-bold px-6 py-3.5 rounded-lg mt-1 shadow-lg uppercase tracking-wider" href="<?= site_url('public/about.php#calculator') ?>">Get Free Quote</a>
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
                document.body.style.overflow = 'hidden';
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

        const desktopPortalBtn = document.getElementById('desktopPortalBtn');
        const portalMenu = document.getElementById('portalMenu');
        if (desktopPortalBtn && portalMenu) {
            desktopPortalBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                portalMenu.classList.toggle('opacity-0');
                portalMenu.classList.toggle('pointer-events-none');
                portalMenu.classList.toggle('opacity-100');
                portalMenu.classList.toggle('pointer-events-auto');
            });
            document.addEventListener('click', (e) => {
                if (!desktopPortalBtn.contains(e.target) && !portalMenu.contains(e.target)) {
                    portalMenu.classList.add('opacity-0', 'pointer-events-none');
                    portalMenu.classList.remove('opacity-100', 'pointer-events-auto');
                }
            });
        }
    });
</script>
