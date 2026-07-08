<?php
$pageTitle = "Savings & Benefits";
include_once __DIR__ . '/includes/landing_header.php';
?>

<main class="pt-24 pb-section-padding px-6 md:px-8 max-w-container-max mx-auto">
    <!-- Header Section -->
    <header class="text-center mb-16 md:mb-24 max-w-3xl mx-auto animate-on-scroll">
        <h1 class="font-headline-h1 text-headline-h1 text-primary-container mb-6">Quantifiable Value. <br/>Sustainable Future.</h1>
        <p class="font-body-lg text-body-lg text-on-surface-variant">Discover the financial and environmental benefits of transitioning to architectural solar excellence. Minimal investment, maximum long-term return.</p>
    </header>

    <!-- Interactive Savings Calculator Widget -->
    <section class="mb-section-padding animate-on-scroll delay-100">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-gutter">
            <!-- Input Panel -->
            <div class="lg:col-span-5 bg-surface-container-lowest border border-outline-variant rounded-xl p-6 md:p-8 ambient-shadow">
                <h3 class="font-headline-h3 text-headline-h3 text-primary-container mb-8">Investment Analysis</h3>
                <div class="space-y-8">
                    <div>
                        <label class="font-label-caps text-label-caps text-on-surface-variant block mb-4 uppercase">Average Monthly Bill</label>
                        <div class="flex items-center justify-between mb-2">
                            <span class="font-body-md text-body-md text-on-surface-variant">₹2,000</span>
                            <span class="font-headline-h3 text-headline-h3 text-primary-container">₹5,000</span>
                            <span class="font-body-md text-body-md text-on-surface-variant">₹15,000+</span>
                        </div>
                        <input class="w-full h-1 bg-surface-variant rounded-lg appearance-none cursor-pointer accent-secondary-container" max="15000" min="2000" type="range" value="5000"/>
                    </div>
                    <div>
                        <label class="font-label-caps text-label-caps text-on-surface-variant block mb-4 uppercase">Property Type</label>
                        <div class="grid grid-cols-2 gap-4">
                            <button class="border border-primary-container bg-primary-container text-on-primary font-body-md text-body-md py-3 rounded-lg transition-colors">Residential</button>
                            <button class="border border-outline-variant text-on-surface-variant hover:border-primary-container font-body-md text-body-md py-3 rounded-lg transition-colors">Commercial</button>
                        </div>
                    </div>
                    <div class="pt-6 border-t border-surface-variant">
                        <a href="<?= site_url('public/login.php') ?>" class="w-full bg-primary-container text-on-primary font-label-caps text-label-caps py-4 rounded-lg hover:bg-on-surface transition-colors flex items-center justify-center space-x-2">
                            <span>Get Detailed Report</span>
                            <span class="material-symbols-outlined text-sm">arrow_forward</span>
                        </a>
                    </div>
                </div>
            </div>
            <!-- Results Panel -->
            <div class="lg:col-span-7 grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Stat Card 1 -->
                <div class="bg-primary-container text-on-primary rounded-xl p-6 md:p-8 flex flex-col justify-between hover:scale-[1.02] hover:shadow-lg transition-transform duration-300">
                    <div>
                        <span class="material-symbols-outlined text-secondary-fixed mb-4 text-3xl" style="font-variation-settings: 'FILL' 1;">account_balance_wallet</span>
                        <h4 class="font-label-caps text-label-caps text-primary-fixed-dim uppercase mb-2">Estimated Annual Savings</h4>
                    </div>
                    <div>
                        <span class="font-display text-display text-on-primary block">₹62,000</span>
                        <span class="font-body-md text-body-md text-primary-fixed-dim mt-2 block">Based on current rates</span>
                    </div>
                </div>
                <!-- Stat Card 2 -->
                <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-6 md:p-8 ambient-shadow flex flex-col justify-between hover:scale-[1.02] hover:shadow-lg transition-transform duration-300">
                    <div>
                        <div class="w-2 h-2 rounded-full bg-secondary-container mb-4"></div>
                        <h4 class="font-label-caps text-label-caps text-on-surface-variant uppercase mb-2">Available Subsidies</h4>
                    </div>
                    <div>
                        <span class="font-headline-h2 text-headline-h2 text-primary-container block">Up to ₹78,000</span>
                        <span class="font-body-md text-body-md text-on-surface-variant mt-2 block">PM Surya Ghar Scheme applied</span>
                    </div>
                </div>
                <!-- Stat Card 3 (Full Width) -->
                <div class="md:col-span-2 bg-surface-container-lowest border border-outline-variant rounded-xl p-6 md:p-8 ambient-shadow flex items-center justify-between hover:scale-[1.02] hover:shadow-lg transition-transform duration-300">
                    <div>
                        <h4 class="font-label-caps text-label-caps text-on-surface-variant uppercase mb-2">Break-Even Timeline</h4>
                        <span class="font-headline-h2 text-headline-h2 text-primary-container">4.5 Years</span>
                    </div>
                    <div class="hidden sm:block text-right">
                        <span class="font-body-md text-body-md text-on-surface-variant block mb-1">System Lifespan</span>
                        <span class="font-headline-h3 text-headline-h3 text-primary-container">25+ Years</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Environmental Impact Grid -->
    <section class="mb-section-padding animate-on-scroll">
        <div class="text-center mb-16">
            <h2 class="font-headline-h2 text-headline-h2 text-primary-container mb-4">The Ecological Dividend</h2>
            <p class="font-body-md text-body-md text-on-surface-variant max-w-2xl mx-auto">Beyond financial metrics, your transition represents a measurable contribution to environmental sustainability.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="border-t border-primary-container pt-6">
                <span class="font-display text-headline-h1 text-primary-container block mb-2">12.5<span class="text-headline-h3">T</span></span>
                <h4 class="font-label-caps text-label-caps text-on-surface-variant uppercase mb-2">CO2 Offset Annually</h4>
                <p class="font-body-md text-body-md text-outline">Equivalent to planting over 200 mature trees each year.</p>
            </div>
            <div class="border-t border-outline-variant pt-6">
                <span class="font-display text-headline-h1 text-primary-container block mb-2">100<span class="text-headline-h3">%</span></span>
                <h4 class="font-label-caps text-label-caps text-on-surface-variant uppercase mb-2">Clean Energy</h4>
                <p class="font-body-md text-body-md text-outline">Complete independence from fossil-fuel derived grid power.</p>
            </div>
            <div class="border-t border-outline-variant pt-6">
                <span class="font-display text-headline-h1 text-primary-container block mb-2">0<span class="text-headline-h3"></span></span>
                <h4 class="font-label-caps text-label-caps text-on-surface-variant uppercase mb-2">Noise Pollution</h4>
                <p class="font-body-md text-body-md text-outline">Silent operation ensuring the tranquility of your property is preserved.</p>
            </div>
        </div>
    </section>
</main>

<?php include_once __DIR__ . '/includes/landing_footer.php'; ?>
