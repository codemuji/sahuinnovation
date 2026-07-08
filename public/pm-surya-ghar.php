<?php
$pageTitle = "PM Surya Ghar Scheme";
include_once __DIR__ . '/includes/landing_header.php';
?>

<main>
    <!-- Hero Section -->
    <header class="bg-primary-container text-on-primary pt-24 pb-16 md:pt-32 md:pb-24 px-8 relative overflow-hidden">
        <div class="absolute inset-0 opacity-20 bg-[url('https://images.unsplash.com/photo-1509391366360-2e959784a276?ixlib=rb-4.0.3&auto=format&fit=crop&w=2072&q=80')] bg-cover bg-center"></div>
        <div class="max-w-container-max mx-auto relative z-10 grid grid-cols-1 md:grid-cols-12 gap-gutter">
            <div class="md:col-span-8 md:col-start-3 text-center">
                <span class="font-label-caps text-label-caps text-secondary-fixed-dim uppercase tracking-widest block mb-6">Government Initiative</span>
                <h1 class="font-display text-display mb-8">PM Surya Ghar Muft Bijli Yojana — Explained Simply</h1>
                <p class="font-body-lg text-body-lg text-inverse-on-surface max-w-2xl mx-auto leading-relaxed">
                    Navigate the path to energy independence. A comprehensive guide to India's premier residential solar subsidy scheme, curated by the experts at Sahu Innovation.
                </p>
            </div>
        </div>
    </header>

    <!-- What Is It Section -->
    <section class="py-section-padding px-8 bg-surface animate-on-scroll">
        <div class="max-w-container-max mx-auto grid grid-cols-1 md:grid-cols-12 gap-gutter items-center">
            <div class="md:col-span-5 relative">
                <img alt="What is PM Surya Ghar" class="w-full h-[600px] object-cover rounded-xl border border-outline-variant/30" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAFxWPdTlmyQLnIqoJ6YqCAWCPJdCRZycgqzDoW6gA6d2RgSVdj8T4DifIDLu7SqLT1PPWU8k0qcGgQVtiKNLtCDCeRJ1E1Y7Xkgj37-UKJzi_lZIf7qaiDcl-tu3upmdO1pXXU4CArRDuTTQqRVrpPU-vvtzVH0SHmLlLpHVA6NHbr2pSHqIrHAkKIMQwQGdtxpPDtcaUsLW_p8dc7sMYpic0G1fQEs8puizsTCU7k0cv6gT232nIOk-tsfAvODWzi6AbhtH9bsQQH"/>
                <div class="absolute -bottom-8 -right-8 w-48 h-48 bg-secondary-fixed-dim/10 rounded-full blur-3xl"></div>
            </div>
            <div class="md:col-span-6 md:col-start-7">
                <h2 class="font-headline-h2 text-headline-h2 text-on-surface mb-6">The Vision of Free Electricity</h2>
                <p class="font-body-md text-body-md text-on-surface-variant mb-6 leading-relaxed">
                    The PM Surya Ghar Muft Bijli Yojana is a landmark initiative designed to empower millions of households with sustainable, cost-free electricity. By facilitating the installation of rooftop solar panels, the scheme aims to reduce the financial burden on middle-class families while propelling India towards a greener future.
                </p>
                <p class="font-body-md text-body-md text-on-surface-variant mb-8 leading-relaxed">
                    Beyond just subsidies, it represents a shift towards decentralized energy generation, where every home becomes a mini power plant. Sahu Innovation is committed to translating this vision into reality with architectural solar excellence.
                </p>
                <div class="flex items-start gap-4 mb-6">
                    <div class="w-2 h-2 mt-2 rounded-full bg-secondary-container"></div>
                    <p class="font-body-md text-body-md text-on-surface">Target: Up to 300 units of free electricity per month.</p>
                </div>
                <div class="flex items-start gap-4">
                    <div class="w-2 h-2 mt-2 rounded-full bg-secondary-container"></div>
                    <p class="font-body-md text-body-md text-on-surface">Investment: ₹75,000+ crore allocated for nationwide implementation.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Eligibility Checklist -->
    <section class="py-section-padding px-8 bg-surface-container-lowest animate-on-scroll">
        <div class="max-w-container-max mx-auto">
            <div class="text-center mb-16">
                <h2 class="font-headline-h2 text-headline-h2 text-on-surface mb-4">Who is Eligible?</h2>
                <p class="font-body-md text-body-md text-on-surface-variant">Simple criteria to start your solar journey.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-surface p-6 md:p-8 rounded-xl border border-outline-variant/30 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                    <span class="material-symbols-outlined text-4xl text-secondary-container mb-6 block">home</span>
                    <h3 class="font-headline-h3 text-headline-h3 mb-4">Homeownership</h3>
                    <p class="font-body-md text-body-md text-on-surface-variant">Must be a citizen of India owning a house with a clear, shadow-free roof suitable for solar panel installation.</p>
                </div>
                <div class="bg-surface p-6 md:p-8 rounded-xl border border-outline-variant/30 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300 delay-100">
                    <span class="material-symbols-outlined text-4xl text-secondary-container mb-6 block">electric_meter</span>
                    <h3 class="font-headline-h3 text-headline-h3 mb-4">Valid Connection</h3>
                    <p class="font-body-md text-body-md text-on-surface-variant">Must have a valid and active electricity connection in the applicant's name with the local DISCOM.</p>
                </div>
                <div class="bg-surface p-6 md:p-8 rounded-xl border border-outline-variant/30 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300 delay-200">
                    <span class="material-symbols-outlined text-4xl text-secondary-container mb-6 block">receipt_long</span>
                    <h3 class="font-headline-h3 text-headline-h3 mb-4">No Prior Subsidy</h3>
                    <p class="font-body-md text-body-md text-on-surface-variant">The applicant must not have availed any other central or state subsidy for rooftop solar panels previously.</p>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include_once __DIR__ . '/includes/landing_footer.php'; ?>
