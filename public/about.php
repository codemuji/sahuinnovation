<?php
$pageTitle = "Company Story, Governance & Leadership";
include_once __DIR__ . '/includes/landing_header.php';
?>

<main class="relative z-10 overflow-hidden bg-alabaster-cream">
    <!-- Hero Section: Brand Identity & Architectural Philosophy -->
    <header class="relative pt-20 pb-28 md:pt-28 md:pb-36 px-6 md:px-12 bg-alabaster-cream bg-grid-pattern border-b border-gold-imperial/30 overflow-hidden">
        <!-- Ambient Gold & Navy Glows -->
        <div class="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[700px] h-[400px] bg-gold-imperial/15 rounded-full blur-[150px] pointer-events-none"></div>
        <div class="absolute bottom-0 right-10 w-[500px] h-[300px] bg-navy-deep/5 rounded-full blur-[130px] pointer-events-none"></div>
        <div class="absolute top-10 right-1/4 w-32 h-32 rounded-full border border-gold-imperial/20 animate-pulse pointer-events-none hidden lg:block"></div>
        
        <div class="max-w-container-max mx-auto grid grid-cols-1 lg:grid-cols-12 gap-12 items-center relative z-10 animate-on-scroll">
            <div class="lg:col-span-7">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white border border-gold-imperial/40 text-navy-deep font-mono-data text-xs uppercase tracking-widest mb-6 shadow-sm">
                    <span class="material-symbols-outlined text-sm text-gold-imperial">architecture</span>
                    <span class="font-bold">Architectural Solar Engineering • Established 2025</span>
                </div>
                <h1 class="font-display text-4xl sm:text-5xl lg:text-6xl text-navy-deep mb-6 font-bold tracking-tight leading-[1.1]">
                    Where Architectural Cladding Meets
                    <span class="block mt-2 font-serif-title italic font-bold text-2xl sm:text-3xl lg:text-4xl text-gold-champagne tracking-wide leading-tight">
                        Zero-Cost Lifetime Energy.
                    </span>
                </h1>
                <p class="font-body-lg text-body-lg text-text-muted max-w-2xl mb-8 font-medium leading-relaxed">
                    We believe sustainable architecture should never demand aesthetic compromise. Sahu Innovation integrates high-performance photovoltaic technology into the fabric of premium living—guaranteeing lifetime electricity independence with zero down payment and explicit legal protection.
                </p>
                <div class="flex flex-wrap items-center gap-4">
                    <a href="#leadership" class="font-label-caps bg-gradient-to-r from-navy-deep via-navy-primary to-navy-deep text-white font-bold px-8 py-4 rounded-xl hover:shadow-xl hover:shadow-navy-deep/20 transition-all transform hover:-translate-y-0.5 uppercase tracking-wider border border-gold-imperial/40 flex items-center gap-2">
                        <span>Meet Our Leadership</span>
                        <span class="material-symbols-outlined text-gold-imperial">arrow_downward</span>
                    </a>
                    <a href="#philosophy" class="font-label-caps bg-white border border-gold-imperial/40 text-navy-deep hover:bg-slate-50 hover:border-gold-imperial px-8 py-4 rounded-xl transition-all uppercase tracking-wider flex items-center gap-2 font-bold shadow-sm">
                        <span>Corporate Identity</span>
                    </a>
                </div>
            </div>

            <!-- Floating Brand Showcase Card (`3D_logo.jpeg`) -->
            <div class="lg:col-span-5 relative">
                <div class="luxury-card rounded-2xl p-6 md:p-8 relative overflow-hidden group shadow-2xl border border-gold-imperial/40 bg-white">
                    <div class="absolute -right-12 -top-12 w-36 h-36 bg-gold-imperial/20 rounded-full blur-2xl group-hover:bg-gold-imperial/30 transition-all"></div>
                    <div class="relative z-10">
                        <div class="aspect-[16/11] rounded-xl overflow-hidden mb-6 border border-gold-imperial/35 shadow-inner bg-gradient-to-br from-navy-deep via-navy-primary to-navy-deep relative group flex items-center justify-center">
                            <img alt="Sahu Innovation 3D Embossed Luxury Logo" class="w-full h-full object-contain p-2 transition-transform duration-700 group-hover:scale-105 drop-shadow-2xl" src="<?= site_url('public/assets/img/3D_logo.jpeg') ?>"/>
                            <div class="absolute inset-0 bg-gradient-to-t from-navy-deep/70 via-transparent to-transparent pointer-events-none"></div>
                            <div class="absolute bottom-3 left-3.5 flex items-center gap-2 px-3 py-1 rounded-full bg-navy-deep/95 border border-gold-imperial/50 backdrop-blur-md z-10 shadow-md">
                                <span class="w-2 h-2 rounded-full bg-emerald-trust animate-pulse"></span>
                                <span class="font-mono-data text-[11px] text-gold-light font-bold">Official 3D Brand Mark • Embossed Edition</span>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-3 pt-2 border-t border-border-light text-center font-mono-data">
                            <div class="p-3 rounded-lg bg-surface-tint border border-gold-imperial/30">
                                <div class="text-xs text-gold-champagne font-bold">25 YEARS</div>
                                <div class="text-[11px] text-text-muted mt-0.5 font-medium">Solar Panel Warranty</div>
                            </div>
                            <div class="p-3 rounded-lg bg-surface-tint border border-gold-imperial/30">
                                <div class="text-xs text-gold-champagne font-bold">10 YEARS</div>
                                <div class="text-[11px] text-text-muted mt-0.5 font-medium">Inverter Warranty</div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Architectural Accent Lines -->
                <div class="absolute -bottom-4 -left-4 w-20 h-20 border-l-2 border-b-2 border-gold-imperial/50 rounded-bl-2xl pointer-events-none hidden md:block"></div>
                <div class="absolute -top-4 -right-4 w-20 h-20 border-r-2 border-t-2 border-gold-imperial/50 rounded-tr-2xl pointer-events-none hidden md:block"></div>
            </div>
        </div>
    </header>

    <!-- Official Corporate Governance & Identity (`#philosophy`) -->
    <section id="philosophy" class="py-24 px-6 md:px-12 bg-white border-b border-gold-imperial/30 animate-on-scroll relative">
        <div class="max-w-container-max mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                <!-- Left Statement Block (`col-span-5`) -->
                <div class="lg:col-span-5 space-y-6">
                    <span class="font-mono-data text-xs text-gold-champagne font-bold uppercase tracking-[0.25em] block border-l-2 border-gold-imperial pl-3">Corporate Governance & Status</span>
                    <h2 class="font-display text-3xl md:text-4xl text-navy-deep font-bold tracking-tight leading-tight">
                        Incorporated on June 25, 2025.
                        <span class="block font-serif-title italic text-xl text-gold-champagne font-bold mt-1">Value. Trust. Satisfaction.</span>
                    </h2>
                    <p class="font-body-md text-text-muted text-sm leading-relaxed font-medium">
                        Sahu Innovation Private Limited (`SAHU INNOVATION PVT LTD`) is an active, registered Indian clean tech startup headquartered in Hojai, Assam. We specialize in residential rooftop solar independence and commercial renewable infrastructure across Northeast India.
                    </p>

                    <div class="p-6 rounded-2xl bg-surface-tint border border-gold-imperial/40 shadow-md space-y-4 font-mono-data text-xs">
                        <div class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-gold-imperial text-xl shrink-0 mt-0.5">location_on</span>
                            <div>
                                <span class="text-gold-champagne font-bold block uppercase">Head Office Address:</span>
                                <span class="text-navy-deep font-medium block mt-0.5">Shankardev Nagar Road, Dhanuhar Basti, Hojai, Pin 782435, Assam</span>
                            </div>
                        </div>
                        <div class="pt-3 border-t border-border-light flex items-start gap-3">
                            <span class="material-symbols-outlined text-emerald-trust text-xl shrink-0 mt-0.5">verified</span>
                            <div>
                                <span class="text-emerald-trust font-bold block uppercase">Corporate Registration:</span>
                                <span class="text-navy-deep font-medium block mt-0.5">Active Indian Startup • Ministry of Corporate Affairs (MCA)</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Narrative & Architectural Cladding Detail (`col-span-7`) -->
                <div class="lg:col-span-7 space-y-8">
                    <div class="aspect-[16/9] rounded-2xl overflow-hidden shadow-xl border border-gold-imperial/40 relative group bg-navy-deep">
                        <img alt="Architectural detail of premium black monocrystalline photovoltaic solar cells with refined gold grid lines" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" src="<?= site_url('public/assets/img/solar_cladding.png') ?>"/>
                        <div class="absolute inset-0 bg-gradient-to-t from-navy-deep/90 via-navy-deep/20 to-transparent"></div>
                        <div class="absolute bottom-6 left-6 right-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                            <div>
                                <div class="font-display font-bold text-white text-base">Grade-A Monocrystalline Perc Technology</div>
                                <div class="text-xs text-gold-light font-mono-data mt-1">Matte black edge-to-edge finish engineered to complement luxury facades.</div>
                            </div>
                            <span class="px-3.5 py-1.5 rounded-lg bg-gold-imperial/20 border border-gold-imperial/50 text-gold-light font-mono-data text-xs font-bold shrink-0">
                                Integrated Cladding
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 font-mono-data text-center">
                        <div class="p-5 rounded-xl bg-surface-tint border border-gold-imperial/30 shadow-sm">
                            <div class="text-2xl font-display font-bold text-navy-deep">₹0</div>
                            <div class="text-xs text-gold-champagne font-bold mt-1 uppercase">Down Payment Model</div>
                        </div>
                        <div class="p-5 rounded-xl bg-surface-tint border border-gold-imperial/30 shadow-sm">
                            <div class="text-2xl font-display font-bold text-navy-deep">5-Year</div>
                            <div class="text-xs text-gold-champagne font-bold mt-1 uppercase">Legal Agreement</div>
                        </div>
                        <div class="p-5 rounded-xl bg-surface-tint border border-gold-imperial/30 shadow-sm">
                            <div class="text-2xl font-display font-bold text-emerald-trust">₹1.3L+</div>
                            <div class="text-xs text-gold-champagne font-bold mt-1 uppercase">Express Subsidy Processing</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Leadership Section: Board of Directors & Corporate Governance (`#leadership`) -->
    <section id="leadership" class="py-24 px-6 md:px-12 bg-surface-tint border-b border-gold-imperial/30 relative">
        <div class="max-w-container-max mx-auto">
            <!-- Section Header -->
            <div class="text-center max-w-3xl mx-auto mb-20 animate-on-scroll">
                <span class="font-mono-data text-xs text-gold-champagne font-bold uppercase tracking-[0.3em] block mb-3">Corporate Governance & Leadership Roster</span>
                <h2 class="font-display text-3xl md:text-5xl text-navy-deep font-bold tracking-tight mb-6">
                    The People Behind the Power
                </h2>
                <p class="font-body-md text-text-muted text-base leading-relaxed font-medium">
                    Our Board of Directors unites seasoned engineering foresight, rigorous corporate governance, and a profound dedication to electrifying Northeast India with zero-cost residential solar independence.
                </p>
                <div class="w-20 h-0.5 bg-gold-imperial mx-auto mt-8"></div>
            </div>

            <!-- Spotlight Showcase: Managing Director (`Prodip Sahu - 7.png`) -->
            <div class="mb-20 animate-on-scroll">
                <div class="luxury-card rounded-3xl overflow-hidden border-2 border-gold-imperial shadow-2xl bg-white grid grid-cols-1 lg:grid-cols-12 items-stretch group relative">
                    <!-- Subtle Corner Badge -->
                    <div class="absolute top-6 right-6 z-30 hidden sm:flex items-center gap-2 px-4 py-1.5 rounded-full bg-gold-imperial/15 border border-gold-imperial text-navy-deep font-mono-data text-xs font-bold shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-emerald-trust animate-pulse"></span>
                        <span>CHIEF EXECUTIVE GOVERNANCE</span>
                    </div>

                    <!-- Left: Custom Architectural Portrait Canvas for MD (`7.png`) -->
                    <div class="lg:col-span-5 relative bg-gradient-to-t from-navy-deep via-[#132847] to-[#1e3a5f] overflow-hidden flex flex-col justify-end min-h-[460px] sm:min-h-[540px]">
                        <!-- Background Architectural Effects -->
                        <div class="absolute inset-0 bg-grid-pattern opacity-60"></div>
                        <div class="absolute top-1/4 left-1/2 -translate-x-1/2 w-80 h-80 rounded-full bg-gold-imperial/35 blur-[100px] pointer-events-none group-hover:bg-gold-imperial/45 transition-all duration-700"></div>
                        
                        <!-- Geometric Golden Ring Accent -->
                        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[340px] h-[340px] rounded-full border border-gold-imperial/40 pointer-events-none opacity-40 group-hover:scale-105 transition-transform duration-700"></div>
                        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[280px] h-[280px] rounded-full border border-gold-light/20 pointer-events-none opacity-30"></div>

                        <!-- Transparent PNG (`7.png`) sitting cleanly on the stage with 3D shadow -->
                        <img alt="Prodip Sahu - Managing Director (`MD`), Sahu Innovation Private Limited" 
                             class="w-full h-full object-contain object-bottom relative z-10 transition-transform duration-700 group-hover:scale-105 group-hover:-translate-y-2 drop-shadow-[0_25px_35px_rgba(11,31,58,0.85)] max-h-[460px] sm:max-h-[520px]" 
                             src="<?= site_url('public/assets/img/team/7.png') ?>"/>

                        <!-- Floating Nameplate Tablet Overlapping Bottom -->
                        <div class="relative z-20 bg-navy-deep/95 border-t border-gold-imperial/60 backdrop-blur-md p-6 sm:p-8">
                            <span class="font-mono-data text-xs text-gold-champagne font-bold tracking-widest uppercase block mb-1.5">
                                MANAGING DIRECTOR (`MD`)
                            </span>
                            <h3 class="font-display text-2xl sm:text-3xl text-white font-bold tracking-tight">
                                Prodip Sahu
                            </h3>
                            <div class="flex items-center gap-2 mt-2 pt-2 border-t border-white/10 text-xs font-mono-data text-gold-light">
                                <span class="material-symbols-outlined text-sm text-gold-imperial">verified_user</span>
                                <span>Guiding Vision, Regional Expansion & Strategy</span>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Executive Leadership Narrative & Pillars -->
                    <div class="lg:col-span-7 p-8 sm:p-12 lg:p-16 flex flex-col justify-between bg-gradient-to-br from-white via-white to-surface-tint">
                        <div class="space-y-6">
                            <div class="inline-block px-3 py-1 rounded bg-gold-imperial/10 border border-gold-imperial/30 text-gold-champagne font-mono-data text-xs font-bold uppercase tracking-wider">
                                Founder & Managing Director
                            </div>
                            
                            <h4 class="font-display text-2xl sm:text-3xl text-navy-deep font-bold leading-tight">
                                "Transforming every home into an architectural powerhouse of energy independence."
                            </h4>
                            
                            <p class="font-body-md text-text-muted text-base leading-relaxed font-medium">
                                Under the direction of Managing Director <strong class="text-navy-deep font-bold">Prodip Sahu</strong>, Sahu Innovation has revolutionized how Assam experiences renewable energy. Recognizing that high upfront costs and complicated bureaucracy deterred families from adopting solar, he established the zero-down-payment model backed by our definitive 5-year legal vendor agreement.
                            </p>
                            
                            <p class="font-body-md text-text-muted text-base leading-relaxed font-medium">
                                Today, Prodip oversees executive governance, strategic bank financing partnerships, and field execution across Northeast India, guaranteeing that every installation meets uncompromising architectural standards.
                            </p>
                        </div>

                        <!-- Strategic Focus Pillars Grid -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-8 mt-8 border-t border-border-light font-mono-data text-xs">
                            <div class="p-4 rounded-xl bg-surface-tint border border-gold-imperial/30">
                                <span class="text-gold-champagne font-bold block uppercase mb-1">Pillar 01 • Financial Equity</span>
                                <span class="text-navy-deep font-medium">Zero down payment & easy ₹2,100/mo EMI accessibility for all families.</span>
                            </div>
                            <div class="p-4 rounded-xl bg-surface-tint border border-gold-imperial/30">
                                <span class="text-gold-champagne font-bold block uppercase mb-1">Pillar 02 • Legal Assurance</span>
                                <span class="text-navy-deep font-medium">Binding 5-year official agreement protecting every customer investment.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Board of Directors Gallery (`1.png` through `6.png`) -->
            <div class="space-y-12 animate-on-scroll">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border-b border-gold-imperial/30 pb-6">
                    <div>
                        <span class="font-mono-data text-xs text-gold-champagne font-bold uppercase tracking-widest block mb-1">Board Roster</span>
                        <h3 class="font-display text-2xl sm:text-3xl text-navy-deep font-bold">Directors of Sahu Innovation</h3>
                    </div>
                    <span class="px-4 py-1.5 rounded-full bg-white border border-gold-imperial/40 text-navy-deep font-mono-data text-xs font-bold shadow-sm">
                        6 Strategic Board Members
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 items-stretch">
                    <!-- Director 1: Dipen Sahu (`1.png`) -->
                    <div class="luxury-card rounded-3xl overflow-hidden border border-gold-imperial/35 shadow-xl transition-all duration-500 hover:shadow-2xl hover:border-gold-imperial flex flex-col justify-between group bg-white">
                        <div class="relative aspect-[4/5] bg-gradient-to-t from-navy-deep via-[#162A45] to-[#243f63] overflow-hidden flex flex-col justify-end">
                            <div class="absolute inset-0 bg-grid-pattern opacity-40"></div>
                            <div class="absolute top-1/3 left-1/2 -translate-x-1/2 w-60 h-60 bg-gold-imperial/25 rounded-full blur-2xl pointer-events-none group-hover:bg-gold-imperial/40 transition-all duration-500"></div>
                            
                            <!-- Director Number Tag -->
                            <div class="absolute top-4 right-4 z-20 px-3 py-1 rounded bg-navy-deep/80 border border-gold-imperial/40 text-gold-light font-mono-data text-[10px] font-bold tracking-widest">
                                DIRECTOR 01
                            </div>

                            <img alt="Dipen Sahu - Director" 
                                 class="w-full h-full object-contain object-bottom relative z-10 transition-transform duration-700 group-hover:scale-108 group-hover:-translate-y-1.5 drop-shadow-[0_16px_28px_rgba(11,31,58,0.65)]" 
                                 src="<?= site_url('public/assets/img/team/1.png') ?>"/>

                            <div class="relative z-20 bg-navy-deep/95 border-t border-gold-imperial/45 backdrop-blur-md p-6">
                                <span class="font-mono-data text-[11px] text-gold-champagne font-bold uppercase tracking-wider block mb-1">
                                    DIRECTOR • STRATEGIC GOVERNANCE
                                </span>
                                <h4 class="font-display text-xl font-bold text-white group-hover:text-gold-imperial transition-colors">
                                    Dipen Sahu
                                </h4>
                                <div class="text-[11px] font-mono-data text-slate-300 mt-2 pt-2 border-t border-white/10 flex items-center justify-between">
                                    <span>Project Operations</span>
                                    <span class="text-emerald-400 font-bold">Active Board</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Director 2: Khelaton Sahoo (`Sonu`) (`2.png`) -->
                    <div class="luxury-card rounded-3xl overflow-hidden border border-gold-imperial/35 shadow-xl transition-all duration-500 hover:shadow-2xl hover:border-gold-imperial flex flex-col justify-between group bg-white">
                        <div class="relative aspect-[4/5] bg-gradient-to-t from-navy-deep via-[#162A45] to-[#243f63] overflow-hidden flex flex-col justify-end">
                            <div class="absolute inset-0 bg-grid-pattern opacity-40"></div>
                            <div class="absolute top-1/3 left-1/2 -translate-x-1/2 w-60 h-60 bg-gold-champagne/25 rounded-full blur-2xl pointer-events-none group-hover:bg-gold-imperial/40 transition-all duration-500"></div>
                            
                            <!-- Director Number Tag -->
                            <div class="absolute top-4 right-4 z-20 px-3 py-1 rounded bg-navy-deep/80 border border-gold-imperial/40 text-gold-light font-mono-data text-[10px] font-bold tracking-widest">
                                DIRECTOR 02
                            </div>

                            <img alt="Khelaton Sahoo (`Sonu`) - Director" 
                                 class="w-full h-full object-contain object-bottom relative z-10 transition-transform duration-700 group-hover:scale-108 group-hover:-translate-y-1.5 drop-shadow-[0_16px_28px_rgba(11,31,58,0.65)]" 
                                 src="<?= site_url('public/assets/img/team/2.png') ?>"/>

                            <div class="relative z-20 bg-navy-deep/95 border-t border-gold-imperial/45 backdrop-blur-md p-6">
                                <span class="font-mono-data text-[11px] text-gold-champagne font-bold uppercase tracking-wider block mb-1">
                                    DIRECTOR • STRATEGIC GOVERNANCE
                                </span>
                                <h4 class="font-display text-xl font-bold text-white group-hover:text-gold-imperial transition-colors">
                                    Khelaton Sahoo (`Sonu`)
                                </h4>
                                <div class="text-[11px] font-mono-data text-slate-300 mt-2 pt-2 border-t border-white/10 flex items-center justify-between">
                                    <span>Client Relations & Field Verification</span>
                                    <span class="text-emerald-400 font-bold">Active Board</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Director 3: Goutum Sahu (`3.png`) -->
                    <div class="luxury-card rounded-3xl overflow-hidden border border-gold-imperial/35 shadow-xl transition-all duration-500 hover:shadow-2xl hover:border-gold-imperial flex flex-col justify-between group bg-white">
                        <div class="relative aspect-[4/5] bg-gradient-to-t from-navy-deep via-[#162A45] to-[#243f63] overflow-hidden flex flex-col justify-end">
                            <div class="absolute inset-0 bg-grid-pattern opacity-40"></div>
                            <div class="absolute top-1/3 left-1/2 -translate-x-1/2 w-60 h-60 bg-gold-imperial/25 rounded-full blur-2xl pointer-events-none group-hover:bg-gold-imperial/40 transition-all duration-500"></div>
                            
                            <!-- Director Number Tag -->
                            <div class="absolute top-4 right-4 z-20 px-3 py-1 rounded bg-navy-deep/80 border border-gold-imperial/40 text-gold-light font-mono-data text-[10px] font-bold tracking-widest">
                                DIRECTOR 03
                            </div>

                            <img alt="Goutum Sahu - Director" 
                                 class="w-full h-full object-contain object-bottom relative z-10 transition-transform duration-700 group-hover:scale-108 group-hover:-translate-y-1.5 drop-shadow-[0_16px_28px_rgba(11,31,58,0.65)]" 
                                 src="<?= site_url('public/assets/img/team/3.png') ?>"/>

                            <div class="relative z-20 bg-navy-deep/95 border-t border-gold-imperial/45 backdrop-blur-md p-6">
                                <span class="font-mono-data text-[11px] text-gold-champagne font-bold uppercase tracking-wider block mb-1">
                                    DIRECTOR • STRATEGIC GOVERNANCE
                                </span>
                                <h4 class="font-display text-xl font-bold text-white group-hover:text-gold-imperial transition-colors">
                                    Goutum Sahu
                                </h4>
                                <div class="text-[11px] font-mono-data text-slate-300 mt-2 pt-2 border-t border-white/10 flex items-center justify-between">
                                    <span>Technical Infrastructure</span>
                                    <span class="text-emerald-400 font-bold">Active Board</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Director 4: Krishna Prasad Sahu (`4.png`) -->
                    <div class="luxury-card rounded-3xl overflow-hidden border border-gold-imperial/35 shadow-xl transition-all duration-500 hover:shadow-2xl hover:border-gold-imperial flex flex-col justify-between group bg-white">
                        <div class="relative aspect-[4/5] bg-gradient-to-t from-navy-deep via-[#162A45] to-[#243f63] overflow-hidden flex flex-col justify-end">
                            <div class="absolute inset-0 bg-grid-pattern opacity-40"></div>
                            <div class="absolute top-1/3 left-1/2 -translate-x-1/2 w-60 h-60 bg-gold-imperial/25 rounded-full blur-2xl pointer-events-none group-hover:bg-gold-imperial/40 transition-all duration-500"></div>
                            
                            <!-- Director Number Tag -->
                            <div class="absolute top-4 right-4 z-20 px-3 py-1 rounded bg-navy-deep/80 border border-gold-imperial/40 text-gold-light font-mono-data text-[10px] font-bold tracking-widest">
                                DIRECTOR 04
                            </div>

                            <img alt="Krishna Prasad Sahu - Director" 
                                 class="w-full h-full object-contain object-bottom relative z-10 transition-transform duration-700 group-hover:scale-108 group-hover:-translate-y-1.5 drop-shadow-[0_16px_28px_rgba(11,31,58,0.65)]" 
                                 src="<?= site_url('public/assets/img/team/4.png') ?>"/>

                            <div class="relative z-20 bg-navy-deep/95 border-t border-gold-imperial/45 backdrop-blur-md p-6">
                                <span class="font-mono-data text-[11px] text-gold-champagne font-bold uppercase tracking-wider block mb-1">
                                    DIRECTOR • STRATEGIC GOVERNANCE
                                </span>
                                <h4 class="font-display text-xl font-bold text-white group-hover:text-gold-imperial transition-colors">
                                    Krishna Prasad Sahu
                                </h4>
                                <div class="text-[11px] font-mono-data text-slate-300 mt-2 pt-2 border-t border-white/10 flex items-center justify-between">
                                    <span>Grid & Subsidy Integration</span>
                                    <span class="text-emerald-400 font-bold">Active Board</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Director 5: Satra Prakash Sahu (`Ajay`) (`5.png`) -->
                    <div class="luxury-card rounded-3xl overflow-hidden border border-gold-imperial/35 shadow-xl transition-all duration-500 hover:shadow-2xl hover:border-gold-imperial flex flex-col justify-between group bg-white">
                        <div class="relative aspect-[4/5] bg-gradient-to-t from-navy-deep via-[#162A45] to-[#243f63] overflow-hidden flex flex-col justify-end">
                            <div class="absolute inset-0 bg-grid-pattern opacity-40"></div>
                            <div class="absolute top-1/3 left-1/2 -translate-x-1/2 w-60 h-60 bg-gold-champagne/25 rounded-full blur-2xl pointer-events-none group-hover:bg-gold-imperial/40 transition-all duration-500"></div>
                            
                            <!-- Director Number Tag -->
                            <div class="absolute top-4 right-4 z-20 px-3 py-1 rounded bg-navy-deep/80 border border-gold-imperial/40 text-gold-light font-mono-data text-[10px] font-bold tracking-widest">
                                DIRECTOR 05
                            </div>

                            <img alt="Satra Prakash Sahu (`Ajay`) - Director" 
                                 class="w-full h-full object-contain object-bottom relative z-10 transition-transform duration-700 group-hover:scale-108 group-hover:-translate-y-1.5 drop-shadow-[0_16px_28px_rgba(11,31,58,0.65)]" 
                                 src="<?= site_url('public/assets/img/team/5.png') ?>"/>

                            <div class="relative z-20 bg-navy-deep/95 border-t border-gold-imperial/45 backdrop-blur-md p-6">
                                <span class="font-mono-data text-[11px] text-gold-champagne font-bold uppercase tracking-wider block mb-1">
                                    DIRECTOR • STRATEGIC GOVERNANCE
                                </span>
                                <h4 class="font-display text-xl font-bold text-white group-hover:text-gold-imperial transition-colors">
                                    Satra Prakash Sahu (`Ajay`)
                                </h4>
                                <div class="text-[11px] font-mono-data text-slate-300 mt-2 pt-2 border-t border-white/10 flex items-center justify-between">
                                    <span>Financial Compliance & Contracts</span>
                                    <span class="text-emerald-400 font-bold">Active Board</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Director 6: Tikam Chand Sahu (`6.png`) -->
                    <div class="luxury-card rounded-3xl overflow-hidden border border-gold-imperial/35 shadow-xl transition-all duration-500 hover:shadow-2xl hover:border-gold-imperial flex flex-col justify-between group bg-white">
                        <div class="relative aspect-[4/5] bg-gradient-to-t from-navy-deep via-[#162A45] to-[#243f63] overflow-hidden flex flex-col justify-end">
                            <div class="absolute inset-0 bg-grid-pattern opacity-40"></div>
                            <div class="absolute top-1/3 left-1/2 -translate-x-1/2 w-60 h-60 bg-gold-imperial/25 rounded-full blur-2xl pointer-events-none group-hover:bg-gold-imperial/40 transition-all duration-500"></div>
                            
                            <!-- Director Number Tag -->
                            <div class="absolute top-4 right-4 z-20 px-3 py-1 rounded bg-navy-deep/80 border border-gold-imperial/40 text-gold-light font-mono-data text-[10px] font-bold tracking-widest">
                                DIRECTOR 06
                            </div>

                            <img alt="Tikam Chand Sahu - Director" 
                                 class="w-full h-full object-contain object-bottom relative z-10 transition-transform duration-700 group-hover:scale-108 group-hover:-translate-y-1.5 drop-shadow-[0_16px_28px_rgba(11,31,58,0.65)]" 
                                 src="<?= site_url('public/assets/img/team/6.png') ?>"/>

                            <div class="relative z-20 bg-navy-deep/95 border-t border-gold-imperial/45 backdrop-blur-md p-6">
                                <span class="font-mono-data text-[11px] text-gold-champagne font-bold uppercase tracking-wider block mb-1">
                                    DIRECTOR • STRATEGIC GOVERNANCE
                                </span>
                                <h4 class="font-display text-xl font-bold text-white group-hover:text-gold-imperial transition-colors">
                                    Tikam Chand Sahu
                                </h4>
                                <div class="text-[11px] font-mono-data text-slate-300 mt-2 pt-2 border-t border-white/10 flex items-center justify-between">
                                    <span>Regional Expansion & Logistics</span>
                                    <span class="text-emerald-400 font-bold">Active Board</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Key Office Executives & Business Partners (`#executives`) -->
            <div class="mt-20 pt-16 border-t border-gold-imperial/30 animate-on-scroll">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-8">
                    <div>
                        <span class="font-mono-data text-xs text-gold-champagne font-bold uppercase tracking-widest block mb-1">Operations & Field Survey Team</span>
                        <h3 class="font-display text-2xl text-navy-deep font-bold">Key Office Executives & Business Partners</h3>
                    </div>
                    <span class="font-mono-data text-xs text-text-muted font-medium">
                        On-Ground Engineering & Portal Verification
                    </span>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 font-mono-data">
                    <div class="luxury-card p-5 rounded-2xl border border-gold-imperial/30 text-center hover:border-gold-imperial transition-all shadow-sm">
                        <div class="w-10 h-10 rounded-full bg-surface-tint border border-gold-imperial/40 mx-auto mb-3 flex items-center justify-center text-navy-deep font-bold">
                            <span class="material-symbols-outlined text-gold-imperial">engineering</span>
                        </div>
                        <h5 class="font-display font-bold text-navy-deep text-base">Ankit</h5>
                        <span class="text-[11px] text-text-muted block mt-1">Field Operations</span>
                    </div>

                    <div class="luxury-card p-5 rounded-2xl border border-gold-imperial/30 text-center hover:border-gold-imperial transition-all shadow-sm">
                        <div class="w-10 h-10 rounded-full bg-surface-tint border border-gold-imperial/40 mx-auto mb-3 flex items-center justify-center text-navy-deep font-bold">
                            <span class="material-symbols-outlined text-gold-imperial">support_agent</span>
                        </div>
                        <h5 class="font-display font-bold text-navy-deep text-base">Rahul</h5>
                        <span class="text-[11px] text-text-muted block mt-1">Technical Coordination</span>
                    </div>

                    <div class="luxury-card p-5 rounded-2xl border border-gold-imperial/30 text-center hover:border-gold-imperial transition-all shadow-sm">
                        <div class="w-10 h-10 rounded-full bg-surface-tint border border-gold-imperial/40 mx-auto mb-3 flex items-center justify-center text-navy-deep font-bold">
                            <span class="material-symbols-outlined text-gold-imperial">satellite_alt</span>
                        </div>
                        <h5 class="font-display font-bold text-navy-deep text-base">Pankaj</h5>
                        <span class="text-[11px] text-text-muted block mt-1">Site Survey Lead</span>
                    </div>

                    <div class="luxury-card p-5 rounded-2xl border border-gold-imperial/30 text-center hover:border-gold-imperial transition-all shadow-sm">
                        <div class="w-10 h-10 rounded-full bg-surface-tint border border-gold-imperial/40 mx-auto mb-3 flex items-center justify-center text-navy-deep font-bold">
                            <span class="material-symbols-outlined text-gold-imperial">fact_check</span>
                        </div>
                        <h5 class="font-display font-bold text-navy-deep text-base">Utpal</h5>
                        <span class="text-[11px] text-text-muted block mt-1">Portal Documentation</span>
                    </div>

                    <div class="luxury-card p-5 rounded-2xl border border-gold-imperial/30 text-center hover:border-gold-imperial transition-all shadow-sm col-span-2 sm:col-span-1">
                        <div class="w-10 h-10 rounded-full bg-surface-tint border border-gold-imperial/40 mx-auto mb-3 flex items-center justify-center text-navy-deep font-bold">
                            <span class="material-symbols-outlined text-gold-imperial">verified</span>
                        </div>
                        <h5 class="font-display font-bold text-navy-deep text-base">Apon Ch. Das</h5>
                        <span class="text-[11px] text-text-muted block mt-1">Senior Survey Partner</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Asymmetrical Architectural & Legal Guarantees (`#warranties`) -->
    <section id="warranties" class="py-24 px-6 md:px-12 bg-white border-b border-gold-imperial/30 animate-on-scroll relative">
        <div class="max-w-container-max mx-auto">
            <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6 border-b border-border-light pb-8">
                <div>
                    <span class="font-mono-data text-xs text-gold-champagne font-bold uppercase tracking-[0.25em] block mb-2">Unmatched Protection & Engineering</span>
                    <h2 class="font-display text-3xl md:text-5xl text-navy-deep font-bold tracking-tight">
                        On-Grid & Hybrid Systems
                        <span class="block font-serif-title italic text-2xl md:text-3xl text-gold-champagne font-bold mt-1">With Explicit Legal Guarantees.</span>
                    </h2>
                </div>
                <p class="font-body-md text-text-muted max-w-md text-right hidden md:block font-medium">
                    Sahu Innovation eliminates all financial and technical anxiety with binding 5-year official legal contracts.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">
                <!-- Card 01: On-Grid Flagship System (`col-span-7`) -->
                <div class="lg:col-span-7 p-8 md:p-14 luxury-card rounded-3xl border border-gold-imperial/40 relative overflow-hidden group flex flex-col justify-between shadow-2xl bg-white">
                    <div class="absolute -right-6 -bottom-10 font-mono-data text-[180px] leading-none text-gold-imperial/[0.08] font-bold select-none pointer-events-none group-hover:text-gold-imperial/[0.14] transition-colors">01</div>
                    <div class="relative z-10">
                        <span class="font-mono-data text-xs text-gold-champagne font-bold tracking-[0.25em] uppercase block mb-4 border-l-2 border-gold-imperial pl-3">Flagship Capability</span>
                        <h3 class="font-display text-3xl sm:text-4xl text-navy-deep font-bold mb-6 max-w-lg leading-tight">On-Grid Solar Power (3kW)</h3>
                        <p class="font-body-lg text-text-muted text-base leading-relaxed max-w-xl mb-8 font-medium">
                            Works in direct synchronization with the national grid. Generates an average of <strong class="text-navy-deep font-bold">300 units monthly (10 units daily)</strong>, instantly offsetting household consumption to zero while enabling profitable excess export credits.
                        </p>
                        <ul class="space-y-3.5 font-mono-data text-xs text-navy-deep font-medium pt-6 border-t border-gold-imperial/30">
                            <li class="flex items-center gap-2.5">
                                <span class="w-2 h-2 rounded-full bg-emerald-trust"></span>
                                <span><strong class="text-navy-deep font-bold">Zero Installation Charges:</strong> No surprise labor costs.</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <span class="w-2 h-2 rounded-full bg-emerald-trust"></span>
                                <span><strong class="text-navy-deep font-bold">₹20,000 - ₹25,000</strong> Guaranteed Annual Savings.</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <span class="w-2 h-2 rounded-full bg-emerald-trust"></span>
                                <span>Direct Net Metering Export @ <strong class="text-gold-champagne font-bold">₹5.30/unit</strong>.</span>
                            </li>
                        </ul>
                    </div>
                    <div class="mt-10 pt-6 border-t border-gold-imperial/30 relative z-10 flex items-center justify-between">
                        <span class="font-mono-data text-xs text-gold-champagne font-bold tracking-wider">25-YEAR PANEL • 10-YEAR INVERTER WARRANTY</span>
                    </div>
                </div>

                <!-- Right Editorial Stack (`col-span-5`) -->
                <div class="lg:col-span-5 flex flex-col gap-8 justify-between">
                    <!-- Card 02: Hybrid Solar Storage -->
                    <div class="p-8 md:p-10 luxury-card rounded-3xl border border-gold-imperial/35 relative overflow-hidden group flex-1 flex flex-col justify-between shadow-xl bg-white">
                        <div class="absolute right-6 top-6 font-mono-data text-5xl text-navy-deep/10 font-bold select-none pointer-events-none">02</div>
                        <div class="relative z-10 pr-12">
                            <span class="font-mono-data text-[11px] text-navy-deep font-bold uppercase tracking-widest block mb-2">Blackout Protection</span>
                            <h3 class="font-display text-2xl text-navy-deep font-bold mb-3">Hybrid Solar Storage</h3>
                            <p class="font-body-md text-text-muted text-sm leading-relaxed mb-6 font-medium">
                                Receive electricity directly from solar during peak sunlight, while flush-mounted solid-state battery banks power your home silently during grid failures.
                            </p>
                        </div>
                        <div class="font-mono-data text-xs text-navy-deep font-bold relative z-10 pt-4 border-t border-border-light">
                            Sculptural Solid-State Battery Backup Included
                        </div>
                    </div>

                    <!-- Card 03: 5-Year Legal Agreement -->
                    <div class="p-8 md:p-10 luxury-card rounded-3xl border border-gold-imperial/35 relative overflow-hidden group flex-1 flex flex-col justify-between shadow-xl bg-white">
                        <div class="absolute right-6 top-6 font-mono-data text-5xl text-gold-imperial/15 font-bold select-none pointer-events-none">03</div>
                        <div class="relative z-10 pr-12">
                            <span class="font-mono-data text-[11px] text-gold-champagne font-bold uppercase tracking-widest block mb-2">Legal Protection</span>
                            <h3 class="font-display text-2xl text-navy-deep font-bold mb-3">5-Year Vendor Agreement</h3>
                            <p class="font-body-md text-text-muted text-sm leading-relaxed mb-6 font-medium">
                                We bind our installation quality, performance metrics, and zero-down-payment promises in an explicit 5-year official vendor contract.
                            </p>
                        </div>
                        <a href="<?= site_url('public/pm-surya-ghar.php') ?>" class="font-mono-data text-xs text-gold-champagne font-bold hover:underline flex items-center justify-between relative z-10 pt-4 border-t border-border-light">
                            <span>Review Legal Agreement Terms</span>
                            <span>&rarr;</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- The Sahu Trajectory & Legacy Section (`#legacy`) -->
    <section id="legacy" class="py-24 px-6 md:px-12 bg-surface-tint border-b border-gold-imperial/30 animate-on-scroll">
        <div class="max-w-3xl mx-auto">
            <div class="text-center mb-16">
                <span class="font-label-caps text-gold-champagne font-bold uppercase tracking-widest block mb-2">The Sahu Trajectory</span>
                <h2 class="font-display text-3xl md:text-headline-h2 text-navy-deep font-bold">Pioneering Architectural Solar</h2>
                <div class="w-16 h-0.5 bg-gold-imperial mx-auto mt-6"></div>
            </div>

            <div class="space-y-12 relative before:absolute before:inset-0 before:ml-5 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gold-imperial/30">
                <!-- Milestone 1 -->
                <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full border-2 border-gold-imperial bg-white shadow-xl shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 absolute left-0 md:left-1/2 -translate-x-1/2 z-10">
                        <div class="w-3 h-3 bg-gold-imperial rounded-full"></div>
                    </div>
                    <div class="w-[calc(100%-4rem)] md:w-[calc(50%-3rem)] pl-8 md:pl-0 md:group-even:text-right md:group-odd:text-left luxury-card p-6 rounded-xl border border-gold-imperial/35 shadow-md bg-white">
                        <div class="font-mono-data text-xs text-gold-champagne mb-1 font-bold">FOUNDATION</div>
                        <h4 class="font-display text-lg text-navy-deep font-bold mb-2">Engineering Excellence</h4>
                        <p class="font-body-md text-text-muted text-sm font-medium">Sahu Innovation is established to eliminate the trade-off between clean energy generation and architectural beauty.</p>
                    </div>
                </div>

                <!-- Milestone 2 -->
                <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full border border-gold-imperial bg-white shadow-xl shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 absolute left-0 md:left-1/2 -translate-x-1/2 z-10">
                        <div class="w-2.5 h-2.5 bg-navy-deep rounded-full"></div>
                    </div>
                    <div class="w-[calc(100%-4rem)] md:w-[calc(50%-3rem)] pl-8 md:pl-0 md:group-even:text-right md:group-odd:text-left luxury-card p-6 rounded-xl border border-gold-imperial/35 shadow-md bg-white">
                        <div class="font-mono-data text-xs text-gold-champagne mb-1 font-bold">ZERO DOWN PAYMENT</div>
                        <h4 class="font-display text-lg text-navy-deep font-bold mb-2">Financial Inclusion & 5-Yr Agreement</h4>
                        <p class="font-body-md text-text-muted text-sm font-medium">Pioneered zero down payment structures and easy ₹2,100/mo EMI models supported by our binding 5-year legal vendor guarantee.</p>
                    </div>
                </div>

                <!-- Milestone 3 -->
                <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full border border-gold-imperial bg-white shadow-xl shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 absolute left-0 md:left-1/2 -translate-x-1/2 z-10">
                        <div class="w-2.5 h-2.5 bg-gold-champagne rounded-full"></div>
                    </div>
                    <div class="w-[calc(100%-4rem)] md:w-[calc(50%-3rem)] pl-8 md:pl-0 md:group-even:text-right md:group-odd:text-left luxury-card p-6 rounded-xl border border-gold-imperial/35 shadow-md bg-white">
                        <div class="font-mono-data text-xs text-gold-champagne mb-1 font-bold">PM SURYA GHAR LEADERSHIP</div>
                        <h4 class="font-display text-lg text-navy-deep font-bold mb-2">Express Subsidy Processing</h4>
                        <p class="font-body-md text-text-muted text-sm font-medium">Full digital integration for express ₹1,30,800 subsidy verification, ensuring central and state credits land directly in customer bank passbooks.</p>
                    </div>
                </div>
            </div>

            <!-- Final Call to Action Box -->
            <div class="mt-16 text-center">
                <div class="p-8 rounded-2xl bg-navy-deep text-white border border-gold-imperial/40 shadow-2xl">
                    <h3 class="font-display text-2xl font-bold mb-3">Ready to Secure Your Solar Independence?</h3>
                    <p class="text-sm font-body-md text-slate-300 max-w-xl mx-auto mb-6">
                        Explore our PM Surya Ghar subsidy details and calculate your exact benefits or connect directly with our survey team today.
                    </p>
                    <div class="flex flex-wrap items-center justify-center gap-4">
                        <a href="<?= site_url('public/pm-surya-ghar.php') ?>" class="font-label-caps bg-gradient-to-r from-gold-imperial via-gold-champagne to-gold-imperial text-navy-deep font-bold px-8 py-3.5 rounded-xl hover:shadow-lg hover:shadow-gold-imperial/30 transition-all uppercase tracking-wider">
                            View PM Surya Ghar Benefits
                        </a>
                        <a href="<?= site_url('public/how-it-works.php') ?>" class="font-label-caps bg-white/10 border border-gold-imperial/40 text-white hover:bg-white/20 px-8 py-3.5 rounded-xl transition-all uppercase tracking-wider font-bold">
                            How It Works
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
// Staggered Scroll Animations Script
document.addEventListener('DOMContentLoaded', () => {
    const observerCallback = (entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            }
        });
    };
    const observer = new IntersectionObserver(observerCallback, {
        root: null,
        rootMargin: '0px',
        threshold: 0.12
    });
    document.querySelectorAll('.animate-on-scroll').forEach(el => observer.observe(el));
});
</script>

<?php include_once __DIR__ . '/includes/landing_footer.php'; ?>
