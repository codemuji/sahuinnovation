<?php
$pageTitle = "ROI & Financial Savings";
include_once __DIR__ . '/includes/landing_header.php';
?>

<main class="relative z-10 overflow-hidden">
    <!-- Header Section -->
    <header class="relative pt-20 pb-24 px-6 md:px-12 bg-obsidian-deep bg-grid-pattern border-b border-gold-imperial/20 overflow-hidden text-center animate-on-scroll">
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[300px] bg-gold-imperial/10 rounded-full blur-[140px] pointer-events-none"></div>
        <div class="max-w-3xl mx-auto relative z-10">
            <span class="font-label-caps text-gold-imperial uppercase tracking-widest block mb-4">Financial & Ecological Yield</span>
            <h1 class="font-display text-4xl sm:text-5xl lg:text-headline-h1 text-white mb-6 font-bold tracking-tight">
                Quantifiable ROI. <span class="gold-gradient-text">Zero Capital Outlay.</span>
            </h1>
            <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl mx-auto">
                Transition to architectural solar excellence without upfront cash drain. Our zero down payment structure and PM Surya Ghar ₹1,30,800 subsidy turn your roof into a high-yielding financial asset.
            </p>
        </div>
    </header>

    <!-- Key Metrics Grid -->
    <section class="py-20 px-6 md:px-12 bg-charcoal-surface border-b border-gold-imperial/20 animate-on-scroll">
        <div class="max-w-container-max mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="obsidian-card p-8 rounded-2xl border border-gold-imperial/30 text-center">
                <span class="material-symbols-outlined text-gold-imperial text-4xl mb-3">account_balance_wallet</span>
                <div class="text-xs font-mono-data text-on-surface-variant uppercase">Government Credit</div>
                <div class="font-display text-3xl font-bold text-emerald-trust mt-1">₹ 1,30,800</div>
                <div class="text-[11px] font-mono-data text-gold-champagne mt-2">Central + State Subsidy</div>
            </div>

            <div class="obsidian-card p-8 rounded-2xl border border-gold-imperial/30 text-center">
                <span class="material-symbols-outlined text-gold-imperial text-4xl mb-3">bolt</span>
                <div class="text-xs font-mono-data text-on-surface-variant uppercase">Monthly Power Yield</div>
                <div class="font-display text-3xl font-bold text-white mt-1">300 Units</div>
                <div class="text-[11px] font-mono-data text-cyan-pulse mt-2">~10 Units Daily Output</div>
            </div>

            <div class="obsidian-card p-8 rounded-2xl border border-gold-imperial/30 text-center">
                <span class="material-symbols-outlined text-gold-imperial text-4xl mb-3">calendar_today</span>
                <div class="text-xs font-mono-data text-on-surface-variant uppercase">Easy EMI Option</div>
                <div class="font-display text-3xl font-bold text-gold-champagne mt-1">₹ 2,100 /mo</div>
                <div class="text-[11px] font-mono-data text-on-surface-variant mt-2">Over 30 Months (2.5 Yrs)</div>
            </div>

            <div class="obsidian-card p-8 rounded-2xl border border-gold-imperial/30 text-center">
                <span class="material-symbols-outlined text-gold-imperial text-4xl mb-3">verified</span>
                <div class="text-xs font-mono-data text-on-surface-variant uppercase">Hardware Protection</div>
                <div class="font-display text-3xl font-bold text-white mt-1">25+ Years</div>
                <div class="text-[11px] font-mono-data text-emerald-trust mt-2">Guaranteed Panel Performance</div>
            </div>
        </div>
    </section>

    <!-- Detailed ROI Breakdown & Legal Assurance -->
    <section class="py-24 px-6 md:px-12 bg-obsidian-deep animate-on-scroll">
        <div class="max-w-container-max mx-auto grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <div class="lg:col-span-6 space-y-6">
                <span class="font-label-caps text-gold-imperial uppercase tracking-widest block">The Sahu Financial Engine</span>
                <h2 class="font-display text-3xl md:text-headline-h2 text-white font-bold">Break-Even in Under 3 Years</h2>
                <div class="font-body-md text-on-surface-variant space-y-4 leading-relaxed">
                    <p>
                        With standard residential electricity tariffs averaging ₹8 per unit, a homeowner consuming 300 units per month spends approximately <strong class="text-white">₹2,400 to ₹3,500 monthly</strong> right into the grid.
                    </p>
                    <p>
                        By installing a Sahu Innovation 3kW system with <strong class="text-white">zero down payment</strong> and applying the direct ₹1,30,800 PM Surya Ghar subsidy, your monthly EMI (~₹2,100) is lower than your previous utility bill—meaning <strong class="text-emerald-trust font-bold">instant positive cash flow from Day 1</strong>.
                    </p>
                    <p>
                        After 2.5 years of easy installments, your electricity is 100% free for the remaining 22+ years of the system warranty.
                    </p>
                </div>
                <div class="pt-4">
                    <a href="<?= site_url('public/about.php#calculator') ?>" class="font-label-caps bg-gradient-to-r from-gold-imperial via-gold-champagne to-gold-imperial text-obsidian-deep font-bold px-8 py-4 rounded-xl hover:shadow-xl transition-all uppercase tracking-wider inline-block">
                        Try Interactive ROI Calculator &rarr;
                    </a>
                </div>
            </div>

            <div class="lg:col-span-6">
                <div class="obsidian-card p-8 rounded-2xl border border-gold-imperial/30 space-y-6">
                    <h3 class="font-display font-bold text-white text-xl border-b border-outline-variant/30 pb-4">Financial & Legal Assurances</h3>
                    
                    <div class="flex items-start gap-4">
                        <span class="material-symbols-outlined text-gold-imperial text-2xl mt-0.5">description</span>
                        <div>
                            <h4 class="font-display font-bold text-white text-base">5-Year Vendor Protection Agreement</h4>
                            <p class="text-xs text-on-surface-variant mt-1">Formal legal contract protecting against installation defects, equipment failures, and unexpected maintenance costs during the break-even period.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <span class="material-symbols-outlined text-emerald-trust text-2xl mt-0.5">price_check</span>
                        <div>
                            <h4 class="font-display font-bold text-white text-base">Zero Hidden Charges</h4>
                            <p class="text-xs text-on-surface-variant mt-1">Our quotes are comprehensive. We handle the net meter application, local DISCOM liaison, structural mounting, and passbook linking with zero extra fees.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <span class="material-symbols-outlined text-cyan-pulse text-2xl mt-0.5">solar_power</span>
                        <div>
                            <h4 class="font-display font-bold text-white text-base">Excess Export Revenue</h4>
                            <p class="text-xs text-on-surface-variant mt-1">When your system generates more than you consume, excess units are fed back to the grid and credited to you at the net metering rate (~₹5.30/unit).</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include_once __DIR__ . '/includes/landing_footer.php'; ?>
