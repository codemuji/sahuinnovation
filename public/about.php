<?php
$pageTitle = "Company & Philosophy";
include_once __DIR__ . '/includes/landing_header.php';
?>

<main class="relative z-10 overflow-hidden">
    <!-- Hero Section: Brand & Philosophy -->
    <header class="relative pt-20 pb-24 md:pt-28 md:pb-32 px-6 md:px-12 bg-obsidian-deep bg-grid-pattern border-b border-gold-imperial/20 overflow-hidden">
        <!-- Ambient Gold Glows -->
        <div class="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[350px] bg-gold-imperial/10 rounded-full blur-[140px] pointer-events-none"></div>
        <div class="absolute bottom-0 right-10 w-[400px] h-[250px] bg-cyan-pulse/5 rounded-full blur-[120px] pointer-events-none"></div>
        
        <div class="max-w-container-max mx-auto grid grid-cols-1 lg:grid-cols-12 gap-12 items-center relative z-10 animate-on-scroll">
            <div class="lg:col-span-7">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-charcoal-surface border border-gold-imperial/30 text-gold-champagne font-mono-data text-xs uppercase tracking-widest mb-6">
                    <span class="material-symbols-outlined text-sm text-gold-imperial">architecture</span>
                    Architectural Solar Engineering
                </div>
                <h1 class="font-display text-4xl sm:text-5xl lg:text-6xl text-white mb-6 font-bold tracking-tight leading-[1.1]">
                    Where Architectural Cladding Meets
                    <span class="block mt-2 font-serif-title italic font-normal text-2xl sm:text-3xl lg:text-4xl text-gold-champagne tracking-wide leading-tight">
                        Zero-Cost Lifetime Energy.
                    </span>
                </h1>
                <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl mb-8">
                    We believe sustainable architecture should never demand aesthetic compromise. Sahu Innovation integrates high-performance photovoltaic technology into the fabric of premium living—guaranteeing lifetime electricity independence with zero down payment.
                </p>
                <div class="flex flex-wrap items-center gap-4">
                    <a href="#calculator" class="font-label-caps bg-gradient-to-r from-gold-imperial via-gold-champagne to-gold-imperial text-obsidian-deep font-bold px-8 py-4 rounded-xl hover:shadow-xl hover:shadow-gold-imperial/25 transition-all transform hover:-translate-y-0.5 uppercase tracking-wider">
                        Calculate Your Subsidy (₹1.3L)
                    </a>
                    <a href="#warranties" class="font-label-caps bg-charcoal-surface border border-gold-imperial/30 text-gold-champagne hover:bg-charcoal-light hover:text-white px-8 py-4 rounded-xl transition-all uppercase tracking-wider flex items-center gap-2">
                        <span>5-Year Legal Agreement</span>
                        <span class="material-symbols-outlined text-sm">arrow_downward</span>
                    </a>
                </div>
            </div>

            <!-- Floating Brand Showcase Card (`3D_logo.jpeg`) -->
            <div class="lg:col-span-5 relative">
                <div class="obsidian-card rounded-2xl p-6 md:p-8 relative overflow-hidden group shadow-2xl border border-gold-imperial/30">
                    <div class="absolute -right-12 -top-12 w-36 h-36 bg-gold-imperial/15 rounded-full blur-2xl group-hover:bg-gold-imperial/25 transition-all"></div>
                    <div class="relative z-10">
                        <div class="aspect-[16/11] rounded-xl overflow-hidden mb-6 border border-gold-imperial/25 shadow-inner bg-gradient-to-br from-[#0B0E14] via-[#141824] to-[#0B0E14] relative group flex items-center justify-center">
                            <img alt="Sahu Innovation 3D Embossed Luxury Logo" class="w-full h-full object-contain p-2 transition-transform duration-700 group-hover:scale-105 drop-shadow-2xl" src="<?= site_url('public/assets/img/3D_logo.jpeg') ?>"/>
                            <div class="absolute inset-0 bg-gradient-to-t from-obsidian-deep/70 via-transparent to-transparent pointer-events-none"></div>
                            <div class="absolute bottom-3 left-3.5 flex items-center gap-2 px-3 py-1 rounded-full bg-obsidian-deep/90 border border-gold-imperial/40 backdrop-blur-md z-10">
                                <span class="w-2 h-2 rounded-full bg-emerald-trust animate-pulse"></span>
                                <span class="font-mono-data text-[11px] text-gold-champagne font-semibold">Official 3D Brand Mark • Embossed Edition</span>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-3 pt-2 border-t border-outline-variant/30 text-center font-mono-data">
                            <div class="p-3 rounded-lg bg-charcoal-light/60 border border-gold-imperial/15">
                                <div class="text-xs text-gold-champagne font-bold">25 YEARS</div>
                                <div class="text-[11px] text-on-surface-variant mt-0.5">Solar Panel Warranty</div>
                            </div>
                            <div class="p-3 rounded-lg bg-charcoal-light/60 border border-gold-imperial/15">
                                <div class="text-xs text-gold-champagne font-bold">10 YEARS</div>
                                <div class="text-[11px] text-on-surface-variant mt-0.5">Inverter Warranty</div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Architectural Accent Lines -->
                <div class="absolute -bottom-4 -left-4 w-20 h-20 border-l-2 border-b-2 border-gold-imperial/40 rounded-bl-2xl pointer-events-none hidden md:block"></div>
                <div class="absolute -top-4 -right-4 w-20 h-20 border-r-2 border-t-2 border-gold-imperial/40 rounded-tr-2xl pointer-events-none hidden md:block"></div>
            </div>
        </div>
    </header>

    <!-- Interactive Subsidy & ROI Calculator Section -->
    <section id="calculator" class="py-20 px-6 md:px-12 bg-charcoal-surface border-b border-gold-imperial/20 relative animate-on-scroll">
        <div class="max-w-container-max mx-auto">
            <div class="text-center max-w-3xl mx-auto mb-14">
                <span class="font-label-caps text-gold-imperial uppercase tracking-widest block mb-2">Real-Time Financial Engine</span>
                <h2 class="font-display text-3xl md:text-headline-h2 text-white font-bold mb-4">
                    Calculate Your PM Surya Ghar Benefits
                </h2>
                <p class="font-body-md text-on-surface-variant">
                    Adjust your required capacity or monthly electricity consumption to see exact government subsidy credits (`₹1,30,800`), monthly unit generation, and easy EMI installment projections.
                </p>
            </div>

            <div class="obsidian-card rounded-2xl p-6 md:p-12 border border-gold-imperial/30 shadow-2xl grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
                <!-- Left: Controls -->
                <div class="lg:col-span-6 space-y-8">
                    <div>
                        <div class="flex justify-between items-center mb-3">
                            <label class="font-display font-semibold text-white text-lg flex items-center gap-2">
                                <span class="material-symbols-outlined text-gold-imperial">solar_power</span>
                                Select System Capacity (Flagship 3kW)
                            </label>
                            <span id="capacityValue" class="font-mono-data text-xl font-bold text-gold-champagne bg-charcoal-light px-4 py-1.5 rounded-lg border border-gold-imperial/30">3 kW</span>
                        </div>
                        <input id="capacitySlider" type="range" min="1" max="10" step="0.5" value="3" class="w-full h-2.5 bg-charcoal-light rounded-lg appearance-none cursor-pointer accent-gold-imperial"/>
                        <div class="flex justify-between text-xs font-mono-data text-on-surface-variant mt-2">
                            <span>1 kW (Compact)</span>
                            <span class="text-gold-imperial font-semibold">3 kW (Recommended Flagship)</span>
                            <span>10 kW (Commercial/Large)</span>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between items-center mb-3">
                            <label class="font-display font-semibold text-white text-lg flex items-center gap-2">
                                <span class="material-symbols-outlined text-gold-imperial">electric_bolt</span>
                                Current Monthly Electric Bill (Average)
                            </label>
                            <span id="billValue" class="font-mono-data text-xl font-bold text-white bg-charcoal-light px-4 py-1.5 rounded-lg border border-outline-variant/40">₹ 3,500</span>
                        </div>
                        <input id="billSlider" type="range" min="1000" max="15000" step="500" value="3500" class="w-full h-2.5 bg-charcoal-light rounded-lg appearance-none cursor-pointer accent-gold-imperial"/>
                        <div class="flex justify-between text-xs font-mono-data text-on-surface-variant mt-2">
                            <span>₹1,000 / mo</span>
                            <span>₹7,500 / mo</span>
                            <span>₹15,000 / mo</span>
                        </div>
                    </div>

                    <div class="p-4 rounded-xl bg-obsidian-deep border border-gold-imperial/20">
                        <div class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-emerald-trust text-2xl shrink-0 mt-0.5">task_alt</span>
                            <div class="text-xs text-on-surface-variant space-y-1 font-mono-data">
                                <div class="text-white font-semibold">Guaranteed Government Processing Timeline:</div>
                                <div>• <strong class="text-gold-champagne">Central Subsidy (₹85,800):</strong> Credited directly to bank passbook within <span class="text-white">30 days</span>.</div>
                                <div>• <strong class="text-gold-champagne">State Subsidy (₹45,000):</strong> Credited within <span class="text-white">60 to 180 days</span>.</div>
                                <div>• Monthly fixed load charge: Only <span class="text-white">₹210</span> on 3kW systems.</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Live Financial Breakdown -->
                <div class="lg:col-span-6 bg-obsidian-deep/90 rounded-2xl p-6 md:p-8 border border-gold-imperial/30 flex flex-col justify-between space-y-6">
                    <div class="flex justify-between items-center border-b border-outline-variant/30 pb-4">
                        <span class="font-display text-on-surface-variant text-sm font-medium uppercase tracking-wider">Estimated Financial Impact</span>
                        <span class="px-2.5 py-1 rounded bg-emerald-trust/20 text-emerald-trust border border-emerald-trust/40 text-xs font-mono-data font-bold">ZERO DOWN PAYMENT</span>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-4 rounded-xl bg-charcoal-surface border border-gold-imperial/15">
                            <div class="text-xs font-mono-data text-on-surface-variant uppercase">Total Govt Subsidy</div>
                            <div id="calcSubsidy" class="text-2xl sm:text-3xl font-display font-bold text-gold-imperial mt-1">₹ 1,30,800</div>
                            <div id="calcSubsidyBreakdown" class="text-[11px] font-mono-data text-emerald-trust mt-1">₹85.8K Central + ₹45K State</div>
                        </div>
                        <div class="p-4 rounded-xl bg-charcoal-surface border border-gold-imperial/15">
                            <div class="text-xs font-mono-data text-on-surface-variant uppercase">Monthly Generation</div>
                            <div id="calcUnits" class="text-2xl sm:text-3xl font-display font-bold text-white mt-1">300 Units</div>
                            <div class="text-[11px] font-mono-data text-cyan-pulse mt-1">~10 Units Daily Output</div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-4 rounded-xl bg-charcoal-surface border border-gold-imperial/15">
                            <div class="text-xs font-mono-data text-on-surface-variant uppercase">New Electric Bill</div>
                            <div id="calcNewBill" class="text-2xl sm:text-3xl font-display font-bold text-emerald-trust mt-1">₹ 0.00</div>
                            <div class="text-[11px] font-mono-data text-on-surface-variant mt-1">Rest sold @ ₹5.30/unit</div>
                        </div>
                        <div class="p-4 rounded-xl bg-charcoal-surface border border-gold-imperial/15">
                            <div class="text-xs font-mono-data text-on-surface-variant uppercase">Easy EMI Option</div>
                            <div id="calcEmi" class="text-2xl sm:text-3xl font-display font-bold text-gold-champagne mt-1">₹ 2,100 /mo</div>
                            <div class="text-[11px] font-mono-data text-on-surface-variant mt-1">Over 2.5 Years (30 Mos)</div>
                        </div>
                    </div>

                    <div class="pt-2 border-t border-outline-variant/30 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div>
                            <div class="text-xs font-mono-data text-on-surface-variant">Annual Net Savings:</div>
                            <div id="calcSavings" class="text-xl font-display font-bold text-white">₹ 22,500 / year</div>
                        </div>
                        <a href="<?= site_url('public/login.php') ?>" class="w-full sm:w-auto text-center font-label-caps bg-gradient-to-r from-gold-imperial via-gold-champagne to-gold-imperial text-obsidian-deep font-bold px-6 py-3 rounded-lg hover:shadow-lg hover:shadow-gold-imperial/30 transition-all uppercase tracking-wider">
                            Apply For Subsidy Now
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Editorial Narrative & Architectural Cladding Section -->
    <section class="py-24 px-6 md:px-12 bg-obsidian-deep border-b border-gold-imperial/20 animate-on-scroll">
        <div class="max-w-container-max mx-auto grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <div class="lg:col-span-6 relative">
                <div class="aspect-[4/3] rounded-2xl overflow-hidden ambient-shadow border border-gold-imperial/30 relative group">
                    <img alt="Architectural detail of premium black monocrystalline photovoltaic solar cells with refined gold grid lines" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" src="<?= site_url('public/assets/img/solar_cladding.png') ?>"/>
                    <div class="absolute inset-0 bg-gradient-to-t from-obsidian-deep/80 via-transparent to-transparent"></div>
                    <div class="absolute bottom-4 left-4 right-4 p-4 rounded-xl bg-obsidian-deep/90 border border-gold-imperial/30 backdrop-blur-md">
                        <div class="font-display font-bold text-white text-sm">Grade-A Monocrystalline Perc Technology</div>
                        <div class="text-xs text-gold-champagne font-mono-data mt-0.5">Matte black edge-to-edge finish engineered to complement luxury facades.</div>
                    </div>
                </div>
                <div class="absolute -right-6 top-1/2 w-12 h-12 rounded-full bg-gold-imperial/20 border border-gold-imperial hidden lg:flex items-center justify-center -translate-y-1/2 shadow-xl">
                    <span class="material-symbols-outlined text-gold-imperial">light_mode</span>
                </div>
            </div>

            <div class="lg:col-span-6 space-y-6">
                <span class="font-label-caps text-gold-imperial uppercase tracking-widest block">Our Core Philosophy</span>
                <h2 class="font-display text-3xl md:text-headline-h2 text-white font-bold">
                    A Legacy of Light, Material & Precision
                </h2>
                <div class="font-body-md text-on-surface-variant space-y-4 leading-relaxed">
                    <p>
                        Founded on the conviction that renewable energy should elevate the structural harmony of the properties we inhabit, Sahu Innovation began as a premier architectural engineering studio bridging high-tech utility and luxury design.
                    </p>
                    <p>
                        While conventional contractors treat solar installations as utilitarian equipment piled onto rooftops, our approach is transformative. We engineer solar arrays as <strong class="text-white">integrated architectural cladding</strong>—surfaces that generate clean power while reflecting the sophisticated taste of our clients.
                    </p>
                    <p>
                        Today, every property we outfit benefits from our zero-down-payment financial models and express government subsidy tracking, ensuring that sustainability is both an aesthetic triumph and an extraordinary financial investment.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Asymmetrical Architectural & Legal Guarantees Showcase (`#warranties`) -->
    <section id="warranties" class="py-24 px-6 md:px-12 bg-charcoal-surface border-b border-gold-imperial/20 animate-on-scroll relative">
        <div class="max-w-container-max mx-auto">
            <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6 border-b border-outline-variant/20 pb-8">
                <div>
                    <span class="font-mono-data text-xs text-gold-imperial uppercase tracking-[0.25em] block mb-2">Unmatched Protection & Engineering</span>
                    <h2 class="font-display text-3xl md:text-5xl text-white font-bold tracking-tight">
                        On-Grid & Hybrid Systems
                        <span class="block font-serif-title italic text-2xl md:text-3xl text-gold-champagne font-normal mt-1">With Explicit Legal Guarantees.</span>
                    </h2>
                </div>
                <p class="font-body-md text-on-surface-variant max-w-md text-right hidden md:block">
                    Sahu Innovation eliminates all financial and technical anxiety with binding 5-year legal guarantees.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">
                <!-- Card 01: On-Grid Flagship System (`col-span-7`) -->
                <div class="lg:col-span-7 p-8 md:p-14 obsidian-card rounded-3xl border border-gold-imperial/40 relative overflow-hidden group flex flex-col justify-between shadow-2xl">
                    <div class="absolute -right-6 -bottom-10 font-mono-data text-[180px] leading-none text-gold-imperial/[0.07] font-bold select-none pointer-events-none group-hover:text-gold-imperial/[0.12] transition-colors">01</div>
                    <div class="relative z-10">
                        <span class="font-mono-data text-xs text-gold-imperial tracking-[0.25em] uppercase block mb-4 border-l-2 border-gold-imperial pl-3">Flagship Capability</span>
                        <h3 class="font-display text-3xl sm:text-4xl text-white font-bold mb-6 max-w-lg leading-tight">On-Grid Solar Power (3kW)</h3>
                        <p class="font-body-lg text-on-surface-variant text-base leading-relaxed max-w-xl mb-8">
                            Works in direct synchronization with the national grid. Generates an average of <strong class="text-white">300 units monthly (10 units daily)</strong>, instantly offsetting household consumption to zero while enabling profitable excess export credits.
                        </p>
                        <ul class="space-y-3 font-mono-data text-xs text-on-surface/90 pt-6 border-t border-gold-imperial/20">
                            <li class="flex items-center gap-2.5">
                                <span class="w-2 h-2 rounded-full bg-emerald-trust"></span>
                                <span><strong class="text-white">Zero Installation Charges:</strong> No surprise labor costs.</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <span class="w-2 h-2 rounded-full bg-emerald-trust"></span>
                                <span><strong class="text-white">₹20,000 - ₹25,000</strong> Guaranteed Annual Savings.</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <span class="w-2 h-2 rounded-full bg-emerald-trust"></span>
                                <span>Direct Net Metering Export @ <strong class="text-gold-champagne">₹5.30/unit</strong>.</span>
                            </li>
                        </ul>
                    </div>
                    <div class="mt-10 pt-6 border-t border-gold-imperial/20 relative z-10 flex items-center justify-between">
                        <span class="font-mono-data text-xs text-gold-imperial font-bold tracking-wider">25-YEAR PANEL • 10-YEAR INVERTER WARRANTY</span>
                    </div>
                </div>

                <!-- Right Editorial Stack (`col-span-5`) -->
                <div class="lg:col-span-5 flex flex-col gap-8 justify-between">
                    <!-- Card 02: Hybrid Solar Storage -->
                    <div class="p-8 md:p-10 obsidian-card rounded-3xl border border-cyan-pulse/30 relative overflow-hidden group flex-1 flex flex-col justify-between shadow-xl">
                        <div class="absolute right-6 top-6 font-mono-data text-5xl text-cyan-pulse/15 font-bold select-none pointer-events-none">02</div>
                        <div class="relative z-10 pr-12">
                            <span class="font-mono-data text-[11px] text-cyan-pulse uppercase tracking-widest block mb-2">Blackout Protection</span>
                            <h3 class="font-display text-2xl text-white font-bold mb-3">Hybrid Solar Storage</h3>
                            <p class="font-body-md text-on-surface-variant text-sm leading-relaxed mb-6">
                                Receive electricity directly from solar during peak sunlight, while flush-mounted solid-state battery banks power your home silently during grid failures.
                            </p>
                        </div>
                        <div class="font-mono-data text-xs text-cyan-pulse font-bold relative z-10 pt-4 border-t border-outline-variant/30">
                            Sculptural Solid-State Battery Backup Included
                        </div>
                    </div>

                    <!-- Card 03: 5-Year Legal Agreement -->
                    <div class="p-8 md:p-10 obsidian-card rounded-3xl border border-gold-imperial/30 relative overflow-hidden group flex-1 flex flex-col justify-between shadow-xl">
                        <div class="absolute right-6 top-6 font-mono-data text-5xl text-gold-imperial/15 font-bold select-none pointer-events-none">03</div>
                        <div class="relative z-10 pr-12">
                            <span class="font-mono-data text-[11px] text-gold-champagne uppercase tracking-widest block mb-2">Legal Protection</span>
                            <h3 class="font-display text-2xl text-white font-bold mb-3">5-Year Vendor Agreement</h3>
                            <p class="font-body-md text-on-surface-variant text-sm leading-relaxed mb-6">
                                We bind our installation quality, performance metrics, and zero-down-payment promises in an explicit 5-year official vendor contract.
                            </p>
                        </div>
                        <a href="<?= site_url('public/pm-surya-ghar.php') ?>" class="font-mono-data text-xs text-gold-champagne hover:underline flex items-center justify-between relative z-10 pt-4 border-t border-outline-variant/30">
                            <span>Review Legal Agreement Terms</span>
                            <span>&rarr;</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Surya Ghar Muft Bijli Yojana Document Checklist (`#checklist`) -->
    <section id="checklist" class="py-24 px-6 md:px-12 bg-obsidian-deep border-b border-gold-imperial/20 animate-on-scroll relative">
        <div class="max-w-container-max mx-auto grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
            <div class="lg:col-span-5 space-y-6">
                <span class="font-mono-data text-xs text-gold-imperial uppercase tracking-[0.25em] block border-l-2 border-gold-imperial pl-3">Assisted Digital Intake</span>
                <h2 class="font-display text-3xl sm:text-4xl text-white font-bold tracking-tight">
                    PM Surya Ghar Document Checklist
                </h2>
                <p class="font-body-md text-on-surface-variant leading-relaxed">
                    To apply for the PM Surya Ghar Muft Bijli Yojana and secure your <strong class="text-white">₹1,30,800 direct passbook subsidy</strong>, our team requires only 8 straightforward documents. We handle the entire portal verification, field survey, and bank account linking.
                </p>
                <div class="p-6 rounded-2xl bg-charcoal-surface border border-gold-imperial/30 shadow-2xl relative overflow-hidden group">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="material-symbols-outlined text-gold-imperial text-xl">engineering</span>
                        <span class="text-base font-display font-bold text-white">Assisted Field Surveyor Support</span>
                    </div>
                    <p class="text-xs text-on-surface-variant font-mono-data leading-relaxed">
                        Our verified field surveyors capture the mandatory GPS photo of your home and inspect your land document (`Jamabandi / Khajna Receipt`) to guarantee 100% portal approval.
                    </p>
                </div>
            </div>

            <!-- Architectural Document Grid (Editorial Rail Style) -->
            <div class="lg:col-span-7 grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="border-l-2 border-gold-imperial/40 pl-6 py-2.5 relative group hover:border-gold-imperial transition-colors">
                    <div class="font-mono-data text-xs text-gold-champagne font-bold tracking-wider mb-1">01 • IDENTITY</div>
                    <h4 class="font-display text-lg text-white font-bold mb-1">Aadhaar Card</h4>
                    <p class="text-xs text-on-surface-variant leading-relaxed">Proof of identity for primary property owner.</p>
                </div>

                <div class="border-l-2 border-gold-imperial/40 pl-6 py-2.5 relative group hover:border-gold-imperial transition-colors">
                    <div class="font-mono-data text-xs text-gold-champagne font-bold tracking-wider mb-1">02 • TAX RECORD</div>
                    <h4 class="font-display text-lg text-white font-bold mb-1">PAN Card</h4>
                    <p class="text-xs text-on-surface-variant leading-relaxed">Mandatory for central financial subsidy tracking.</p>
                </div>

                <div class="border-l-2 border-gold-imperial/40 pl-6 py-2.5 relative group hover:border-gold-imperial transition-colors">
                    <div class="font-mono-data text-xs text-gold-champagne font-bold tracking-wider mb-1">03 • DIRECT CREDIT</div>
                    <h4 class="font-display text-lg text-white font-bold mb-1">Bank Passbook Account</h4>
                    <p class="text-xs text-on-surface-variant leading-relaxed">Where your ₹1,30,800 subsidy is credited within 30 days.</p>
                </div>

                <div class="border-l-2 border-gold-imperial/40 pl-6 py-2.5 relative group hover:border-gold-imperial transition-colors">
                    <div class="font-mono-data text-xs text-gold-champagne font-bold tracking-wider mb-1">04 • CONSUMER RECORD</div>
                    <h4 class="font-display text-lg text-white font-bold mb-1">Electric Bill Statement</h4>
                    <p class="text-xs text-on-surface-variant leading-relaxed">Latest monthly statement showing consumer account number.</p>
                </div>

                <div class="border-l-2 border-gold-imperial/40 pl-6 py-2.5 relative group hover:border-gold-imperial transition-colors">
                    <div class="font-mono-data text-xs text-gold-champagne font-bold tracking-wider mb-1">05 • CONTACT</div>
                    <h4 class="font-display text-lg text-white font-bold mb-1">Mobile Number & Email ID</h4>
                    <p class="text-xs text-on-surface-variant leading-relaxed">Active contact for real-time OTP verification on portal.</p>
                </div>

                <div class="border-l-2 border-gold-imperial/40 pl-6 py-2.5 relative group hover:border-gold-imperial transition-colors">
                    <div class="font-mono-data text-xs text-gold-champagne font-bold tracking-wider mb-1">06 • SATELLITE SURVEY</div>
                    <h4 class="font-display text-lg text-white font-bold mb-1">GPS Photo with Home</h4>
                    <p class="text-xs text-on-surface-variant leading-relaxed">Customer standing in front of installation residence.</p>
                </div>

                <div class="border-l-2 border-gold-imperial/40 pl-6 py-2.5 sm:col-span-2 relative group hover:border-gold-imperial transition-colors">
                    <div class="font-mono-data text-xs text-gold-champagne font-bold tracking-wider mb-1">07 • PROPERTY VALIDATION</div>
                    <h4 class="font-display text-lg text-white font-bold mb-1">Land Document (Jamabandi / Khajna Receipt)</h4>
                    <p class="text-xs text-on-surface-variant leading-relaxed">Official holding record verifying lawful rooftop ownership rights for 25-year solar installation.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Milestones & Legacy Section -->
    <section class="py-24 px-6 md:px-12 bg-charcoal-surface animate-on-scroll">
        <div class="max-w-3xl mx-auto">
            <div class="text-center mb-16">
                <span class="font-label-caps text-gold-imperial uppercase tracking-widest block mb-2">The Sahu Trajectory</span>
                <h2 class="font-display text-3xl md:text-headline-h2 text-white font-bold">Pioneering Architectural Solar</h2>
                <div class="w-16 h-0.5 bg-gold-imperial mx-auto mt-6"></div>
            </div>

            <div class="space-y-12 relative before:absolute before:inset-0 before:ml-5 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gold-imperial/25">
                <!-- Milestone 1 -->
                <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full border-2 border-gold-imperial bg-obsidian-deep shadow-xl shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 absolute left-0 md:left-1/2 -translate-x-1/2 z-10">
                        <div class="w-3 h-3 bg-gold-imperial rounded-full"></div>
                    </div>
                    <div class="w-[calc(100%-4rem)] md:w-[calc(50%-3rem)] pl-8 md:pl-0 md:group-even:text-right md:group-odd:text-left obsidian-card p-6 rounded-xl border border-gold-imperial/20">
                        <div class="font-mono-data text-xs text-gold-imperial mb-1 font-bold">FOUNDATION</div>
                        <h4 class="font-display text-lg text-white font-bold mb-2">Engineering Excellence</h4>
                        <p class="font-body-md text-on-surface-variant text-sm">Sahu Innovation is established to eliminate the trade-off between clean energy generation and architectural beauty.</p>
                    </div>
                </div>

                <!-- Milestone 2 -->
                <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full border border-gold-imperial/50 bg-obsidian-deep shadow-xl shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 absolute left-0 md:left-1/2 -translate-x-1/2 z-10">
                        <div class="w-2.5 h-2.5 bg-gold-champagne rounded-full"></div>
                    </div>
                    <div class="w-[calc(100%-4rem)] md:w-[calc(50%-3rem)] pl-8 md:pl-0 md:group-even:text-right md:group-odd:text-left obsidian-card p-6 rounded-xl border border-gold-imperial/20">
                        <div class="font-mono-data text-xs text-gold-imperial mb-1 font-bold">ZERO DOWN PAYMENT</div>
                        <h4 class="font-display text-lg text-white font-bold mb-2">Financial Inclusion & 5-Yr Agreement</h4>
                        <p class="font-body-md text-on-surface-variant text-sm">Pioneered zero down payment structures and easy ₹2,100/mo EMI models supported by our binding 5-year legal vendor guarantee.</p>
                    </div>
                </div>

                <!-- Milestone 3 -->
                <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full border border-gold-imperial/50 bg-obsidian-deep shadow-xl shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 absolute left-0 md:left-1/2 -translate-x-1/2 z-10">
                        <div class="w-2.5 h-2.5 bg-cyan-pulse rounded-full"></div>
                    </div>
                    <div class="w-[calc(100%-4rem)] md:w-[calc(50%-3rem)] pl-8 md:pl-0 md:group-even:text-right md:group-odd:text-left obsidian-card p-6 rounded-xl border border-gold-imperial/20">
                        <div class="font-mono-data text-xs text-cyan-pulse mb-1 font-bold">PM SURYA GHAR INTEGRATION</div>
                        <h4 class="font-display text-lg text-white font-bold mb-2">National Subsidy Leadership</h4>
                        <p class="font-body-md text-on-surface-variant text-sm">Full digital integration for express ₹1,30,800 subsidy processing, ensuring central and state credits land directly in customer bank passbooks.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
