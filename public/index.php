<?php
$pageTitle = "Architectural Solar Excellence";
include_once __DIR__ . '/includes/landing_header.php';
?>

<main class="relative z-10 overflow-hidden">
    <!-- Hero Section -->
    <section class="relative pt-12 pb-24 px-6 md:px-12 max-w-container-max mx-auto overflow-hidden">
        <!-- Ambient Lighting Glow -->
        <div class="absolute top-20 right-1/4 w-[500px] h-[300px] bg-gold-imperial/10 rounded-full blur-[140px] pointer-events-none"></div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center animate-on-scroll">
            <!-- Left Narrative -->
            <div class="lg:col-span-6 flex flex-col items-start z-10">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-charcoal-surface border border-gold-imperial/30 text-gold-champagne font-mono-data text-xs uppercase tracking-widest mb-6">
                    <span class="material-symbols-outlined text-sm text-gold-imperial">verified</span>
                    Govt Approved • Zero Down Payment
                </div>
                <h1 class="font-display text-4xl sm:text-5xl lg:text-6xl text-white mb-6 font-bold tracking-tight leading-[1.1]">
                    Get Free Electricity for Life.
                    <span class="block mt-2 font-serif-title italic font-normal text-2xl sm:text-3xl lg:text-4xl text-gold-champagne tracking-wide leading-tight">
                        Claim Your ₹1,30,800 Direct Passbook Subsidy.
                    </span>
                </h1>
                <p class="font-body-lg text-body-lg text-on-surface-variant mb-8 max-w-xl">
                    Harness the precision of modern architectural solar cladding. Eliminate utility bills forever while elevating property aesthetics with guaranteed 25-year performance.
                </p>
                <div class="flex flex-wrap gap-4 w-full sm:w-auto">
                    <a href="<?= site_url('public/about.php#calculator') ?>" class="font-label-caps bg-gradient-to-r from-gold-imperial via-gold-champagne to-gold-imperial text-obsidian-deep font-bold px-8 py-4 rounded-xl hover:shadow-xl hover:shadow-gold-imperial/25 transition-all transform hover:-translate-y-0.5 uppercase tracking-wider text-center">
                        Calculate Subsidy & ROI
                    </a>
                    <a href="<?= site_url('public/about.php') ?>" class="font-label-caps bg-charcoal-surface border border-gold-imperial/30 text-gold-champagne hover:bg-charcoal-light hover:text-white px-8 py-4 rounded-xl transition-all uppercase tracking-wider text-center flex items-center justify-center gap-2">
                        <span>Explore 3D Brand & About</span>
                        <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </a>
                </div>

                <!-- Key Stat Pills -->
                <div class="grid grid-cols-3 gap-4 mt-10 pt-8 border-t border-outline-variant/30 w-full font-mono-data">
                    <div>
                        <div class="text-xl font-display font-bold text-white">300 Units</div>
                        <div class="text-[11px] text-gold-champagne">Monthly Free Baseline</div>
                    </div>
                    <div>
                        <div class="text-xl font-display font-bold text-emerald-trust">₹ 0.00</div>
                        <div class="text-[11px] text-on-surface-variant">Target Electric Bill</div>
                    </div>
                    <div>
                        <div class="text-xl font-display font-bold text-white">₹ 2,100</div>
                        <div class="text-[11px] text-on-surface-variant">Starting Monthly EMI</div>
                    </div>
                </div>
            </div>

            <!-- Right Visual: Luxury Solar Villa Illustration (`luxury_hero.png`) -->
            <div class="lg:col-span-6 relative mt-6 lg:mt-0">
                <div class="relative w-full aspect-[4/3] rounded-2xl overflow-hidden obsidian-card shadow-2xl border border-gold-imperial/30 group">
                    <img alt="Pristine luxury villa at dusk with seamless flush-mounted dark matte solar roofing and warm champagne lighting" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" src="<?= site_url('public/assets/img/luxury_hero.png') ?>"/>
                    <div class="absolute inset-0 bg-gradient-to-t from-obsidian-deep/90 via-transparent to-transparent"></div>
                    
                    <!-- Floating Live Pulse Card -->
                    <div class="absolute bottom-4 left-4 right-4 sm:right-auto sm:max-w-sm p-4 rounded-xl bg-obsidian-deep/90 border border-gold-imperial/40 backdrop-blur-md shadow-2xl">
                        <div class="flex items-center justify-between mb-2">
                            <span class="font-mono-data text-[11px] text-gold-champagne font-semibold uppercase tracking-wider">Net Metering Status</span>
                            <span class="flex items-center gap-1.5 text-[11px] font-mono-data text-emerald-trust font-bold">
                                <span class="w-2 h-2 rounded-full bg-emerald-trust animate-pulse"></span>
                                GRID SYNCHRONIZED
                            </span>
                        </div>
                        <div class="text-sm font-display text-white font-bold">3kW Flagship System Active</div>
                        <div class="text-xs text-on-surface-variant mt-1 font-mono-data">Daily Generation: <strong class="text-white">10.2 Units</strong> • Export Rate: <strong class="text-gold-champagne">₹5.30/unit</strong></div>
                    </div>
                </div>
                <div class="absolute -right-4 -top-4 w-24 h-24 border-r-2 border-t-2 border-gold-imperial/40 rounded-tr-2xl pointer-events-none hidden md:block"></div>
            </div>
        </div>
    </section>

    <!-- Social Proof / Trust Strip -->
    <section class="w-full border-y border-gold-imperial/20 bg-charcoal-surface/60 py-10 animate-on-scroll">
        <div class="max-w-container-max mx-auto px-6 md:px-12 flex flex-col lg:flex-row items-center justify-between gap-8">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-gold-imperial text-3xl">workspace_premium</span>
                <div>
                    <div class="font-display font-bold text-white text-base">PM Surya Ghar Official Partner</div>
                    <div class="font-mono-data text-xs text-on-surface-variant">Guaranteed Direct Passbook Subsidy Processing</div>
                </div>
            </div>
            <div class="flex flex-wrap justify-center lg:justify-end gap-10 items-center w-full lg:w-auto opacity-75">
                <div class="text-center font-mono-data">
                    <span class="block text-gold-champagne font-bold text-lg">₹85,800</span>
                    <span class="text-[11px] text-on-surface-variant uppercase">Central Credit (30 Days)</span>
                </div>
                <div class="h-8 w-px bg-outline-variant/40 hidden sm:block"></div>
                <div class="text-center font-mono-data">
                    <span class="block text-gold-champagne font-bold text-lg">₹45,000</span>
                    <span class="text-[11px] text-on-surface-variant uppercase">State Credit (60-180 Days)</span>
                </div>
                <div class="h-8 w-px bg-outline-variant/40 hidden sm:block"></div>
                <div class="text-center font-mono-data">
                    <span class="block text-emerald-trust font-bold text-lg">₹1,30,800</span>
                    <span class="text-[11px] text-on-surface-variant uppercase">Total Govt Subsidy</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Architectural Portfolio Showcase (Breaking the Bento Grid & Boxed Icons) -->
    <section class="py-24 px-6 md:px-12 bg-obsidian-deep animate-on-scroll relative">
        <div class="max-w-container-max mx-auto">
            <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6 border-b border-outline-variant/20 pb-8">
                <div>
                    <span class="font-mono-data text-xs text-gold-imperial uppercase tracking-[0.25em] block mb-2">Architectural & Financial Excellence</span>
                    <h2 class="font-display text-3xl md:text-5xl text-white font-bold tracking-tight">
                        Why Homeowners Choose Sahu Innovation
                        <span class="block font-serif-title italic text-2xl md:text-3xl text-gold-champagne font-normal mt-1">Uncompromising Engineering Standards.</span>
                    </h2>
                </div>
                <a href="<?= site_url('public/about.php') ?>" class="font-label-caps text-gold-champagne hover:text-white flex items-center gap-2 border-b border-gold-imperial pb-1 transition-colors uppercase tracking-wider shrink-0">
                    Read Our Full Philosophy &rarr;
                </a>
            </div>

            <!-- Asymmetrical Editorial Showcase (`grid-cols-12`) -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">
                <!-- Left Hero Statement Card (`col-span-7`) -->
                <div class="lg:col-span-7 p-8 md:p-14 obsidian-card rounded-3xl border border-gold-imperial/40 relative overflow-hidden group flex flex-col justify-between shadow-2xl">
                    <div class="absolute -right-6 -bottom-10 font-mono-data text-[180px] leading-none text-gold-imperial/[0.07] font-bold select-none pointer-events-none group-hover:text-gold-imperial/[0.12] transition-colors">01</div>
                    <div class="relative z-10">
                        <span class="font-mono-data text-xs text-gold-imperial tracking-[0.25em] uppercase block mb-4 border-l-2 border-gold-imperial pl-3">Energy Autonomy</span>
                        <h3 class="font-display text-3xl sm:text-4xl text-white font-bold mb-6 max-w-lg leading-tight">300 Units Free Power Daily Baseline</h3>
                        <p class="font-body-lg text-on-surface-variant text-base leading-relaxed max-w-xl mb-10">
                            Our 3kW flagship system generates an average of <strong class="text-white">10 units daily</strong>, completely wiping out standard residential electricity consumption while paying you back for excess exports under national net metering guidelines.
                        </p>
                    </div>
                    
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-6 pt-6 border-t border-gold-imperial/20 font-mono-data relative z-10">
                        <div>
                            <div class="text-sm text-gold-champagne font-bold uppercase">Zero Cost</div>
                            <div class="text-[11px] text-on-surface-variant">Lifetime Solar Output</div>
                        </div>
                        <div>
                            <div class="text-sm text-emerald-trust font-bold uppercase">₹25K / Year</div>
                            <div class="text-[11px] text-on-surface-variant">Average Bill Savings</div>
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <a href="<?= site_url('public/about.php#calculator') ?>" class="text-xs text-white hover:text-gold-imperial flex items-center gap-1 pt-1 transition-colors">
                                <span>Calculate ROI</span>
                                <span class="material-symbols-outlined text-sm">arrow_forward</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Right Editorial Stack (`col-span-5`) -->
                <div class="lg:col-span-5 flex flex-col gap-8 justify-between">
                    <!-- Card 02: 5-Year Legal Agreement -->
                    <div class="p-8 md:p-10 obsidian-card rounded-3xl border border-gold-imperial/30 relative overflow-hidden group flex-1 flex flex-col justify-between shadow-xl">
                        <div class="absolute right-6 top-6 font-mono-data text-5xl text-gold-imperial/15 font-bold select-none pointer-events-none">02</div>
                        <div class="relative z-10 pr-12">
                            <span class="font-mono-data text-[11px] text-gold-champagne uppercase tracking-widest block mb-2">Binding Assurance</span>
                            <h3 class="font-display text-2xl text-white font-bold mb-3">5-Year Vendor Agreement</h3>
                            <p class="font-body-md text-on-surface-variant text-sm leading-relaxed mb-6">
                                We formalize our commitments with an explicit 5-year agreement: <strong class="text-white">Zero Installation Charges</strong>, zero surprise maintenance fees, and complete Grade-A hardware replacement protection.
                            </p>
                        </div>
                        <a href="<?= site_url('public/about.php#warranties') ?>" class="font-mono-data text-xs text-gold-champagne hover:underline flex items-center gap-1.5 relative z-10 pt-4 border-t border-outline-variant/30">
                            <span>Review Legal Details</span>
                            <span class="material-symbols-outlined text-sm">arrow_forward</span>
                        </a>
                    </div>

                    <!-- Card 03: Solid-State Hybrid Storage -->
                    <div class="p-8 md:p-10 obsidian-card rounded-3xl border border-cyan-pulse/30 relative overflow-hidden group flex-1 flex flex-col justify-between shadow-xl">
                        <div class="absolute right-6 top-6 font-mono-data text-5xl text-cyan-pulse/15 font-bold select-none pointer-events-none">03</div>
                        <div class="relative z-10 pr-12">
                            <span class="font-mono-data text-[11px] text-cyan-pulse uppercase tracking-widest block mb-2">24/7 Backup Capability</span>
                            <h3 class="font-display text-2xl text-white font-bold mb-3">Solid-State Hybrid Storage</h3>
                            <p class="font-body-md text-on-surface-variant text-sm leading-relaxed mb-6">
                                Beyond grid synchronization, we deploy sculptural solid-state battery modules engineered to mount flush on luxury garage walls for silent, uninterrupted blackout protection.
                            </p>
                        </div>
                        <a href="<?= site_url('public/about.php#warranties') ?>" class="font-mono-data text-xs text-cyan-pulse hover:underline flex items-center gap-1.5 relative z-10 pt-4 border-t border-outline-variant/30">
                            <span>Explore Hybrid Battery Tech</span>
                            <span class="material-symbols-outlined text-sm">arrow_forward</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Official Range of Systems Highlight Banner (`#systems-overview`) -->
    <section class="py-20 px-6 md:px-12 bg-gradient-to-b from-obsidian-deep to-charcoal-surface border-t border-gold-imperial/20 animate-on-scroll relative">
        <div class="max-w-container-max mx-auto">
            <div class="p-8 md:p-12 rounded-3xl bg-charcoal-surface border border-gold-imperial/30 shadow-2xl flex flex-col lg:flex-row items-center justify-between gap-10">
                <div class="space-y-4 max-w-2xl">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded bg-gold-imperial/15 border border-gold-imperial/40 text-gold-champagne font-mono-data text-xs uppercase tracking-widest">
                        <span class="material-symbols-outlined text-sm">wb_sunny</span>
                        Official Assam & Northeast Catalog
                    </div>
                    <h2 class="font-display text-3xl md:text-4xl text-white font-bold tracking-tight">
                        Explore Our Full Range of Solar Solutions.
                    </h2>
                    <p class="font-body-md text-on-surface-variant text-sm leading-relaxed">
                        From PM Surya Ghar On-Grid systems starting at <strong class="text-white">₹1,89,000/-</strong> (with ₹1.3L direct government subsidy) to 24/7 Solid-State Hybrid Backup systems and customized <strong class="text-white">Rodali Scheme Commercial Projects</strong> (`21kW+`), we deliver turnkey solar engineering across Assam.
                    </p>
                    <div class="font-mono-data text-xs text-gold-champagne pt-2 flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">location_on</span>
                        <span>Head Office: Shankardev Nagar Road, Dhanuhar Basti, Hojai, Pin 782435, Assam</span>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 w-full lg:w-auto shrink-0 font-mono-data text-xs">
                    <a href="<?= site_url('public/pm-surya-ghar.php#pricing-matrix') ?>" class="px-8 py-4 rounded-xl bg-gold-imperial text-obsidian-deep font-bold hover:bg-gold-champagne transition-all text-center uppercase tracking-wider shadow-xl flex items-center justify-center gap-2">
                        <span>View Complete Price Lists</span>
                        <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </a>
                    <a href="<?= site_url('public/about.php#leadership') ?>" class="px-8 py-4 rounded-xl bg-obsidian-deep text-gold-champagne border border-gold-imperial/30 hover:border-gold-imperial transition-all text-center uppercase tracking-wider flex items-center justify-center gap-2">
                        <span>Meet Board of Directors</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Architectural Intake Rail (Shatering 4 identical box cards) -->
    <section class="py-24 px-6 md:px-12 bg-charcoal-surface border-t border-gold-imperial/20 animate-on-scroll relative">
        <div class="max-w-container-max mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start mb-16">
                <div class="lg:col-span-5 space-y-4">
                    <span class="font-mono-data text-xs text-gold-imperial uppercase tracking-[0.25em] block border-l-2 border-gold-imperial pl-3">Streamlined Intake</span>
                    <h2 class="font-display text-3xl sm:text-4xl text-white font-bold tracking-tight">
                        Only 8 Documents Needed for Your ₹1.3L Subsidy
                    </h2>
                    <p class="font-body-md text-on-surface-variant leading-relaxed">
                        Our dedicated compliance team manages your complete government portal registration (`PM Surya Ghar`), GPS property survey, and express bank passbook linking.
                    </p>
                    <div class="pt-4">
                        <a href="<?= site_url('public/about.php#checklist') ?>" class="font-label-caps bg-charcoal-light border border-gold-imperial/40 text-gold-champagne hover:bg-gold-imperial hover:text-obsidian-deep px-6 py-3.5 rounded-xl transition-all uppercase tracking-wider inline-flex items-center gap-2">
                            <span>View Document Requirements</span>
                            <span class="material-symbols-outlined text-sm">arrow_forward</span>
                        </a>
                    </div>
                </div>

                <!-- 4-Stage Architectural Rail -->
                <div class="lg:col-span-7 grid grid-cols-1 sm:grid-cols-2 gap-8">
                    <div class="border-l-2 border-gold-imperial/40 pl-6 py-2 relative group hover:border-gold-imperial transition-colors">
                        <div class="font-mono-data text-xs text-gold-champagne font-bold tracking-wider mb-1">STAGE 01 • IDENTIFICATION</div>
                        <h4 class="font-display text-xl text-white font-bold mb-2">Aadhaar & PAN Verification</h4>
                        <p class="text-xs text-on-surface-variant leading-relaxed">Verified KYC records linked to property ownership for immediate central portal verification.</p>
                    </div>

                    <div class="border-l-2 border-gold-imperial/40 pl-6 py-2 relative group hover:border-gold-imperial transition-colors">
                        <div class="font-mono-data text-xs text-gold-champagne font-bold tracking-wider mb-1">STAGE 02 • DISBURSAL LINK</div>
                        <h4 class="font-display text-xl text-white font-bold mb-2">Bank Passbook Account</h4>
                        <p class="text-xs text-on-surface-variant leading-relaxed">Direct bank passbook linking ensuring the ₹85,800 central subsidy deposits cleanly within 30 days.</p>
                    </div>

                    <div class="border-l-2 border-gold-imperial/40 pl-6 py-2 relative group hover:border-gold-imperial transition-colors">
                        <div class="font-mono-data text-xs text-gold-champagne font-bold tracking-wider mb-1">STAGE 03 • GEO-SURVEY</div>
                        <h4 class="font-display text-xl text-white font-bold mb-2">GPS Property Photograph</h4>
                        <p class="text-xs text-on-surface-variant leading-relaxed">High-accuracy satellite coordinate verification of your residential roof structure.</p>
                    </div>

                    <div class="border-l-2 border-gold-imperial/40 pl-6 py-2 relative group hover:border-gold-imperial transition-colors">
                        <div class="font-mono-data text-xs text-gold-champagne font-bold tracking-wider mb-1">STAGE 04 • LAND VERIFICATION</div>
                        <h4 class="font-display text-xl text-white font-bold mb-2">Jamabandi / Khajna Receipt</h4>
                        <p class="text-xs text-on-surface-variant leading-relaxed">Official tax or holding number validation confirming legal rooftop installation rights.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include_once __DIR__ . '/includes/landing_footer.php'; ?>
