<?php
$pageTitle = "PM Surya Ghar Scheme (₹1,30,800 Subsidy)";
include_once __DIR__ . '/includes/landing_header.php';
?>

<main class="relative z-10 overflow-hidden">
    <!-- Hero Section -->
    <header class="relative pt-20 pb-24 px-6 md:px-12 bg-obsidian-deep bg-grid-pattern border-b border-gold-imperial/20 overflow-hidden">
        <div class="absolute top-1/3 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[350px] bg-gold-imperial/10 rounded-full blur-[140px] pointer-events-none"></div>
        <div class="max-w-container-max mx-auto relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center animate-on-scroll">
            <div class="lg:col-span-7">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-charcoal-surface border border-emerald-trust/40 text-emerald-trust font-mono-data text-xs uppercase tracking-widest mb-6">
                    <span class="material-symbols-outlined text-sm">verified</span>
                    Official Central & State Subsidy Guide
                </div>
                <h1 class="font-display text-4xl sm:text-5xl lg:text-headline-h1 text-white mb-6 font-bold tracking-tight">
                    PM Surya Ghar Muft Bijli Yojana — <span class="gold-gradient-text">₹1,30,800 Direct Subsidy.</span>
                </h1>
                <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl mb-8 leading-relaxed">
                    India's premier residential clean energy initiative empowers homeowners with up to <strong class="text-white">300 Units/Month of free electricity</strong>. Sahu Innovation guarantees complete end-to-end portal processing, field survey assistance, and passbook linking.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="<?= site_url('public/about.php#calculator') ?>" class="font-label-caps bg-gradient-to-r from-gold-imperial via-gold-champagne to-gold-imperial text-obsidian-deep font-bold px-8 py-4 rounded-xl hover:shadow-xl hover:shadow-gold-imperial/25 transition-all uppercase tracking-wider">
                        Calculate Subsidy Amount
                    </a>
                    <a href="#checklist" class="font-label-caps bg-charcoal-surface border border-gold-imperial/30 text-gold-champagne hover:bg-charcoal-light hover:text-white px-8 py-4 rounded-xl transition-all uppercase tracking-wider flex items-center gap-2">
                        <span>8 Required Documents</span>
                        <span class="material-symbols-outlined text-sm">arrow_downward</span>
                    </a>
                </div>
            </div>

            <!-- Right: Subsidy Breakdown Card -->
            <div class="lg:col-span-5">
                <div class="obsidian-card rounded-2xl p-8 border border-gold-imperial/30 shadow-2xl relative">
                    <div class="flex justify-between items-center pb-4 border-b border-outline-variant/30 mb-6">
                        <span class="font-display font-bold text-white text-lg">3kW Flagship Allocation</span>
                        <span class="px-2.5 py-1 rounded bg-emerald-trust/20 text-emerald-trust border border-emerald-trust/40 text-xs font-mono-data font-bold">ZERO DOWN PAYMENT</span>
                    </div>

                    <div class="space-y-4 font-mono-data">
                        <div class="p-4 rounded-xl bg-charcoal-light border border-gold-imperial/20 flex justify-between items-center">
                            <div>
                                <div class="text-xs text-gold-champagne font-bold uppercase">Central Government Credit</div>
                                <div class="text-[11px] text-on-surface-variant mt-0.5">Direct to Passbook within 30 Days</div>
                            </div>
                            <div class="text-xl font-display font-bold text-white">₹ 85,800</div>
                        </div>

                        <div class="p-4 rounded-xl bg-charcoal-light border border-gold-imperial/20 flex justify-between items-center">
                            <div>
                                <div class="text-xs text-gold-champagne font-bold uppercase">State Government Credit</div>
                                <div class="text-[11px] text-on-surface-variant mt-0.5">Credited within 60-180 Days</div>
                            </div>
                            <div class="text-xl font-display font-bold text-white">₹ 45,000</div>
                        </div>

                        <div class="p-4 rounded-xl bg-gradient-to-r from-emerald-trust/20 to-charcoal-surface border border-emerald-trust/40 flex justify-between items-center">
                            <div>
                                <div class="text-xs text-emerald-trust font-bold uppercase">Total Government Credit</div>
                                <div class="text-[11px] text-on-surface-variant mt-0.5">Combined Subsidy Benefit</div>
                            </div>
                            <div class="text-2xl font-display font-bold text-emerald-trust">₹ 1,30,800</div>
                        </div>
                    </div>
                    <div class="mt-6 pt-4 border-t border-outline-variant/30 text-center font-mono-data text-xs text-on-surface-variant">
                        Monthly Load Charge: Only <span class="text-gold-champagne font-bold">~₹210</span> • Sell excess @ <span class="text-white font-bold">₹5.30/unit</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Eligibility & Requirements -->
    <section class="py-24 px-6 md:px-12 bg-charcoal-surface border-b border-gold-imperial/20 animate-on-scroll">
        <div class="max-w-container-max mx-auto">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="font-label-caps text-gold-imperial uppercase tracking-widest block mb-2">Straightforward Criteria</span>
                <h2 class="font-display text-3xl md:text-headline-h2 text-white font-bold mb-4">Who is Eligible for PM Surya Ghar?</h2>
                <p class="font-body-md text-on-surface-variant">We verify your property eligibility during our free initial site survey.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="obsidian-card obsidian-card-hover rounded-2xl p-8 flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-charcoal-light border border-gold-imperial/30 flex items-center justify-center text-gold-imperial mb-6">
                            <span class="material-symbols-outlined text-2xl">home</span>
                        </div>
                        <h3 class="font-display text-2xl text-white font-bold mb-4">Indian Resident & Homeowner</h3>
                        <p class="font-body-md text-on-surface-variant text-sm leading-relaxed">
                            Must be a citizen of India owning a residential property with a clear, shadow-free roof or terrace area suitable for panel mounting.
                        </p>
                    </div>
                    <div class="mt-6 pt-4 border-t border-outline-variant/30 font-mono-data text-xs text-gold-champagne">Verified via Land Document</div>
                </div>

                <div class="obsidian-card obsidian-card-hover rounded-2xl p-8 flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-charcoal-light border border-gold-imperial/30 flex items-center justify-center text-gold-imperial mb-6">
                            <span class="material-symbols-outlined text-2xl">electric_meter</span>
                        </div>
                        <h3 class="font-display text-2xl text-white font-bold mb-4">Valid Electric Connection</h3>
                        <p class="font-body-md text-body-md text-on-surface-variant text-sm leading-relaxed">
                            An active residential electricity meter connection in the applicant's name with the local DISCOM authority.
                        </p>
                    </div>
                    <div class="mt-6 pt-4 border-t border-outline-variant/30 font-mono-data text-xs text-gold-champagne">Verified via Electric Bill</div>
                </div>

                <div class="obsidian-card obsidian-card-hover rounded-2xl p-8 flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-charcoal-light border border-gold-imperial/30 flex items-center justify-center text-gold-imperial mb-6">
                            <span class="material-symbols-outlined text-2xl">receipt_long</span>
                        </div>
                        <h3 class="font-display text-2xl text-white font-bold mb-4">No Prior Solar Subsidy</h3>
                        <p class="font-body-md text-body-md text-on-surface-variant text-sm leading-relaxed">
                            The applicant must not have availed any previous central or state government subsidy for residential rooftop solar on the same property.
                        </p>
                    </div>
                    <div class="mt-6 pt-4 border-t border-outline-variant/30 font-mono-data text-xs text-gold-champagne">Direct Passbook Transfer</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Document Checklist (`#checklist`) -->
    <section id="checklist" class="py-24 px-6 md:px-12 bg-obsidian-deep animate-on-scroll">
        <div class="max-w-container-max mx-auto">
            <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6">
                <div>
                    <span class="font-label-caps text-gold-imperial uppercase tracking-widest block mb-2">Complete Digital Onboarding</span>
                    <h2 class="font-display text-3xl md:text-headline-h2 text-white font-bold">8 Mandatory Verification Documents</h2>
                </div>
                <a href="<?= site_url('public/about.php#calculator') ?>" class="font-label-caps text-gold-champagne hover:text-white flex items-center gap-2 border-b border-gold-imperial pb-1 transition-colors uppercase tracking-wider">
                    Go to Subsidy Calculator &rarr;
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="p-6 rounded-xl bg-charcoal-surface border border-gold-imperial/20 hover:border-gold-imperial/50 transition-all">
                    <span class="font-mono-data text-xs text-gold-imperial font-bold block mb-2">DOCUMENT 01</span>
                    <h4 class="font-display font-bold text-white text-base mb-1">Aadhaar Card</h4>
                    <p class="text-xs text-on-surface-variant">Identity verification linked with mobile OTP for portal login.</p>
                </div>
                <div class="p-6 rounded-xl bg-charcoal-surface border border-gold-imperial/20 hover:border-gold-imperial/50 transition-all">
                    <span class="font-mono-data text-xs text-gold-imperial font-bold block mb-2">DOCUMENT 02</span>
                    <h4 class="font-display font-bold text-white text-base mb-1">PAN Card</h4>
                    <p class="text-xs text-on-surface-variant">Tax and financial credit tracking on government portal.</p>
                </div>
                <div class="p-6 rounded-xl bg-charcoal-surface border border-gold-imperial/20 hover:border-gold-imperial/50 transition-all">
                    <span class="font-mono-data text-xs text-gold-imperial font-bold block mb-2">DOCUMENT 03</span>
                    <h4 class="font-display font-bold text-white text-base mb-1">Bank Passbook</h4>
                    <p class="text-xs text-on-surface-variant">Clear account details for direct transfer of ₹1,30,800.</p>
                </div>
                <div class="p-6 rounded-xl bg-charcoal-surface border border-gold-imperial/20 hover:border-gold-imperial/50 transition-all">
                    <span class="font-mono-data text-xs text-gold-imperial font-bold block mb-2">DOCUMENT 04</span>
                    <h4 class="font-display font-bold text-white text-base mb-1">Electric Bill Statement</h4>
                    <p class="text-xs text-on-surface-variant">Latest residential bill showing consumer ID and DISCOM.</p>
                </div>
                <div class="p-6 rounded-xl bg-charcoal-surface border border-gold-imperial/20 hover:border-gold-imperial/50 transition-all">
                    <span class="font-mono-data text-xs text-gold-imperial font-bold block mb-2">DOCUMENT 05</span>
                    <h4 class="font-display font-bold text-white text-base mb-1">Mobile & Email ID</h4>
                    <p class="text-xs text-on-surface-variant">Active contact credentials for status notifications.</p>
                </div>
                <div class="p-6 rounded-xl bg-charcoal-surface border border-gold-imperial/20 hover:border-gold-imperial/50 transition-all">
                    <span class="font-mono-data text-xs text-gold-imperial font-bold block mb-2">DOCUMENT 06</span>
                    <h4 class="font-display font-bold text-white text-base mb-1">GPS Home Photo</h4>
                    <p class="text-xs text-on-surface-variant">Captured by our surveyor with customer standing in front of property.</p>
                </div>
                <div class="p-6 rounded-xl bg-charcoal-surface border border-gold-imperial/20 hover:border-gold-imperial/50 transition-all sm:col-span-2">
                    <span class="font-mono-data text-xs text-gold-imperial font-bold block mb-2">DOCUMENT 07 & 08</span>
                    <h4 class="font-display font-bold text-white text-base mb-1">Land Document (Jamabandi / Khajna Receipt)</h4>
                    <p class="text-xs text-on-surface-variant">Official property records confirming roof or plot ownership rights for long-term installation.</p>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include_once __DIR__ . '/includes/landing_footer.php'; ?>
