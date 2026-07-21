<?php
$pageTitle = "PM Surya Ghar Scheme (₹1,30,800 Subsidy)";
include_once __DIR__ . '/includes/landing_header.php';
?>

<main class="relative z-10 overflow-hidden bg-alabaster-cream">
    <!-- Hero Section -->
    <header class="relative pt-20 pb-24 px-6 md:px-12 bg-alabaster-cream bg-grid-pattern border-b border-gold-imperial/30 overflow-hidden">
        <div class="absolute top-1/3 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[350px] bg-gold-imperial/15 rounded-full blur-[140px] pointer-events-none"></div>
        <div class="max-w-container-max mx-auto relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center animate-on-scroll">
            <div class="lg:col-span-7">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white border border-emerald-trust/60 text-emerald-700 font-mono-data text-xs uppercase tracking-widest mb-6 shadow-sm font-bold">
                    <span class="material-symbols-outlined text-sm">verified</span>
                    Official Central & State Subsidy Guide
                </div>
                <h1 class="font-display text-4xl sm:text-5xl lg:text-headline-h1 text-navy-deep mb-6 font-bold tracking-tight">
                    PM Surya Ghar Muft Bijli Yojana — <span class="gold-gradient-text">₹1,30,800 Direct Subsidy.</span>
                </h1>
                <p class="font-body-lg text-body-lg text-text-muted max-w-2xl mb-8 leading-relaxed font-medium">
                    India's premier residential clean energy initiative empowers homeowners with up to <strong class="text-navy-deep font-bold">300 Units/Month of free electricity</strong>. Sahu Innovation guarantees complete end-to-end portal processing, field survey assistance, and passbook linking.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="<?= site_url('public/about.php#calculator') ?>" class="font-label-caps bg-gradient-to-r from-navy-deep via-navy-primary to-navy-deep text-white font-bold px-8 py-4 rounded-xl hover:shadow-xl hover:shadow-navy-deep/20 transition-all uppercase tracking-wider border border-gold-imperial/40">
                        Calculate Subsidy Amount
                    </a>
                    <a href="#checklist" class="font-label-caps bg-white border border-gold-imperial/40 text-navy-deep font-bold hover:bg-surface-tint hover:border-gold-imperial px-8 py-4 rounded-xl transition-all uppercase tracking-wider flex items-center gap-2 shadow-sm">
                        <span>8 Required Documents</span>
                        <span class="material-symbols-outlined text-sm text-gold-imperial">arrow_downward</span>
                    </a>
                </div>
            </div>

            <!-- Right: Subsidy Breakdown Card -->
            <div class="lg:col-span-5">
                <div class="luxury-card rounded-2xl p-8 border border-gold-imperial/40 shadow-2xl relative bg-white">
                    <div class="flex justify-between items-center pb-4 border-b border-border-light mb-6">
                        <span class="font-display font-bold text-navy-deep text-lg">3kW Flagship Allocation</span>
                        <span class="px-2.5 py-1 rounded bg-emerald-50 text-emerald-700 border border-emerald-trust/50 text-xs font-mono-data font-bold shadow-2xs">ZERO DOWN PAYMENT</span>
                    </div>

                    <div class="space-y-4 font-mono-data">
                        <div class="p-4 rounded-xl bg-surface-tint border border-gold-imperial/30 flex justify-between items-center shadow-xs">
                            <div>
                                <div class="text-xs text-gold-champagne font-bold uppercase">Central Government Credit</div>
                                <div class="text-[11px] text-text-muted mt-0.5 font-medium">Direct to Passbook within 30 Days</div>
                            </div>
                            <div class="text-xl font-display font-bold text-navy-deep">₹ 85,800</div>
                        </div>

                        <div class="p-4 rounded-xl bg-surface-tint border border-gold-imperial/30 flex justify-between items-center shadow-xs">
                            <div>
                                <div class="text-xs text-gold-champagne font-bold uppercase">State Government Credit</div>
                                <div class="text-[11px] text-text-muted mt-0.5 font-medium">Credited within 60-180 Days</div>
                            </div>
                            <div class="text-xl font-display font-bold text-navy-deep">₹ 45,000</div>
                        </div>

                        <div class="p-4 rounded-xl bg-gradient-to-r from-emerald-50 via-emerald-100/50 to-surface-tint border border-emerald-trust/60 flex justify-between items-center shadow-sm">
                            <div>
                                <div class="text-xs text-emerald-700 font-bold uppercase">Total Government Credit</div>
                                <div class="text-[11px] text-text-muted mt-0.5 font-medium">Combined Subsidy Benefit</div>
                            </div>
                            <div class="text-2xl font-display font-bold text-emerald-700">₹ 1,30,800</div>
                        </div>
                    </div>
                    <div class="mt-6 pt-4 border-t border-border-light text-center font-mono-data text-xs text-text-muted font-medium">
                        Monthly Load Charge: Only <span class="text-gold-champagne font-bold">~₹210</span> • Sell excess @ <span class="text-navy-deep font-bold">₹5.30/unit</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Eligibility & Requirements -->
    <section class="py-24 px-6 md:px-12 bg-surface-tint border-b border-gold-imperial/30 animate-on-scroll">
        <div class="max-w-container-max mx-auto">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="font-label-caps text-gold-champagne font-bold uppercase tracking-widest block mb-2">Straightforward Criteria</span>
                <h2 class="font-display text-3xl md:text-headline-h2 text-navy-deep font-bold mb-4">Who is Eligible for PM Surya Ghar?</h2>
                <p class="font-body-md text-text-muted font-medium">We verify your property eligibility during our free initial site survey.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-stretch">
                <!-- Card 01 -->
                <div class="luxury-card rounded-3xl p-8 border border-gold-imperial/35 relative overflow-hidden group flex flex-col justify-between shadow-md bg-white">
                    <div class="absolute right-6 top-6 font-mono-data text-5xl text-navy-deep/[0.06] font-bold select-none pointer-events-none">01</div>
                    <div class="relative z-10 pr-10">
                        <span class="font-mono-data text-xs text-gold-champagne font-bold uppercase tracking-widest block mb-2 border-l-2 border-gold-imperial pl-2.5">Primary Requirement</span>
                        <h3 class="font-display text-2xl text-navy-deep font-bold mb-3">Indian Resident & Homeowner</h3>
                        <p class="font-body-md text-text-muted text-sm leading-relaxed mb-6 font-medium">
                            Must be a citizen of India owning a residential property with a clear, shadow-free roof or terrace area suitable for panel mounting.
                        </p>
                    </div>
                    <div class="mt-6 pt-4 border-t border-border-light font-mono-data text-xs text-gold-champagne font-bold flex items-center justify-between">
                        <span>Verified via Land Document</span>
                        <span class="material-symbols-outlined text-sm text-gold-imperial">verified_user</span>
                    </div>
                </div>

                <!-- Card 02 -->
                <div class="luxury-card rounded-3xl p-8 border border-gold-imperial/35 relative overflow-hidden group flex flex-col justify-between shadow-md bg-white">
                    <div class="absolute right-6 top-6 font-mono-data text-5xl text-navy-deep/[0.06] font-bold select-none pointer-events-none">02</div>
                    <div class="relative z-10 pr-10">
                        <span class="font-mono-data text-xs text-gold-champagne font-bold uppercase tracking-widest block mb-2 border-l-2 border-gold-imperial pl-2.5">Grid Connection</span>
                        <h3 class="font-display text-2xl text-navy-deep font-bold mb-3">Valid Electric Connection</h3>
                        <p class="font-body-md text-text-muted text-sm leading-relaxed mb-6 font-medium">
                            An active residential electricity meter connection in the applicant's name with the local DISCOM authority.
                        </p>
                    </div>
                    <div class="mt-6 pt-4 border-t border-border-light font-mono-data text-xs text-gold-champagne font-bold flex items-center justify-between">
                        <span>Verified via Electric Bill</span>
                        <span class="material-symbols-outlined text-sm text-gold-imperial">electric_meter</span>
                    </div>
                </div>

                <!-- Card 03 -->
                <div class="luxury-card rounded-3xl p-8 border border-gold-imperial/35 relative overflow-hidden group flex flex-col justify-between shadow-md bg-white">
                    <div class="absolute right-6 top-6 font-mono-data text-5xl text-navy-deep/[0.06] font-bold select-none pointer-events-none">03</div>
                    <div class="relative z-10 pr-10">
                        <span class="font-mono-data text-xs text-gold-champagne font-bold uppercase tracking-widest block mb-2 border-l-2 border-gold-imperial pl-2.5">Portal Eligibility</span>
                        <h3 class="font-display text-2xl text-navy-deep font-bold mb-3">No Prior Solar Subsidy</h3>
                        <p class="font-body-md text-text-muted text-sm leading-relaxed mb-6 font-medium">
                            The applicant must not have availed any previous central or state government subsidy for residential rooftop solar on the same property.
                        </p>
                    </div>
                    <div class="mt-6 pt-4 border-t border-border-light font-mono-data text-xs text-gold-champagne font-bold flex items-center justify-between">
                        <span>Direct Passbook Transfer</span>
                        <span class="material-symbols-outlined text-sm text-gold-imperial">account_balance</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Official System Price Lists & Hardware Quotation Suite (`#pricing-matrix`) -->
    <section id="pricing-matrix" class="py-24 px-6 md:px-12 bg-white border-b border-gold-imperial/30 animate-on-scroll relative">
        <div class="max-w-container-max mx-auto">
            <div class="flex flex-col lg:flex-row justify-between items-end mb-16 gap-8 border-b border-border-light pb-8">
                <div>
                    <span class="font-mono-data text-xs text-gold-champagne font-bold uppercase tracking-[0.25em] block mb-2 border-l-2 border-gold-imperial pl-3">Official Quotations & Tariffs</span>
                    <h2 class="font-display text-3xl md:text-5xl text-navy-deep font-bold tracking-tight">
                        Our Range of Systems & Prices
                        <span class="block font-serif-title italic text-2xl md:text-3xl text-gold-champagne font-bold mt-1">On-Grid, Hybrid & Commercial Rodali Scheme.</span>
                    </h2>
                </div>
                <div class="flex flex-wrap gap-3 font-mono-data text-xs">
                    <button onclick="switchPriceTab('ongrid')" id="tab-btn-ongrid" class="px-5 py-2.5 rounded-xl bg-gold-imperial text-navy-deep font-bold transition-all uppercase tracking-wider shadow-md">On-Grid (Subsidy Eligible)</button>
                    <button onclick="switchPriceTab('hybrid')" id="tab-btn-hybrid" class="px-5 py-2.5 rounded-xl bg-white text-text-muted border border-border-light hover:bg-surface-tint hover:text-navy-deep transition-all uppercase tracking-wider font-semibold">Hybrid (Battery Backup)</button>
                    <button onclick="switchPriceTab('rodali')" id="tab-btn-rodali" class="px-5 py-2.5 rounded-xl bg-white text-text-muted border border-border-light hover:bg-surface-tint hover:text-navy-deep transition-all uppercase tracking-wider font-semibold">Rodali Commercial</button>
                    <button onclick="switchPriceTab('bom')" id="tab-btn-bom" class="px-5 py-2.5 rounded-xl bg-white text-text-muted border border-border-light hover:bg-surface-tint hover:text-navy-deep transition-all uppercase tracking-wider font-semibold">20-Item Hardware Spec</button>
                </div>
            </div>

            <!-- TAB 1: ON-GRID PRICE LIST (Subsidy Eligible) -->
            <div id="tab-content-ongrid" class="space-y-8 animate-fade-in">
                <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-trust/60 text-emerald-800 font-mono-data text-xs flex items-center justify-between flex-wrap gap-2 shadow-xs">
                    <span class="flex items-center gap-2 font-medium"><span class="material-symbols-outlined text-sm text-emerald-700">verified</span> All On-Grid residential systems below are eligible for the guaranteed ₹1,30,800 PM Surya Ghar Government Subsidy (`₹85.8K Central + ₹45K State`).</span>
                    <span class="font-bold text-navy-deep">25-Year Panel • 10-Year Inverter Warranty</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- 3kW Flagship -->
                    <div class="luxury-card rounded-3xl p-8 border border-gold-imperial/40 relative overflow-hidden flex flex-col justify-between shadow-xl bg-white">
                        <div class="absolute right-4 top-4 px-3 py-1 rounded-full bg-gold-imperial text-navy-deep font-mono-data text-[10px] font-bold uppercase shadow-2xs">Most Popular Flagship</div>
                        <div>
                            <span class="font-mono-data text-xs text-gold-champagne font-bold uppercase tracking-widest block mb-1">On-Grid System</span>
                            <h3 class="font-display text-3xl text-navy-deep font-bold mb-4">3 kW Capacity</h3>
                            <div class="space-y-3 font-mono-data text-xs text-text-muted border-t border-border-light pt-4 mb-6">
                                <div class="p-3 rounded-lg bg-surface-tint border border-gold-imperial/30 shadow-2xs">
                                    <div class="text-gold-champagne font-bold text-sm">₹ 1,89,000/-</div>
                                    <div class="text-[11px] font-medium text-navy-deep mt-0.5">Orient ADM Panels + FESTON Inverter</div>
                                </div>
                                <div class="p-3 rounded-lg bg-surface-tint border border-gold-imperial/30 shadow-2xs">
                                    <div class="text-gold-champagne font-bold text-sm">₹ 1,95,000/-</div>
                                    <div class="text-[11px] font-medium text-navy-deep mt-0.5">Adani / Waaree / Tata Panels + Havells / Waaree Inverter</div>
                                </div>
                                <div class="p-3 rounded-lg bg-surface-tint border border-gold-imperial/30 shadow-2xs">
                                    <div class="text-navy-deep font-bold text-sm">₹ 2,00,000/-</div>
                                    <div class="text-[11px] font-medium text-navy-deep mt-0.5">Orient ADM Panels + Feston Inverter with Luminous Battery (150AH)</div>
                                </div>
                            </div>
                        </div>
                        <div class="pt-4 border-t border-border-light flex justify-between items-center text-xs font-mono-data">
                            <span class="text-emerald-700 font-bold">Net After Subsidy: ~₹58,200</span>
                            <span class="text-text-muted font-bold">300 Units/mo</span>
                        </div>
                    </div>

                    <!-- 4kW System -->
                    <div class="luxury-card rounded-3xl p-8 border border-gold-imperial/35 relative overflow-hidden flex flex-col justify-between shadow-md bg-white">
                        <div>
                            <span class="font-mono-data text-xs text-gold-champagne font-bold uppercase tracking-widest block mb-1">On-Grid System</span>
                            <h3 class="font-display text-3xl text-navy-deep font-bold mb-4">4 kW Capacity</h3>
                            <div class="space-y-3 font-mono-data text-xs text-text-muted border-t border-border-light pt-4 mb-6">
                                <div class="p-3 rounded-lg bg-surface-tint border border-gold-imperial/30 shadow-2xs">
                                    <div class="text-gold-champagne font-bold text-sm">₹ 2,85,000/-</div>
                                    <div class="text-[11px] font-medium text-navy-deep mt-0.5">Orient ADM Panels + FESTON Inverter</div>
                                </div>
                                <div class="p-3 rounded-lg bg-surface-tint border border-gold-imperial/30 shadow-2xs">
                                    <div class="text-gold-champagne font-bold text-sm">₹ 2,90,000/-</div>
                                    <div class="text-[11px] font-medium text-navy-deep mt-0.5">Adani / Waaree Panels + Havells / Waaree Inverter</div>
                                </div>
                            </div>
                        </div>
                        <div class="pt-4 border-t border-border-light flex justify-between items-center text-xs font-mono-data">
                            <span class="text-emerald-700 font-bold">Subsidy: ₹1,30,800</span>
                            <span class="text-text-muted font-bold">400 Units/mo</span>
                        </div>
                    </div>

                    <!-- 5kW System -->
                    <div class="luxury-card rounded-3xl p-8 border border-gold-imperial/35 relative overflow-hidden flex flex-col justify-between shadow-md bg-white">
                        <div>
                            <span class="font-mono-data text-xs text-gold-champagne font-bold uppercase tracking-widest block mb-1">On-Grid System</span>
                            <h3 class="font-display text-3xl text-navy-deep font-bold mb-4">5 kW Capacity</h3>
                            <div class="space-y-3 font-mono-data text-xs text-text-muted border-t border-border-light pt-4 mb-6">
                                <div class="p-3 rounded-lg bg-surface-tint border border-gold-imperial/30 shadow-2xs">
                                    <div class="text-gold-champagne font-bold text-sm">₹ 3,50,000/-</div>
                                    <div class="text-[11px] font-medium text-navy-deep mt-0.5">Orient ADM Panels + FESTON Inverter</div>
                                </div>
                                <div class="p-3 rounded-lg bg-surface-tint border border-gold-imperial/30 shadow-2xs">
                                    <div class="text-gold-champagne font-bold text-sm">₹ 3,55,000/-</div>
                                    <div class="text-[11px] font-medium text-navy-deep mt-0.5">Adani / Waaree Panels + Havells / Waaree Inverter</div>
                                </div>
                            </div>
                        </div>
                        <div class="pt-4 border-t border-border-light flex justify-between items-center text-xs font-mono-data">
                            <span class="text-emerald-700 font-bold">Subsidy: ₹1,30,800</span>
                            <span class="text-text-muted font-bold">500 Units/mo</span>
                        </div>
                    </div>

                    <!-- 7kW System -->
                    <div class="luxury-card rounded-3xl p-8 border border-gold-imperial/35 relative overflow-hidden flex flex-col justify-between shadow-md bg-white">
                        <div>
                            <span class="font-mono-data text-xs text-gold-champagne font-bold uppercase tracking-widest block mb-1">On-Grid System</span>
                            <h3 class="font-display text-3xl text-navy-deep font-bold mb-4">7 kW Capacity</h3>
                            <div class="space-y-3 font-mono-data text-xs text-text-muted border-t border-border-light pt-4 mb-6">
                                <div class="p-3 rounded-lg bg-surface-tint border border-gold-imperial/30 shadow-2xs">
                                    <div class="text-gold-champagne font-bold text-sm">₹ 4,80,000/-</div>
                                    <div class="text-[11px] font-medium text-navy-deep mt-0.5">Orient ADM Panels + FESTON Inverter</div>
                                </div>
                                <div class="p-3 rounded-lg bg-surface-tint border border-gold-imperial/30 shadow-2xs">
                                    <div class="text-gold-champagne font-bold text-sm">₹ 4,90,000/-</div>
                                    <div class="text-[11px] font-medium text-navy-deep mt-0.5">Adani / Waaree Panels + Havells / Waaree Inverter</div>
                                </div>
                            </div>
                        </div>
                        <div class="pt-4 border-t border-border-light flex justify-between items-center text-xs font-mono-data">
                            <span class="text-emerald-700 font-bold">Subsidy: ₹1,30,800</span>
                            <span class="text-text-muted font-bold">700 Units/mo</span>
                        </div>
                    </div>

                    <!-- 10kW System -->
                    <div class="luxury-card rounded-3xl p-8 border border-gold-imperial/40 relative overflow-hidden flex flex-col justify-between sm:col-span-2 lg:col-span-2 shadow-lg bg-white">
                        <div>
                            <span class="font-mono-data text-xs text-gold-champagne font-bold uppercase tracking-widest block mb-1">Large Residential / Villa On-Grid</span>
                            <h3 class="font-display text-3xl text-navy-deep font-bold mb-4">10 kW Capacity</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 font-mono-data text-xs text-text-muted border-t border-border-light pt-4 mb-6">
                                <div class="p-4 rounded-xl bg-surface-tint border border-gold-imperial/30 shadow-2xs">
                                    <div class="text-gold-champagne font-bold text-lg">₹ 6,50,000/-</div>
                                    <div class="text-[11px] font-medium text-navy-deep mt-1">Orient ADM Panels + FESTON Inverter</div>
                                </div>
                                <div class="p-4 rounded-xl bg-surface-tint border border-gold-imperial/30 shadow-2xs">
                                    <div class="text-gold-champagne font-bold text-lg">₹ 6,60,000/-</div>
                                    <div class="text-[11px] font-medium text-navy-deep mt-1">Adani Panels + Havells / Waaree Inverter</div>
                                </div>
                            </div>
                        </div>
                        <div class="pt-4 border-t border-border-light flex justify-between items-center text-xs font-mono-data">
                            <span class="text-emerald-700 font-bold">Max Residential Subsidy: ₹1,30,800</span>
                            <span class="text-text-muted font-bold">1,000 Units/mo (~33 Units Daily)</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB 2: HYBRID PRICE LIST (With Battery Backup) -->
            <div id="tab-content-hybrid" class="space-y-8 animate-fade-in hidden">
                <div class="p-4 rounded-xl bg-surface-tint border border-gold-imperial/40 text-navy-deep font-mono-data text-xs flex items-center justify-between flex-wrap gap-2 shadow-xs">
                    <span class="flex items-center gap-2 font-medium"><span class="material-symbols-outlined text-sm text-gold-imperial">battery_charging_full</span> Hybrid Solar Storage automatically powers your home during daytime outages and switches seamlessly to solid-state battery banks at night.</span>
                    <span class="font-bold text-navy-deep">ADM Panels + Luminous / Microtek / Feston Inverter with Battery Included</span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 font-mono-data">
                    <div class="luxury-card rounded-2xl p-6 border border-gold-imperial/35 flex flex-col justify-between shadow-md bg-white">
                        <div>
                            <span class="text-[11px] text-gold-champagne font-bold uppercase tracking-wider">With Battery Storage</span>
                            <h4 class="font-display text-2xl text-navy-deep font-bold my-2">Hybrid 3 kW</h4>
                            <div class="text-gold-champagne text-xl font-bold my-3">₹ 2,95,000/-</div>
                            <p class="text-[11px] text-text-muted font-medium">ADM Panels + Inverter With Battery Pack</p>
                        </div>
                    </div>

                    <div class="luxury-card rounded-2xl p-6 border border-gold-imperial/35 flex flex-col justify-between shadow-md bg-white">
                        <div>
                            <span class="text-[11px] text-gold-champagne font-bold uppercase tracking-wider">With Battery Storage</span>
                            <h4 class="font-display text-2xl text-navy-deep font-bold my-2">Hybrid 5 kW</h4>
                            <div class="text-gold-champagne text-xl font-bold my-3">₹ 5,25,000/-</div>
                            <p class="text-[11px] text-text-muted font-medium">ADM Panels + Inverter With Battery Pack</p>
                        </div>
                    </div>

                    <div class="luxury-card rounded-2xl p-6 border border-gold-imperial/35 flex flex-col justify-between shadow-md bg-white">
                        <div>
                            <span class="text-[11px] text-gold-champagne font-bold uppercase tracking-wider">With Battery Storage</span>
                            <h4 class="font-display text-2xl text-navy-deep font-bold my-2">Hybrid 6 kW</h4>
                            <div class="text-gold-champagne text-xl font-bold my-3">₹ 5,75,000/-</div>
                            <p class="text-[11px] text-text-muted font-medium">ADM Panels + Inverter With Battery Pack</p>
                        </div>
                    </div>

                    <div class="luxury-card rounded-2xl p-6 border border-gold-imperial/35 flex flex-col justify-between shadow-md bg-white">
                        <div>
                            <span class="text-[11px] text-gold-champagne font-bold uppercase tracking-wider">With Battery Storage</span>
                            <h4 class="font-display text-2xl text-navy-deep font-bold my-2">Hybrid 7 kW</h4>
                            <div class="text-gold-champagne text-xl font-bold my-3">₹ 6,45,000/-</div>
                            <p class="text-[11px] text-text-muted font-medium">ADM Panels + Inverter With Battery Pack</p>
                        </div>
                    </div>

                    <div class="luxury-card rounded-2xl p-6 border border-gold-imperial/35 flex flex-col justify-between shadow-md bg-white">
                        <div>
                            <span class="text-[11px] text-gold-champagne font-bold uppercase tracking-wider">With Battery Storage</span>
                            <h4 class="font-display text-2xl text-navy-deep font-bold my-2">Hybrid 8 kW</h4>
                            <div class="text-gold-champagne text-xl font-bold my-3">₹ 7,55,800/-</div>
                            <p class="text-[11px] text-text-muted font-medium">ADM Panels + Inverter With Battery Pack</p>
                        </div>
                    </div>

                    <div class="luxury-card rounded-2xl p-6 border border-gold-imperial/35 flex flex-col justify-between shadow-md bg-white">
                        <div>
                            <span class="text-[11px] text-gold-champagne font-bold uppercase tracking-wider">With Battery Storage</span>
                            <h4 class="font-display text-2xl text-navy-deep font-bold my-2">Hybrid 9 kW</h4>
                            <div class="text-gold-champagne text-xl font-bold my-3">₹ 8,10,000/-</div>
                            <p class="text-[11px] text-text-muted font-medium">ADM Panels + Inverter With Battery Pack</p>
                        </div>
                    </div>

                    <div class="luxury-card rounded-2xl p-6 border border-gold-imperial/40 flex flex-col justify-between sm:col-span-2 shadow-lg bg-white">
                        <div>
                            <span class="text-[11px] text-gold-champagne font-bold uppercase tracking-wider">Villa & Heavy Load Backup</span>
                            <h4 class="font-display text-2xl text-navy-deep font-bold my-2">Hybrid 10 kW</h4>
                            <div class="text-gold-champagne text-2xl font-bold my-3">₹ 8,90,000/-</div>
                            <p class="text-[11px] text-text-muted font-medium">ADM Panels + Luminous / Microtek / Feston Inverter With Solid-State Battery Bank</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB 3: RODALI SCHEME COMMERCIAL & INDUSTRIAL -->
            <div id="tab-content-rodali" class="space-y-8 animate-fade-in hidden">
                <div class="p-4 rounded-xl bg-surface-tint border border-gold-imperial/40 text-gold-champagne font-mono-data text-xs flex items-center justify-between flex-wrap gap-4 shadow-xs">
                    <div>
                        <strong class="text-navy-deep font-bold">RODALI SCHEME (Assam & Northeast Commercial / Industrial Solar):</strong>
                        <span class="text-text-muted font-medium">We engineer heavy-duty solar installations for commercial establishments beyond PM Surya Ghar.</span>
                        <span class="block text-[11px] text-text-muted mt-1 font-medium">Note: Commercial / Industrial Solar projects do NOT qualify for government subsidy (`NO SUBSIDY`).</span>
                    </div>
                    <span class="px-3 py-1 rounded bg-white border border-gold-imperial/40 text-gold-champagne font-bold shadow-2xs">21 kW+ Custom Quotation Available</span>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Commercial On-Grid -->
                    <div class="luxury-card rounded-3xl p-8 border border-gold-imperial/40 space-y-6 shadow-xl bg-white">
                        <div class="flex items-center justify-between border-b border-border-light pb-4">
                            <h3 class="font-display text-2xl text-navy-deep font-bold">Commercial On-Grid Price List</h3>
                            <span class="font-mono-data text-xs text-gold-champagne font-bold">ADM Panels + Feston Inverter</span>
                        </div>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 font-mono-data text-xs">
                            <div class="p-3.5 rounded-xl bg-surface-tint border border-gold-imperial/30 shadow-2xs">
                                <div class="text-text-muted text-[11px] font-medium">3 kW Commercial</div>
                                <div class="text-gold-champagne font-bold text-base mt-1">₹ 1,75,000/-</div>
                            </div>
                            <div class="p-3.5 rounded-xl bg-surface-tint border border-gold-imperial/30 shadow-2xs">
                                <div class="text-text-muted text-[11px] font-medium">5 kW Commercial</div>
                                <div class="text-gold-champagne font-bold text-base mt-1">₹ 3,00,000/-</div>
                            </div>
                            <div class="p-3.5 rounded-xl bg-surface-tint border border-gold-imperial/30 shadow-2xs">
                                <div class="text-text-muted text-[11px] font-medium">7 kW Commercial</div>
                                <div class="text-gold-champagne font-bold text-base mt-1">₹ 4,15,000/-</div>
                            </div>
                            <div class="p-3.5 rounded-xl bg-surface-tint border border-gold-imperial/30 shadow-2xs">
                                <div class="text-text-muted text-[11px] font-medium">10 kW Commercial</div>
                                <div class="text-gold-champagne font-bold text-base mt-1">₹ 5,80,000/-</div>
                            </div>
                            <div class="p-3.5 rounded-xl bg-surface-tint border border-gold-imperial/30 shadow-2xs">
                                <div class="text-text-muted text-[11px] font-medium">15 kW Commercial</div>
                                <div class="text-gold-champagne font-bold text-base mt-1">₹ 8,70,000/-</div>
                            </div>
                            <div class="p-3.5 rounded-xl bg-surface-tint border border-gold-imperial/30 shadow-2xs">
                                <div class="text-text-muted text-[11px] font-medium">20 kW Commercial</div>
                                <div class="text-gold-champagne font-bold text-base mt-1">₹ 11,60,000/-</div>
                            </div>
                        </div>
                    </div>

                    <!-- Commercial Hybrid -->
                    <div class="luxury-card rounded-3xl p-8 border border-gold-imperial/35 space-y-6 shadow-md bg-white">
                        <div class="flex items-center justify-between border-b border-border-light pb-4">
                            <h3 class="font-display text-2xl text-navy-deep font-bold">Commercial Hybrid Price List</h3>
                            <span class="font-mono-data text-xs text-navy-primary font-bold">ADM Panels + Inverter (With Battery)</span>
                        </div>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 font-mono-data text-xs">
                            <div class="p-3.5 rounded-xl bg-surface-tint border border-gold-imperial/30 shadow-2xs">
                                <div class="text-text-muted text-[11px] font-medium">3 kW Hybrid</div>
                                <div class="text-navy-deep font-bold text-base mt-1">₹ 2,60,000/-</div>
                            </div>
                            <div class="p-3.5 rounded-xl bg-surface-tint border border-gold-imperial/30 shadow-2xs">
                                <div class="text-text-muted text-[11px] font-medium">5 kW Hybrid</div>
                                <div class="text-navy-deep font-bold text-base mt-1">₹ 4,35,000/-</div>
                            </div>
                            <div class="p-3.5 rounded-xl bg-surface-tint border border-gold-imperial/30 shadow-2xs">
                                <div class="text-text-muted text-[11px] font-medium">7 kW Hybrid</div>
                                <div class="text-navy-deep font-bold text-base mt-1">₹ 6,10,000/-</div>
                            </div>
                            <div class="p-3.5 rounded-xl bg-surface-tint border border-gold-imperial/30 shadow-2xs">
                                <div class="text-text-muted text-[11px] font-medium">10 kW Hybrid</div>
                                <div class="text-navy-deep font-bold text-base mt-1">₹ 8,80,000/-</div>
                            </div>
                            <div class="p-3.5 rounded-xl bg-surface-tint border border-gold-imperial/30 shadow-2xs">
                                <div class="text-text-muted text-[11px] font-medium">15 kW Hybrid</div>
                                <div class="text-navy-deep font-bold text-base mt-1">₹ 13,20,000/-</div>
                            </div>
                            <div class="p-3.5 rounded-xl bg-surface-tint border border-gold-imperial/30 shadow-2xs">
                                <div class="text-text-muted text-[11px] font-medium">20 kW Hybrid</div>
                                <div class="text-navy-deep font-bold text-base mt-1">₹ 17,50,000/-</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB 4: 20-ITEM HARDWARE BILL OF MATERIALS (BOM) -->
            <div id="tab-content-bom" class="space-y-6 animate-fade-in hidden">
                <div class="p-4 rounded-xl bg-surface-tint border border-gold-imperial/40 text-xs font-mono-data text-text-muted font-medium shadow-xs">
                    <span class="text-gold-champagne font-bold uppercase">Official On-Grid Quotation Bill of Materials:</span>
                    Every residential on-grid package includes our Grade-A 20-item hardware specification with comprehensive lightning protection (`LA 16mm AL Cable`), heavy-duty copper earthing (`3 Nos`), and high-grade structural cladding.
                </div>

                <div class="luxury-card rounded-3xl p-6 md:p-8 border border-gold-imperial/40 overflow-x-auto shadow-xl bg-white">
                    <table class="w-full text-left font-mono-data text-xs border-collapse min-w-[700px]">
                        <thead>
                            <tr class="border-b-2 border-gold-imperial/40 text-gold-champagne uppercase tracking-wider bg-surface-tint">
                                <th class="py-3 px-4 font-bold">Solar Equipment (20 Items)</th>
                                <th class="py-3 px-4 font-bold text-center">3 kW</th>
                                <th class="py-3 px-4 font-bold text-center">4 kW</th>
                                <th class="py-3 px-4 font-bold text-center">5 kW</th>
                                <th class="py-3 px-4 font-bold text-center">7 kW</th>
                                <th class="py-3 px-4 font-bold text-center">10 kW</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border-light text-navy-deep font-medium">
                            <tr class="hover:bg-surface-tint/60 transition-colors">
                                <td class="py-3 px-4 font-bold text-navy-deep">Number of Panels (`550W / 615W`)</td>
                                <td class="py-3 px-4 text-center">550W (`6 Nos`) / 615W (`5 Nos`)</td>
                                <td class="py-3 px-4 text-center">550W (`7 Nos`) / 615W (`8 Nos`)</td>
                                <td class="py-3 px-4 text-center">550W (`10 Nos`) / 615W (`9 Nos`)</td>
                                <td class="py-3 px-4 text-center">550W (`13 Nos`) / 615W (`12 Nos`)</td>
                                <td class="py-3 px-4 text-center font-bold text-gold-champagne">550W (`19 Nos`) / 615W (`17 Nos`)</td>
                            </tr>
                            <tr class="hover:bg-surface-tint/60 transition-colors">
                                <td class="py-3 px-4 text-navy-deep font-semibold">MC 4 Connector</td>
                                <td class="py-3 px-4 text-center">4 Nos</td>
                                <td class="py-3 px-4 text-center">6 Nos</td>
                                <td class="py-3 px-4 text-center">8 Nos</td>
                                <td class="py-3 px-4 text-center">10 Nos</td>
                                <td class="py-3 px-4 text-center">16 Nos</td>
                            </tr>
                            <tr class="hover:bg-surface-tint/60 transition-colors">
                                <td class="py-3 px-4 text-navy-deep font-bold">Inverter (`Feston / Havells / Waaree`)</td>
                                <td class="py-3 px-4 text-center">1 Nos</td>
                                <td class="py-3 px-4 text-center">1 Nos</td>
                                <td class="py-3 px-4 text-center">1 Nos</td>
                                <td class="py-3 px-4 text-center">1 Nos</td>
                                <td class="py-3 px-4 text-center">1 Nos</td>
                            </tr>
                            <tr class="hover:bg-surface-tint/60 transition-colors">
                                <td class="py-3 px-4">Energy Meter</td>
                                <td class="py-3 px-4 text-center">1 Nos</td>
                                <td class="py-3 px-4 text-center">1 Nos</td>
                                <td class="py-3 px-4 text-center">1 Nos</td>
                                <td class="py-3 px-4 text-center">1 Nos</td>
                                <td class="py-3 px-4 text-center">1 Nos</td>
                            </tr>
                            <tr class="hover:bg-surface-tint/60 transition-colors">
                                <td class="py-3 px-4 text-navy-deep font-semibold">Havells MCB</td>
                                <td class="py-3 px-4 text-center">1 Nos</td>
                                <td class="py-3 px-4 text-center">1 Nos</td>
                                <td class="py-3 px-4 text-center">1 Nos</td>
                                <td class="py-3 px-4 text-center">1 Nos</td>
                                <td class="py-3 px-4 text-center">1 Nos</td>
                            </tr>
                            <tr class="hover:bg-surface-tint/60 transition-colors">
                                <td class="py-3 px-4">ACDB & DCDB Boxes</td>
                                <td class="py-3 px-4 text-center">1 Nos Each</td>
                                <td class="py-3 px-4 text-center">1 Nos Each</td>
                                <td class="py-3 px-4 text-center">1 Nos Each</td>
                                <td class="py-3 px-4 text-center">1 Nos Each</td>
                                <td class="py-3 px-4 text-center">1 Nos Each</td>
                            </tr>
                            <tr class="hover:bg-surface-tint/60 transition-colors">
                                <td class="py-3 px-4 text-navy-deep font-bold">Structure (`Mono Rail / RCC GI`)</td>
                                <td class="py-3 px-4 text-center">Mono Rail / RCC GI</td>
                                <td class="py-3 px-4 text-center">Mono Rail / RCC GI</td>
                                <td class="py-3 px-4 text-center">Mono Rail / RCC GI</td>
                                <td class="py-3 px-4 text-center">Mono Rail / RCC GI</td>
                                <td class="py-3 px-4 text-center">Mono Rail / RCC GI</td>
                            </tr>
                            <tr class="hover:bg-surface-tint/60 transition-colors">
                                <td class="py-3 px-4 text-navy-deep font-semibold">Copper Earthing (`3 Nos`) & Chemical (`15kg x 3`)</td>
                                <td class="py-3 px-4 text-center">3 Nos + 3 Bags</td>
                                <td class="py-3 px-4 text-center">3 Nos + 3 Bags</td>
                                <td class="py-3 px-4 text-center">3 Nos + 3 Bags</td>
                                <td class="py-3 px-4 text-center">3 Nos + 3 Bags</td>
                                <td class="py-3 px-4 text-center">3 Nos + 3 Bags</td>
                            </tr>
                            <tr class="hover:bg-surface-tint/60 transition-colors">
                                <td class="py-3 px-4">Lightning Arrester (LA Set)</td>
                                <td class="py-3 px-4 text-center">1 Set</td>
                                <td class="py-3 px-4 text-center">1 Set</td>
                                <td class="py-3 px-4 text-center">1 Set</td>
                                <td class="py-3 px-4 text-center">1 Set</td>
                                <td class="py-3 px-4 text-center">1 Set</td>
                            </tr>
                            <tr class="hover:bg-surface-tint/60 transition-colors">
                                <td class="py-3 px-4 text-navy-deep font-semibold">4mm Copper AC/DC Cable</td>
                                <td class="py-3 px-4 text-center">30 Mtrs</td>
                                <td class="py-3 px-4 text-center">40 Mtrs</td>
                                <td class="py-3 px-4 text-center">50 Mtrs</td>
                                <td class="py-3 px-4 text-center">70 Mtrs</td>
                                <td class="py-3 px-4 text-center font-bold">100 Mtrs</td>
                            </tr>
                            <tr class="hover:bg-surface-tint/60 transition-colors">
                                <td class="py-3 px-4">Sub Meter (`1 Phase Madvij`)</td>
                                <td class="py-3 px-4 text-center">1 Nos</td>
                                <td class="py-3 px-4 text-center">1 Nos</td>
                                <td class="py-3 px-4 text-center">1 Nos</td>
                                <td class="py-3 px-4 text-center">1 Nos</td>
                                <td class="py-3 px-4 text-center">1 Nos</td>
                            </tr>
                            <tr class="hover:bg-surface-tint/60 transition-colors">
                                <td class="py-3 px-4">PVC Pipe & Flexible Pipe (`3m - 15m`)</td>
                                <td class="py-3 px-4 text-center">10 Nos + 3 Mtrs</td>
                                <td class="py-3 px-4 text-center">15 Nos + 5 Mtrs</td>
                                <td class="py-3 px-4 text-center">20 Nos + 10 Mtrs</td>
                                <td class="py-3 px-4 text-center">30 Nos + 12 Mtrs</td>
                                <td class="py-3 px-4 text-center">40 Nos + 15 Mtrs</td>
                            </tr>
                            <tr class="hover:bg-surface-tint/60 transition-colors">
                                <td class="py-3 px-4 text-navy-deep font-semibold">LA 16 mm AL Cable (`Omigold`)</td>
                                <td class="py-3 px-4 text-center">30 Mtrs</td>
                                <td class="py-3 px-4 text-center">40 Mtrs</td>
                                <td class="py-3 px-4 text-center">50 Mtrs</td>
                                <td class="py-3 px-4 text-center">70 Mtrs</td>
                                <td class="py-3 px-4 text-center font-bold">100 Mtrs</td>
                            </tr>
                            <tr class="hover:bg-surface-tint/60 transition-colors">
                                <td class="py-3 px-4">Panama MCB (`6 - 32 Amp Single Pole`)</td>
                                <td class="py-3 px-4 text-center">1 Nos</td>
                                <td class="py-3 px-4 text-center">1 Nos</td>
                                <td class="py-3 px-4 text-center">1 Nos</td>
                                <td class="py-3 px-4 text-center">1 Nos</td>
                                <td class="py-3 px-4 text-center">1 Nos</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <script>
    function switchPriceTab(tabId) {
        // Hide all contents
        ['ongrid', 'hybrid', 'rodali', 'bom'].forEach(id => {
            document.getElementById('tab-content-' + id).classList.add('hidden');
            const btn = document.getElementById('tab-btn-' + id);
            btn.className = 'px-5 py-2.5 rounded-xl bg-white text-text-muted border border-border-light hover:bg-surface-tint hover:text-navy-deep transition-all uppercase tracking-wider font-semibold';
        });
        // Show active content
        document.getElementById('tab-content-' + tabId).classList.remove('hidden');
        const activeBtn = document.getElementById('tab-btn-' + tabId);
        activeBtn.className = 'px-5 py-2.5 rounded-xl bg-gold-imperial text-navy-deep font-bold transition-all uppercase tracking-wider shadow-md';
    }
    </script>

    <!-- Document Checklist (`#checklist`) -->
    <section id="checklist" class="py-24 px-6 md:px-12 bg-surface-tint animate-on-scroll">
        <div class="max-w-container-max mx-auto">
            <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6">
                <div>
                    <span class="font-label-caps text-gold-champagne font-bold uppercase tracking-widest block mb-2">Complete Digital Onboarding</span>
                    <h2 class="font-display text-3xl md:text-headline-h2 text-navy-deep font-bold">8 Mandatory Verification Documents</h2>
                </div>
                <a href="<?= site_url('public/about.php#calculator') ?>" class="font-label-caps text-navy-primary font-bold hover:text-gold-champagne flex items-center gap-2 border-b border-gold-imperial pb-1 transition-colors uppercase tracking-wider">
                    Go to Subsidy Calculator &rarr;
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="p-6 rounded-xl bg-white border border-gold-imperial/30 hover:border-gold-imperial hover:shadow-md transition-all shadow-xs">
                    <span class="font-mono-data text-xs text-gold-champagne font-bold block mb-2">DOCUMENT 01</span>
                    <h4 class="font-display font-bold text-navy-deep text-base mb-1">Aadhaar Card</h4>
                    <p class="text-xs text-text-muted font-medium leading-relaxed">Identity verification linked with mobile OTP for portal login.</p>
                </div>
                <div class="p-6 rounded-xl bg-white border border-gold-imperial/30 hover:border-gold-imperial hover:shadow-md transition-all shadow-xs">
                    <span class="font-mono-data text-xs text-gold-champagne font-bold block mb-2">DOCUMENT 02</span>
                    <h4 class="font-display font-bold text-navy-deep text-base mb-1">PAN Card</h4>
                    <p class="text-xs text-text-muted font-medium leading-relaxed">Tax and financial credit tracking on government portal.</p>
                </div>
                <div class="p-6 rounded-xl bg-white border border-gold-imperial/30 hover:border-gold-imperial hover:shadow-md transition-all shadow-xs">
                    <span class="font-mono-data text-xs text-gold-champagne font-bold block mb-2">DOCUMENT 03</span>
                    <h4 class="font-display font-bold text-navy-deep text-base mb-1">Bank Passbook</h4>
                    <p class="text-xs text-text-muted font-medium leading-relaxed">Clear account details for direct transfer of ₹1,30,800.</p>
                </div>
                <div class="p-6 rounded-xl bg-white border border-gold-imperial/30 hover:border-gold-imperial hover:shadow-md transition-all shadow-xs">
                    <span class="font-mono-data text-xs text-gold-champagne font-bold block mb-2">DOCUMENT 04</span>
                    <h4 class="font-display font-bold text-navy-deep text-base mb-1">Electric Bill Statement</h4>
                    <p class="text-xs text-text-muted font-medium leading-relaxed">Latest residential bill showing consumer ID and DISCOM.</p>
                </div>
                <div class="p-6 rounded-xl bg-white border border-gold-imperial/30 hover:border-gold-imperial hover:shadow-md transition-all shadow-xs">
                    <span class="font-mono-data text-xs text-gold-champagne font-bold block mb-2">DOCUMENT 05</span>
                    <h4 class="font-display font-bold text-navy-deep text-base mb-1">Mobile & Email ID</h4>
                    <p class="text-xs text-text-muted font-medium leading-relaxed">Active contact credentials for status notifications.</p>
                </div>
                <div class="p-6 rounded-xl bg-white border border-gold-imperial/30 hover:border-gold-imperial hover:shadow-md transition-all shadow-xs">
                    <span class="font-mono-data text-xs text-gold-champagne font-bold block mb-2">DOCUMENT 06</span>
                    <h4 class="font-display font-bold text-navy-deep text-base mb-1">GPS Home Photo</h4>
                    <p class="text-xs text-text-muted font-medium leading-relaxed">Captured by our surveyor with customer standing in front of property.</p>
                </div>
                <div class="p-6 rounded-xl bg-white border border-gold-imperial/30 hover:border-gold-imperial hover:shadow-md transition-all sm:col-span-2 shadow-xs">
                    <span class="font-mono-data text-xs text-gold-champagne font-bold block mb-2">DOCUMENT 07 & 08</span>
                    <h4 class="font-display font-bold text-navy-deep text-base mb-1">Land Document (Jamabandi / Khajna Receipt)</h4>
                    <p class="text-xs text-text-muted font-medium leading-relaxed">Official property records confirming roof or plot ownership rights for long-term installation.</p>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include_once __DIR__ . '/includes/landing_footer.php'; ?>
