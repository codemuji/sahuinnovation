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
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title><?= isset($pageTitle) ? h($pageTitle) . ' | Sahu Innovation - Architectural Solar Excellence' : 'Sahu Innovation - Premium Architectural Solar Solutions' ?></title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600&family=Outfit:wght@400;500;600;700&family=Syne:wght@500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 300, 'GRAD' 0, 'opsz' 24;
        }
        /* Pristine Alabaster & Imperial Gold Design Tokens & Utilities */
        .gold-gradient-text {
            background: linear-gradient(135deg, #9A6B1F 0%, #D4AF37 45%, #B08B28 80%, #7A5513 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .gold-border {
            border: 1px solid rgba(212, 175, 55, 0.35);
        }
        .gold-glow {
            box-shadow: 0 15px 35px -5px rgba(212, 175, 55, 0.18);
        }
        .gold-glow-sm {
            box-shadow: 0 8px 20px -3px rgba(212, 175, 55, 0.15);
        }
        .obsidian-card, .luxury-card {
            background: linear-gradient(145deg, rgba(255, 255, 255, 0.98) 0%, rgba(248, 250, 252, 0.94) 100%);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(212, 175, 55, 0.28);
            box-shadow: 0 12px 30px -10px rgba(11, 31, 58, 0.08), 0 4px 6px -2px rgba(11, 31, 58, 0.04);
        }
        .obsidian-card-hover, .luxury-card-hover {
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .obsidian-card-hover:hover, .luxury-card-hover:hover {
            transform: translateY(-5px);
            border-color: rgba(212, 175, 55, 0.6);
            box-shadow: 0 20px 40px -12px rgba(212, 175, 55, 0.22), 0 12px 24px -8px rgba(11, 31, 58, 0.12);
        }
        .bg-grid-pattern {
            background-size: 40px 40px;
            background-image: linear-gradient(to right, rgba(11, 31, 58, 0.04) 1px, transparent 1px),
                              linear-gradient(to bottom, rgba(11, 31, 58, 0.04) 1px, transparent 1px);
        }
        .ambient-shadow {
            box-shadow: 0 15px 35px -10px rgba(11, 31, 58, 0.12);
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
                        "navy-deep": "#0B1F3A",
                        "navy-primary": "#0F172A",
                        "navy-light": "#1E293B",
                        "alabaster-cream": "#FAF9F6",
                        "surface-white": "#FFFFFF",
                        "surface-tint": "#F8FAFC",
                        "gold-imperial": "#D4AF37",
                        "gold-champagne": "#B08B28",
                        "gold-dim": "#9A6B1F",
                        "gold-light": "#FFF9E6",
                        "emerald-trust": "#059669",
                        "emerald-light": "#D1FAE5",
                        "text-main": "#0F172A",
                        "text-muted": "#475569",
                        "text-subtle": "#64748b",
                        "border-light": "#E2E8F0",
                        /* Backward compatibility mappings to transition smoothly */
                        "obsidian-deep": "#FAF9F6",
                        "charcoal-surface": "#FFFFFF",
                        "charcoal-light": "#F1F5F9",
                        "on-surface": "#0F172A",
                        "on-surface-variant": "#475569",
                        "outline-variant": "#CBD5E1",
                        "primary": "#D4AF37"
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
<body class="bg-alabaster-cream text-navy-primary font-body-md antialiased selection:bg-gold-imperial selection:text-white min-h-screen flex flex-col relative overflow-x-hidden">

<!-- Atmospheric Top Banner for Govt Scheme in Sapphire Navy -->
<div class="w-full bg-gradient-to-r from-navy-deep via-navy-primary to-navy-deep border-b border-gold-imperial/40 py-2.5 px-4 text-center text-xs font-mono-data text-gold-light flex items-center justify-center gap-2 relative z-[60] shadow-md">
    <span class="inline-block w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
    <span>PM SURYA GHAR MUFT BIJLI YOJANA: Claim <strong class="text-white font-bold">₹1,30,800 Subsidy</strong> + <strong class="text-white font-bold">300 Units/Month Free Power</strong>. Zero Down Payment Available.</span>
    <a href="<?= site_url('public/pm-surya-ghar.php') ?>" class="underline text-white hover:text-gold-imperial font-label-caps tracking-widest ml-1 transition-colors">Verify Eligibility &rarr;</a>
</div>

<!-- Glassmorphic Navigation Bar in Pristine Light Mode -->
<nav class="sticky top-0 z-50 w-full bg-white/92 backdrop-blur-2xl border-b border-gold-imperial/25 shadow-lg transition-all duration-300">
    <div class="flex justify-between items-center w-full px-4 md:px-8 py-3.5 max-w-[1536px] mx-auto gap-4">
        <!-- Logo Display -->
        <a class="flex items-center gap-3.5 flex-shrink-0 group" href="<?= site_url('public/index.php') ?>">
            <img alt="Sahu Innovation Logo" class="h-11 w-auto object-contain transition-transform duration-300 group-hover:scale-105" src="<?= site_url('public/assets/img/logo.png') ?>"/>
            <div class="flex flex-col">
                <span class="text-xl font-display font-bold tracking-tight text-navy-deep leading-none">SAHU</span>
                <span class="gold-gradient-text font-serif-title text-[9.5px] font-semibold tracking-[0.22em] uppercase leading-tight mt-0.5">INNOVATION</span>
            </div>
        </a>
        
        <!-- Desktop Nav Links with About & Leadership Dropdown -->
        <ul class="hidden lg:flex items-center gap-6 xl:gap-8 text-sm font-semibold text-navy-primary">
            <li><a class="whitespace-nowrap hover:text-gold-imperial transition-colors duration-200 py-1" href="<?= site_url('public/index.php') ?>">Home</a></li>
            <li class="relative group">
                <a class="whitespace-nowrap hover:text-gold-imperial transition-colors duration-200 py-1 flex items-center gap-1 cursor-pointer" href="<?= site_url('public/about.php') ?>">
                    <span>About & Leadership</span>
                    <span class="material-symbols-outlined text-sm text-gold-imperial leading-none transition-transform duration-200 group-hover:rotate-180">expand_more</span>
                </a>
                <!-- Dropdown Menu -->
                <div class="absolute left-0 top-full pt-2 w-72 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all duration-200 z-50">
                    <div class="bg-white rounded-xl shadow-2xl border border-gold-imperial/30 py-3 backdrop-blur-2xl ring-1 ring-black/5">
                        <div class="px-4 py-1.5 text-[11px] font-mono-data text-gold-champagne font-bold uppercase tracking-wider border-b border-border-light pb-2 mb-1">Company Sections</div>
                        <a href="<?= site_url('public/about.php#philosophy') ?>" class="flex items-center gap-3 px-4 py-2 text-sm font-medium text-navy-primary hover:bg-slate-50 hover:text-gold-imperial transition-colors">
                            <span class="material-symbols-outlined text-gold-imperial text-base">verified</span>
                            <div>
                                <div class="font-semibold leading-tight">Corporate Governance</div>
                                <div class="text-[11px] text-text-muted leading-tight">MCA Status & Hojai HQ</div>
                            </div>
                        </a>
                        <a href="<?= site_url('public/about.php#leadership') ?>" class="flex items-center gap-3 px-4 py-2 text-sm font-medium text-navy-primary hover:bg-slate-50 hover:text-gold-imperial transition-colors">
                            <span class="material-symbols-outlined text-gold-imperial text-base">star</span>
                            <div>
                                <div class="font-semibold leading-tight">MD Spotlight</div>
                                <div class="text-[11px] text-text-muted leading-tight">Prodip Sahu Showcase</div>
                            </div>
                        </a>
                        <a href="<?= site_url('public/about.php#board') ?>" class="flex items-center gap-3 px-4 py-2 text-sm font-medium text-navy-primary hover:bg-slate-50 hover:text-gold-imperial transition-colors">
                            <span class="material-symbols-outlined text-gold-imperial text-base">groups</span>
                            <div>
                                <div class="font-semibold leading-tight">Board of Directors</div>
                                <div class="text-[11px] text-text-muted leading-tight">6 Executive Directors</div>
                            </div>
                        </a>
                        <a href="<?= site_url('public/about.php#warranties') ?>" class="flex items-center gap-3 px-4 py-2 text-sm font-medium text-navy-primary hover:bg-slate-50 hover:text-gold-imperial transition-colors">
                            <span class="material-symbols-outlined text-gold-imperial text-base">gavel</span>
                            <div>
                                <div class="font-semibold leading-tight">Legal Guarantees</div>
                                <div class="text-[11px] text-text-muted leading-tight">5-Year Vendor Agreement</div>
                            </div>
                        </a>
                        <a href="<?= site_url('public/about.php#legacy') ?>" class="flex items-center gap-3 px-4 py-2 text-sm font-medium text-navy-primary hover:bg-slate-50 hover:text-gold-imperial transition-colors">
                            <span class="material-symbols-outlined text-gold-imperial text-base">history_edu</span>
                            <div>
                                <div class="font-semibold leading-tight">Sahu Trajectory</div>
                                <div class="text-[11px] text-text-muted leading-tight">Engineering Milestones</div>
                            </div>
                        </a>
                    </div>
                </div>
            </li>
            <li><a class="whitespace-nowrap hover:text-gold-imperial transition-colors duration-200 py-1" href="<?= site_url('public/how-it-works.php') ?>">11-Stage Process</a></li>
            <li><a class="whitespace-nowrap hover:text-gold-imperial transition-colors duration-200 py-1" href="<?= site_url('public/savings-benefits.php') ?>">ROI & Savings</a></li>
            <li>
                <a class="whitespace-nowrap inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-gold-imperial/10 border border-gold-imperial/40 text-navy-deep font-bold hover:bg-gold-imperial hover:text-white transition-all duration-300 text-xs font-mono-data tracking-wide shadow-sm" href="<?= site_url('public/pm-surya-ghar.php') ?>">
                    <span class="material-symbols-outlined text-sm text-gold-imperial leading-none">verified</span>
                    <span>PM Surya Ghar (₹1.3L)</span>
                </a>
            </li>
        </ul>

        <!-- Action / Login Area -->
        <div class="hidden lg:flex items-center gap-3 xl:gap-4 flex-shrink-0">
            <?php if ($isLoggedIn): ?>
                <a class="whitespace-nowrap font-label-caps text-xs bg-gradient-to-r from-navy-deep via-navy-primary to-navy-deep text-white font-bold px-5 py-2.5 rounded-lg hover:shadow-lg hover:shadow-navy-deep/20 transition-all duration-300 transform hover:-translate-y-0.5 tracking-wider uppercase leading-none border border-gold-imperial/40" href="<?= $dashboardUrl ?>">Portal Dashboard</a>
            <?php else: ?>
                <!-- Role-based Login Dropdown -->
                <div class="relative group" id="desktopPortalDropdown">
                    <button id="desktopPortalBtn" class="whitespace-nowrap font-label-caps text-xs text-navy-deep font-bold hover:text-gold-imperial transition-colors flex items-center gap-1.5 py-2 px-3.5 rounded-lg hover:bg-slate-100 cursor-pointer border border-border-light hover:border-gold-imperial/30 focus:outline-none shadow-sm bg-white">
                        <span class="material-symbols-outlined text-sm text-gold-imperial leading-none">login</span>
                        <span>Staff Portal</span>
                        <span class="material-symbols-outlined text-sm leading-none transition-transform duration-200 group-hover:rotate-180" id="portalArrow">expand_more</span>
                    </button>
                    <!-- Invisible Bridge Wrapper to prevent hover gap drop -->
                    <div class="absolute right-0 top-full pt-2 w-72 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all duration-200 z-50" id="portalMenu">
                        <div class="bg-white rounded-xl shadow-2xl border border-gold-imperial/30 py-3 backdrop-blur-2xl ring-1 ring-black/5">
                            <div class="px-4 py-1.5 text-[11px] font-mono-data text-gold-champagne font-bold uppercase tracking-wider border-b border-border-light pb-2 mb-1">Select Operations Role</div>
                            <a href="<?= site_url('public/login.php?role=admin') ?>" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-navy-primary hover:bg-slate-50 hover:text-gold-imperial transition-colors">
                                <span class="material-symbols-outlined text-gold-imperial text-lg">admin_panel_settings</span>
                                <div>
                                    <div class="font-semibold leading-tight">Managing Director</div>
                                    <div class="text-[11px] text-text-muted leading-tight">Admin & Stage 5 Payouts</div>
                                </div>
                            </a>
                            <a href="<?= site_url('public/login.php?role=director') ?>" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-navy-primary hover:bg-slate-50 hover:text-gold-imperial transition-colors">
                                <span class="material-symbols-outlined text-gold-imperial text-lg">corporate_fare</span>
                                <div>
                                    <div class="font-semibold leading-tight">Director Panel</div>
                                    <div class="text-[11px] text-text-muted leading-tight">Reports & Performance</div>
                                </div>
                            </a>
                            <a href="<?= site_url('public/login.php?role=staff') ?>" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-navy-primary hover:bg-slate-50 hover:text-gold-imperial transition-colors">
                                <span class="material-symbols-outlined text-gold-imperial text-lg">badge</span>
                                <div>
                                    <div class="font-semibold leading-tight">Staff / Review Panel</div>
                                    <div class="text-[11px] text-text-muted leading-tight">11-Stage Pipeline Tracking</div>
                                </div>
                            </a>
                            <a href="<?= site_url('public/login.php?role=dm') ?>" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-navy-primary hover:bg-slate-50 hover:text-gold-imperial transition-colors">
                                <span class="material-symbols-outlined text-gold-imperial text-lg">manage_accounts</span>
                                <div>
                                    <div class="font-semibold leading-tight">DM / PE Panel</div>
                                    <div class="text-[11px] text-text-muted leading-tight">Consumer & Payouts History</div>
                                </div>
                            </a>
                            <a href="<?= site_url('public/login.php?role=surveyer') ?>" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-navy-primary hover:bg-slate-50 hover:text-gold-imperial transition-colors">
                                <span class="material-symbols-outlined text-gold-imperial text-lg">engineering</span>
                                <div>
                                    <div class="font-semibold leading-tight">Field Surveyor Panel</div>
                                    <div class="text-[11px] text-text-muted leading-tight">Mobile Survey & ID Card</div>
                                </div>
                            </a>
                            <div class="h-px bg-border-light my-2"></div>
                            <a href="<?= site_url('public/login.php') ?>" class="block px-4 py-2 text-xs font-mono-data text-center text-navy-deep font-bold hover:underline">
                                General Consumer Portal Login &rarr;
                            </a>
                        </div>
                    </div>
                </div>
                <a class="whitespace-nowrap font-label-caps text-xs bg-gradient-to-r from-navy-deep via-navy-primary to-navy-deep text-white font-bold px-5 py-2.5 rounded-lg hover:shadow-lg hover:shadow-navy-deep/20 transition-all duration-300 transform hover:-translate-y-0.5 tracking-wider uppercase leading-none flex items-center border border-gold-imperial/40" href="<?= site_url('public/about.php#calculator') ?>">Get Free Quote</a>
            <?php endif; ?>
        </div>

        <!-- Mobile Menu Toggle -->
        <button id="mobileMenuBtn" class="lg:hidden text-navy-deep p-2 hover:bg-slate-100 rounded-lg border border-border-light transition-colors flex-shrink-0">
            <span class="material-symbols-outlined pointer-events-none">menu</span>
        </button>
    </div>
</nav>

<!-- Mobile Menu Overlay -->
<div id="mobileMenuOverlay" class="fixed inset-0 bg-navy-deep/60 backdrop-blur-sm z-[60] opacity-0 pointer-events-none transition-opacity duration-300"></div>

<!-- Mobile Menu Panel -->
<div id="mobileMenuPanel" class="fixed top-0 right-0 h-full w-[88%] max-w-[420px] bg-white border-l border-gold-imperial/30 shadow-2xl z-[70] translate-x-full transition-transform duration-300 flex flex-col">
    <div class="flex justify-between items-center p-6 border-b border-border-light">
        <a class="flex items-center gap-3" href="<?= site_url('public/index.php') ?>">
            <img alt="Sahu Innovation Logo" class="h-9 w-auto object-contain" src="<?= site_url('public/assets/img/logo.png') ?>"/>
            <span class="text-lg font-display font-bold tracking-tight text-navy-deep">SAHU <span class="gold-gradient-text font-serif-title text-xs font-semibold">INNOVATION</span></span>
        </a>
        <button id="mobileMenuClose" class="text-navy-deep p-2 hover:bg-slate-100 rounded-lg transition-colors">
            <span class="material-symbols-outlined pointer-events-none">close</span>
        </button>
    </div>
    <div class="flex-1 overflow-y-auto p-6 flex flex-col gap-6">
        <ul class="flex flex-col gap-4 font-display text-lg font-bold text-navy-primary">
            <li><a class="block py-2.5 px-3 rounded-lg hover:bg-slate-50 hover:text-gold-imperial transition-colors" href="<?= site_url('public/index.php') ?>">Home</a></li>
            <li>
                <div class="flex flex-col">
                    <a class="py-2.5 px-3 rounded-lg hover:bg-slate-50 hover:text-gold-imperial transition-colors flex items-center justify-between" href="<?= site_url('public/about.php') ?>">
                        <span>About & Leadership</span>
                        <span class="material-symbols-outlined text-base text-gold-imperial">arrow_forward</span>
                    </a>
                    <div class="pl-6 flex flex-col gap-2 mt-1 border-l-2 border-gold-imperial/30 font-body-md text-sm font-semibold text-navy-primary">
                        <a class="py-1.5 hover:text-gold-imperial transition-colors" href="<?= site_url('public/about.php#philosophy') ?>">Corporate Governance & HQ</a>
                        <a class="py-1.5 hover:text-gold-imperial transition-colors" href="<?= site_url('public/about.php#leadership') ?>">MD Spotlight (Prodip Sahu)</a>
                        <a class="py-1.5 hover:text-gold-imperial transition-colors" href="<?= site_url('public/about.php#board') ?>">Board of Directors Gallery</a>
                        <a class="py-1.5 hover:text-gold-imperial transition-colors" href="<?= site_url('public/about.php#warranties') ?>">5-Year Legal Guarantee</a>
                        <a class="py-1.5 hover:text-gold-imperial transition-colors" href="<?= site_url('public/about.php#legacy') ?>">Company Milestones</a>
                    </div>
                </div>
            </li>
            <li><a class="block py-2.5 px-3 rounded-lg hover:bg-slate-50 hover:text-gold-imperial transition-colors" href="<?= site_url('public/how-it-works.php') ?>">11-Stage Process</a></li>
            <li><a class="block py-2.5 px-3 rounded-lg hover:bg-slate-50 hover:text-gold-imperial transition-colors" href="<?= site_url('public/savings-benefits.php') ?>">ROI & Savings</a></li>
            <li><a class="block py-2.5 px-3 rounded-lg bg-gold-imperial/10 border border-gold-imperial/40 text-navy-deep hover:bg-gold-imperial/20 transition-colors" href="<?= site_url('public/pm-surya-ghar.php') ?>">PM Surya Ghar Scheme (₹1.3L Subsidy)</a></li>
        </ul>
        <div class="h-px w-full bg-border-light"></div>
        <div class="flex flex-col gap-4">
            <?php if ($isLoggedIn): ?>
                <a class="text-center font-label-caps bg-gradient-to-r from-navy-deep via-navy-primary to-navy-deep text-white font-bold px-6 py-3.5 rounded-lg uppercase tracking-wider shadow-md border border-gold-imperial/40" href="<?= $dashboardUrl ?>">Portal Dashboard</a>
            <?php else: ?>
                <div class="border border-gold-imperial/30 rounded-xl overflow-hidden bg-white shadow-lg ring-1 ring-black/5">
                    <div class="px-4 py-3 bg-slate-100 text-xs font-mono-data font-bold text-navy-deep uppercase tracking-wider flex justify-between items-center border-b border-border-light">
                        <span>Sign In by Operations Role</span>
                        <span class="material-symbols-outlined text-sm text-gold-imperial">login</span>
                    </div>
                    <div class="divide-y divide-border-light">
                        <a href="<?= site_url('public/login.php?role=admin') ?>" class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-navy-primary hover:bg-slate-50 transition-colors">
                            <span class="material-symbols-outlined text-gold-imperial text-base">admin_panel_settings</span>
                            <span>Managing Director (Admin)</span>
                        </a>
                        <a href="<?= site_url('public/login.php?role=director') ?>" class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-navy-primary hover:bg-slate-50 transition-colors">
                            <span class="material-symbols-outlined text-gold-imperial text-base">corporate_fare</span>
                            <span>Director Panel</span>
                        </a>
                        <a href="<?= site_url('public/login.php?role=staff') ?>" class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-navy-primary hover:bg-slate-50 transition-colors">
                            <span class="material-symbols-outlined text-gold-imperial text-base">badge</span>
                            <span>Staff / Review Panel</span>
                        </a>
                        <a href="<?= site_url('public/login.php?role=dm') ?>" class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-navy-primary hover:bg-slate-50 transition-colors">
                            <span class="material-symbols-outlined text-gold-imperial text-base">manage_accounts</span>
                            <span>DM / PE Panel</span>
                        </a>
                        <a href="<?= site_url('public/login.php?role=surveyer') ?>" class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-navy-primary hover:bg-slate-50 transition-colors">
                            <span class="material-symbols-outlined text-gold-imperial text-base">engineering</span>
                            <span>Field Surveyor Panel</span>
                        </a>
                    </div>
                </div>
                <a class="text-center font-label-caps bg-gradient-to-r from-navy-deep via-navy-primary to-navy-deep text-white font-bold px-6 py-3.5 rounded-lg mt-1 shadow-lg uppercase tracking-wider border border-gold-imperial/40" href="<?= site_url('public/about.php#calculator') ?>">Get Free Quote</a>
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
