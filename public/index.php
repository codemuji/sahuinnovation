<?php
$pageTitle = "Architectural Solar Excellence";
include_once __DIR__ . '/includes/landing_header.php';
?>

<main class="relative z-10 overflow-hidden bg-alabaster-cream">
    <!-- Hero Section -->
    <section class="relative pt-12 pb-24 px-6 md:px-12 max-w-container-max mx-auto overflow-hidden">
        <!-- Ambient Lighting Glow -->
        <div class="absolute top-20 right-1/4 w-[500px] h-[300px] bg-gold-imperial/15 rounded-full blur-[140px] pointer-events-none"></div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center animate-on-scroll">
            <!-- Left Narrative -->
            <div class="lg:col-span-6 flex flex-col items-start z-10">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white border border-gold-imperial/40 text-navy-deep font-mono-data text-xs uppercase tracking-widest mb-6 shadow-sm">
                    <span class="material-symbols-outlined text-sm text-gold-imperial">verified</span>
                    <span class="font-bold">Govt Approved • Zero Down Payment</span>
                </div>
                <h1 class="font-display text-4xl sm:text-5xl lg:text-6xl text-navy-deep mb-6 font-bold tracking-tight leading-[1.1]">
                    Get Free Electricity for Life.
                    <span class="block mt-2 font-serif-title italic font-bold text-2xl sm:text-3xl lg:text-4xl text-gold-champagne tracking-wide leading-tight">
                        Claim Your ₹1,30,800 Direct Passbook Subsidy.
                    </span>
                </h1>
                <p class="font-body-lg text-body-lg text-text-muted mb-8 max-w-xl font-medium">
                    Harness the precision of modern architectural solar cladding. Eliminate utility bills forever while elevating property aesthetics with guaranteed 25-year performance.
                </p>
                <div class="flex flex-wrap gap-4 w-full sm:w-auto">
                    <a href="<?= site_url('public/about.php#calculator') ?>" class="font-label-caps bg-gradient-to-r from-navy-deep via-navy-primary to-navy-deep text-white font-bold px-8 py-4 rounded-xl hover:shadow-xl hover:shadow-navy-deep/20 transition-all transform hover:-translate-y-0.5 uppercase tracking-wider text-center border border-gold-imperial/40">
                        Calculate Subsidy & ROI
                    </a>
                    <a href="<?= site_url('public/about.php') ?>" class="font-label-caps bg-white border border-gold-imperial/40 text-navy-deep hover:bg-slate-50 hover:border-gold-imperial px-8 py-4 rounded-xl transition-all uppercase tracking-wider text-center flex items-center justify-center gap-2 font-bold shadow-sm">
                        <span>Explore 3D Brand & About</span>
                        <span class="material-symbols-outlined text-sm text-gold-imperial">arrow_forward</span>
                    </a>
                </div>

                <!-- Key Stat Pills -->
                <div class="grid grid-cols-3 gap-4 mt-10 pt-8 border-t border-border-light w-full font-mono-data">
                    <div>
                        <div class="text-xl font-display font-bold text-navy-deep">300 Units</div>
                        <div class="text-[11px] text-gold-champagne font-bold">Monthly Free Baseline</div>
                    </div>
                    <div>
                        <div class="text-xl font-display font-bold text-emerald-trust">₹ 0.00</div>
                        <div class="text-[11px] text-text-muted font-medium">Target Electric Bill</div>
                    </div>
                    <div>
                        <div class="text-xl font-display font-bold text-navy-deep">₹ 2,100</div>
                        <div class="text-[11px] text-text-muted font-medium">Starting Monthly EMI</div>
                    </div>
                </div>
            </div>

            <!-- Right Visual: Luxury Solar Villa Illustration (`luxury_hero.png`) -->
            <div class="lg:col-span-6 relative mt-6 lg:mt-0">
                <div class="relative w-full aspect-[4/3] rounded-2xl overflow-hidden luxury-card shadow-2xl border border-gold-imperial/40 group">
                    <img alt="Pristine luxury villa at dusk with seamless flush-mounted dark matte solar roofing and warm champagne lighting" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" src="<?= site_url('public/assets/img/luxury_hero.png') ?>"/>
                    <div class="absolute inset-0 bg-gradient-to-t from-navy-deep/80 via-transparent to-transparent"></div>
                    
                    <!-- Floating Live Pulse Card -->
                    <div class="absolute bottom-4 left-4 right-4 sm:right-auto sm:max-w-sm p-4 rounded-xl bg-white/95 border border-gold-imperial/50 backdrop-blur-md shadow-2xl">
                        <div class="flex items-center justify-between mb-2">
                            <span class="font-mono-data text-[11px] text-gold-champagne font-bold uppercase tracking-wider">Net Metering Status</span>
                            <span class="flex items-center gap-1.5 text-[11px] font-mono-data text-emerald-trust font-bold">
                                <span class="w-2 h-2 rounded-full bg-emerald-trust animate-pulse"></span>
                                GRID SYNCHRONIZED
                            </span>
                        </div>
                        <div class="text-sm font-display text-navy-deep font-bold">3kW Flagship System Active</div>
                        <div class="text-xs text-text-muted mt-1 font-mono-data">Daily Generation: <strong class="text-navy-deep">10.2 Units</strong> • Export Rate: <strong class="text-gold-champagne font-bold">₹5.30/unit</strong></div>
                    </div>
                </div>
                <div class="absolute -right-4 -top-4 w-24 h-24 border-r-2 border-t-2 border-gold-imperial/50 rounded-tr-2xl pointer-events-none hidden md:block"></div>
            </div>
        </div>
    </section>

    <!-- Social Proof / Trust Strip -->
    <section class="w-full border-y border-gold-imperial/30 bg-white py-10 animate-on-scroll shadow-sm">
        <div class="max-w-container-max mx-auto px-6 md:px-12 flex flex-col lg:flex-row items-center justify-between gap-8">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-gold-imperial text-3xl">workspace_premium</span>
                <div>
                    <div class="font-display font-bold text-navy-deep text-base">PM Surya Ghar Official Partner</div>
                    <div class="font-mono-data text-xs text-text-muted font-medium">Guaranteed Direct Passbook Subsidy Processing</div>
                </div>
            </div>
            <div class="flex flex-wrap justify-center lg:justify-end gap-10 items-center w-full lg:w-auto">
                <div class="text-center font-mono-data">
                    <span class="block text-gold-champagne font-bold text-lg">₹85,800</span>
                    <span class="text-[11px] text-text-muted uppercase font-semibold">Central Credit (30 Days)</span>
                </div>
                <div class="h-8 w-px bg-border-light hidden sm:block"></div>
                <div class="text-center font-mono-data">
                    <span class="block text-gold-champagne font-bold text-lg">₹45,000</span>
                    <span class="text-[11px] text-text-muted uppercase font-semibold">State Credit (60-180 Days)</span>
                </div>
                <div class="h-8 w-px bg-border-light hidden sm:block"></div>
                <div class="text-center font-mono-data">
                    <span class="block text-emerald-trust font-bold text-lg">₹1,30,800</span>
                    <span class="text-[11px] text-text-muted uppercase font-semibold">Total Govt Subsidy</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Architectural Portfolio Showcase (Breaking the Bento Grid & Boxed Icons) -->
    <section class="py-24 px-6 md:px-12 bg-surface-tint animate-on-scroll relative">
        <div class="max-w-container-max mx-auto">
            <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6 border-b border-border-light pb-8">
                <div>
                    <span class="font-mono-data text-xs text-gold-champagne font-bold uppercase tracking-[0.25em] block mb-2">Architectural & Financial Excellence</span>
                    <h2 class="font-display text-3xl md:text-5xl text-navy-deep font-bold tracking-tight">
                        Why Homeowners Choose Sahu Innovation
                        <span class="block font-serif-title italic text-2xl md:text-3xl text-gold-champagne font-bold mt-1">Uncompromising Engineering Standards.</span>
                    </h2>
                </div>
                <a href="<?= site_url('public/about.php') ?>" class="font-label-caps text-navy-deep font-bold hover:text-gold-imperial flex items-center gap-2 border-b border-gold-imperial pb-1 transition-colors uppercase tracking-wider shrink-0">
                    Read Our Full Philosophy &rarr;
                </a>
            </div>

            <!-- Asymmetrical Editorial Showcase (`grid-cols-12`) -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">
                <!-- Left Hero Statement Card (`col-span-7`) -->
                <div class="lg:col-span-7 p-8 md:p-14 luxury-card rounded-3xl border border-gold-imperial/40 relative overflow-hidden group flex flex-col justify-between shadow-xl bg-white">
                    <div class="absolute -right-6 -bottom-10 font-mono-data text-[180px] leading-none text-gold-imperial/[0.07] font-bold select-none pointer-events-none group-hover:text-gold-imperial/[0.12] transition-colors">01</div>
                    <div class="relative z-10">
                        <span class="font-mono-data text-xs text-gold-champagne font-bold tracking-[0.25em] uppercase block mb-4 border-l-2 border-gold-imperial pl-3">Energy Autonomy</span>
                        <h3 class="font-display text-3xl sm:text-4xl text-navy-deep font-bold mb-6 max-w-lg leading-tight">300 Units Free Power Daily Baseline</h3>
                        <p class="font-body-lg text-text-muted text-base leading-relaxed max-w-xl mb-10 font-medium">
                            Our 3kW flagship system generates an average of <strong class="text-navy-deep font-bold">10 units daily</strong>, completely wiping out standard residential electricity consumption while paying you back for excess exports under national net metering guidelines.
                        </p>
                    </div>
                    
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-6 pt-6 border-t border-border-light font-mono-data relative z-10">
                        <div>
                            <div class="text-sm text-gold-champagne font-bold uppercase">Zero Cost</div>
                            <div class="text-[11px] text-text-muted font-medium">Lifetime Solar Output</div>
                        </div>
                        <div>
                            <div class="text-sm text-emerald-trust font-bold uppercase">₹25K / Year</div>
                            <div class="text-[11px] text-text-muted font-medium">Average Bill Savings</div>
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <a href="<?= site_url('public/about.php#calculator') ?>" class="text-xs font-bold text-navy-deep hover:text-gold-imperial flex items-center gap-1 pt-1 transition-colors">
                                <span>Calculate ROI</span>
                                <span class="material-symbols-outlined text-sm">arrow_forward</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Right Editorial Stack (`col-span-5`) -->
                <div class="lg:col-span-5 flex flex-col gap-8 justify-between">
                    <!-- Card 02: 5-Year Legal Agreement -->
                    <div class="p-8 md:p-10 luxury-card rounded-3xl border border-gold-imperial/40 relative overflow-hidden group flex-1 flex flex-col justify-between shadow-xl bg-white">
                        <div class="absolute right-6 top-6 font-mono-data text-5xl text-gold-imperial/15 font-bold select-none pointer-events-none">02</div>
                        <div class="relative z-10 pr-12">
                            <span class="font-mono-data text-[11px] text-gold-champagne font-bold uppercase tracking-widest block mb-2">Binding Assurance</span>
                            <h3 class="font-display text-2xl text-navy-deep font-bold mb-3">5-Year Vendor Agreement</h3>
                            <p class="font-body-md text-text-muted text-sm leading-relaxed mb-6 font-medium">
                                We formalize our commitments with an explicit 5-year agreement: <strong class="text-navy-deep font-bold">Zero Installation Charges</strong>, zero surprise maintenance fees, and complete Grade-A hardware replacement protection.
                            </p>
                        </div>
                        <a href="<?= site_url('public/about.php#warranties') ?>" class="font-mono-data text-xs text-gold-champagne font-bold hover:underline flex items-center gap-1.5 relative z-10 pt-4 border-t border-border-light">
                            <span>Review Legal Details</span>
                            <span class="material-symbols-outlined text-sm">arrow_forward</span>
                        </a>
                    </div>

                    <!-- Card 03: Solid-State Hybrid Storage -->
                    <div class="p-8 md:p-10 luxury-card rounded-3xl border border-navy-deep/20 relative overflow-hidden group flex-1 flex flex-col justify-between shadow-xl bg-white">
                        <div class="absolute right-6 top-6 font-mono-data text-5xl text-navy-deep/10 font-bold select-none pointer-events-none">03</div>
                        <div class="relative z-10 pr-12">
                            <span class="font-mono-data text-[11px] text-navy-deep font-bold uppercase tracking-widest block mb-2">24/7 Backup Capability</span>
                            <h3 class="font-display text-2xl text-navy-deep font-bold mb-3">Solid-State Hybrid Storage</h3>
                            <p class="font-body-md text-text-muted text-sm leading-relaxed mb-6 font-medium">
                                Beyond grid synchronization, we deploy sculptural solid-state battery modules engineered to mount flush on luxury garage walls for silent, uninterrupted blackout protection.
                            </p>
                        </div>
                        <a href="<?= site_url('public/about.php#warranties') ?>" class="font-mono-data text-xs text-navy-deep font-bold hover:underline flex items-center gap-1.5 relative z-10 pt-4 border-t border-border-light">
                            <span>Explore Hybrid Battery Tech</span>
                            <span class="material-symbols-outlined text-sm">arrow_forward</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Official Range of Systems Highlight Banner (`#systems-overview`) -->
    <section class="py-20 px-6 md:px-12 bg-white border-t border-gold-imperial/30 animate-on-scroll relative">
        <div class="max-w-container-max mx-auto">
            <div class="p-8 md:p-12 rounded-3xl bg-gradient-to-br from-navy-deep to-navy-primary text-white border border-gold-imperial/40 shadow-2xl flex flex-col lg:flex-row items-center justify-between gap-10">
                <div class="space-y-4 max-w-2xl">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-white/10 border border-gold-imperial/40 text-gold-light font-mono-data text-xs uppercase tracking-widest">
                        <span class="material-symbols-outlined text-sm text-gold-imperial">wb_sunny</span>
                        <span>Official Assam & Northeast Catalog</span>
                    </div>
                    <h2 class="font-display text-3xl md:text-4xl text-white font-bold tracking-tight">
                        Explore Our Full Range of Solar Solutions.
                    </h2>
                    <p class="font-body-md text-slate-200 text-sm leading-relaxed font-medium">
                        From PM Surya Ghar On-Grid systems starting at <strong class="text-white font-bold">₹1,89,000/-</strong> (with ₹1.3L direct government subsidy) to 24/7 Solid-State Hybrid Backup systems and customized <strong class="text-white font-bold">Rodali Scheme Commercial Projects</strong> (`21kW+`), we deliver turnkey solar engineering across Assam.
                    </p>
                    <div class="font-mono-data text-xs text-gold-light pt-2 flex items-center gap-2 font-medium">
                        <span class="material-symbols-outlined text-sm text-gold-imperial">location_on</span>
                        <span>Head Office: Shankardev Nagar Road, Dhanuhar Basti, Hojai, Pin 782435, Assam</span>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 w-full lg:w-auto shrink-0 font-mono-data text-xs">
                    <a href="<?= site_url('public/pm-surya-ghar.php#pricing-matrix') ?>" class="px-8 py-4 rounded-xl bg-gold-imperial text-navy-deep font-bold hover:bg-gold-champagne transition-all text-center uppercase tracking-wider shadow-xl flex items-center justify-center gap-2 border border-white/20">
                        <span>View Complete Price Lists</span>
                        <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </a>
                    <a href="<?= site_url('public/about.php#leadership') ?>" class="px-8 py-4 rounded-xl bg-navy-light text-white border border-gold-imperial/40 hover:bg-white hover:text-navy-deep transition-all text-center uppercase tracking-wider flex items-center justify-center gap-2 font-bold shadow-md">
                        <span>Meet Board of Directors</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Streamlined Intake Rail -->
    <section class="py-24 px-6 md:px-12 bg-surface-tint border-t border-gold-imperial/25 animate-on-scroll relative">
        <div class="max-w-container-max mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start mb-16">
                <div class="lg:col-span-5 space-y-4">
                    <span class="font-mono-data text-xs text-gold-champagne font-bold uppercase tracking-[0.25em] block border-l-2 border-gold-imperial pl-3">Streamlined Intake</span>
                    <h2 class="font-display text-3xl sm:text-4xl text-navy-deep font-bold tracking-tight">
                        Only 8 Documents Needed for Your ₹1.3L Subsidy
                    </h2>
                    <p class="font-body-md text-text-muted leading-relaxed font-medium">
                        Our dedicated compliance team manages your complete government portal registration (`PM Surya Ghar`), GPS property survey, and express bank passbook linking.
                    </p>
                    <div class="pt-4">
                        <a href="<?= site_url('public/about.php#checklist') ?>" class="font-label-caps bg-white border border-gold-imperial/40 text-navy-deep font-bold hover:bg-navy-deep hover:text-white px-6 py-3.5 rounded-xl transition-all uppercase tracking-wider inline-flex items-center gap-2 shadow-sm">
                            <span>View Document Requirements</span>
                            <span class="material-symbols-outlined text-sm text-gold-imperial">arrow_forward</span>
                        </a>
                    </div>
                </div>

                <!-- 4-Stage Architectural Rail -->
                <div class="lg:col-span-7 grid grid-cols-1 sm:grid-cols-2 gap-8">
                    <div class="border-l-2 border-gold-imperial/50 pl-6 py-3 relative group hover:border-navy-deep transition-colors bg-white p-5 rounded-r-xl shadow-sm">
                        <div class="font-mono-data text-xs text-gold-champagne font-bold tracking-wider mb-1">STAGE 01 • IDENTIFICATION</div>
                        <h4 class="font-display text-xl text-navy-deep font-bold mb-2">Aadhaar & PAN Verification</h4>
                        <p class="text-xs text-text-muted leading-relaxed font-medium">Verified KYC records linked to property ownership for immediate central portal verification.</p>
                    </div>

                    <div class="border-l-2 border-gold-imperial/50 pl-6 py-3 relative group hover:border-navy-deep transition-colors bg-white p-5 rounded-r-xl shadow-sm">
                        <div class="font-mono-data text-xs text-gold-champagne font-bold tracking-wider mb-1">STAGE 02 • DISBURSAL LINK</div>
                        <h4 class="font-display text-xl text-navy-deep font-bold mb-2">Bank Passbook Account</h4>
                        <p class="text-xs text-text-muted leading-relaxed font-medium">Direct bank passbook linking ensuring the ₹85,800 central subsidy deposits cleanly within 30 days.</p>
                    </div>

                    <div class="border-l-2 border-gold-imperial/50 pl-6 py-3 relative group hover:border-navy-deep transition-colors bg-white p-5 rounded-r-xl shadow-sm">
                        <div class="font-mono-data text-xs text-gold-champagne font-bold tracking-wider mb-1">STAGE 03 • GEO-SURVEY</div>
                        <h4 class="font-display text-xl text-navy-deep font-bold mb-2">GPS Property Photograph</h4>
                        <p class="text-xs text-text-muted leading-relaxed font-medium">High-accuracy satellite coordinate verification of your residential roof structure.</p>
                    </div>

                    <div class="border-l-2 border-gold-imperial/50 pl-6 py-3 relative group hover:border-navy-deep transition-colors bg-white p-5 rounded-r-xl shadow-sm">
                        <div class="font-mono-data text-xs text-gold-champagne font-bold tracking-wider mb-1">STAGE 04 • LAND VERIFICATION</div>
                        <h4 class="font-display text-xl text-navy-deep font-bold mb-2">Jamabandi / Khajna Receipt</h4>
                        <p class="text-xs text-text-muted leading-relaxed font-medium">Official tax or holding number validation confirming legal rooftop installation rights.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include_once __DIR__ . '/includes/landing_footer.php'; ?>