// Live Interactive Subsidy & ROI Calculator Script
document.addEventListener('DOMContentLoaded', () => {
    const capacitySlider = document.getElementById('capacitySlider');
    const billSlider = document.getElementById('billSlider');
    const capacityValue = document.getElementById('capacityValue');
    const billValue = document.getElementById('billValue');
    
    const calcSubsidy = document.getElementById('calcSubsidy');
    const calcSubsidyBreakdown = document.getElementById('calcSubsidyBreakdown');
    const calcUnits = document.getElementById('calcUnits');
    const calcNewBill = document.getElementById('calcNewBill');
    const calcEmi = document.getElementById('calcEmi');
    const calcSavings = document.getElementById('calcSavings');

    function updateCalculator() {
        if (!capacitySlider || !billSlider) return;
        const kw = parseFloat(capacitySlider.value);
        const bill = parseFloat(billSlider.value);

        // Update Slider Labels & Visual Track Fill
        capacityValue.textContent = kw + ' kW';
        billValue.textContent = '₹ ' + bill.toLocaleString('en-IN');

        const kwPct = ((kw - 1) / (10 - 1)) * 100;
        capacitySlider.style.background = `linear-gradient(to right, #D4AF37 ${kwPct}%, #141824 ${kwPct}%)`;

        const billPct = ((bill - 1000) / (15000 - 1000)) * 100;
        billSlider.style.background = `linear-gradient(to right, #D4AF37 ${billPct}%, #141824 ${billPct}%)`;

        // Subsidy logic: PM Surya Ghar central + state proportional exact breakdown
        let subsidy = 130800;
        let breakdownText = '₹85.8K Central + ₹45K State';
        if (kw === 1) {
            subsidy = 43600;
            breakdownText = '₹30K Central + ₹13.6K State';
        } else if (kw === 1.5) {
            subsidy = 65400;
            breakdownText = '₹45K Central + ₹20.4K State';
        } else if (kw === 2) {
            subsidy = 87200;
            breakdownText = '₹60K Central + ₹27.2K State';
        } else if (kw === 2.5) {
            subsidy = 109000;
            breakdownText = '₹75K Central + ₹34K State';
        } else if (kw >= 3) {
            subsidy = 130800;
            breakdownText = '₹85.8K Central + ₹45K State';
        }

        calcSubsidy.textContent = '₹ ' + subsidy.toLocaleString('en-IN');
        if (calcSubsidyBreakdown) calcSubsidyBreakdown.textContent = breakdownText;

        // Units: ~100 units per kW per month
        const units = Math.round(kw * 100);
        calcUnits.textContent = units + ' Units';

        // New Bill: If units generated >= current bill equivalent (~₹8/unit average), new bill = 0
        const currentConsumption = bill / 8;
        if (units >= currentConsumption) {
            calcNewBill.textContent = '₹ 0.00';
            calcNewBill.className = 'text-2xl sm:text-3xl font-display font-bold text-emerald-trust mt-1';
        } else {
            const remainingUnits = currentConsumption - units;
            const remainingBill = Math.round(remainingUnits * 8);
            calcNewBill.textContent = '₹ ' + remainingBill.toLocaleString('en-IN');
            calcNewBill.className = 'text-2xl sm:text-3xl font-display font-bold text-white mt-1';
        }

        // EMI option: proportional to capacity (3kW = ₹2,100 to ₹2,500/mo for 30 mos)
        const emi = Math.round((kw / 3) * 2100);
        calcEmi.textContent = '₹ ' + emi.toLocaleString('en-IN') + ' /mo';

        // Annual Net Savings: ~₹7,500 per kW
        const annualSavings = Math.min(bill * 12, Math.round(kw * 7500));
        calcSavings.textContent = '₹ ' + annualSavings.toLocaleString('en-IN') + ' / year';
    }

    if (capacitySlider && billSlider) {
        capacitySlider.addEventListener('input', updateCalculator);
        billSlider.addEventListener('input', updateCalculator);
        updateCalculator();
    }
});
</script>

<?php include_once __DIR__ . '/includes/landing_footer.php'; ?>
