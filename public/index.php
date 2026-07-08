<?php
$pageTitle = "Premium Solar Solutions";
include_once __DIR__ . '/includes/landing_header.php';
?>

<main>
    <!-- Hero Section -->
    <section class="w-full pt-8 pb-section-padding px-gutter max-w-container-max mx-auto overflow-hidden">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-gutter items-center animate-on-scroll">
            <div class="col-span-1 md:col-span-5 flex flex-col items-start z-10">
                <h1 class="font-display text-display text-primary mb-6">
                    Get Free Electricity for Life
                </h1>
                <p class="font-body-lg text-body-lg text-on-surface-variant mb-10 max-w-md">
                    Harness the power of sustainable architecture. Elevate your property value while securing a future independent of the grid.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 w-full sm:w-auto">
                    <a href="<?= site_url('public/login.php') ?>" class="font-label-caps text-label-caps bg-primary-container text-on-primary px-8 py-4 rounded-xl hover:bg-primary transition-colors text-center">
                        Get Free Quote
                    </a>
                    <a href="<?= site_url('public/savings-benefits.php') ?>" class="font-label-caps text-label-caps bg-transparent border border-primary-container text-primary-container px-8 py-4 rounded-xl hover:bg-surface-variant transition-colors text-center">
                        Calculate Savings
                    </a>
                </div>
            </div>
            <div class="col-span-1 md:col-span-7 relative mt-12 md:mt-0">
                <div class="relative w-full aspect-[4/3] rounded-xl overflow-hidden shadow-sm shadow-primary-container/5 border border-outline-variant/30 bg-surface-container-lowest">
                    <img alt="Pristine modern home with sleek, flush-mounted solar panels seamlessly integrated into a dark angled roof against a clear blue sky" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuD0CvFGVWTIkSjJiWWbA-cugm7puWGxAGCP0AJWuEcJBmgvXqCrxq_sP6-PcmAWqikfLlovcrqNxdSBTKjC2QweoxeBpDs863lhtbT_NIt371klTuZE-GEP3e3I6Uqe2gySz6DJP366B0lRT1H1aFYd0oYXJkk9mfRQl-2DV8hNvpEvJTRFeRU3VpZv9Wdb1UKZWgu7jh3boo200kG1nEuJF9XX1qkZDkdnaWnJwwhsF1KzGcgFy7DMl2GIGXCklFtS9O7kNTKkIKcP"/>
                </div>
            </div>
        </div>
    </section>

    <!-- Social Proof / Trust Strip -->
    <section class="w-full border-t border-outline-variant/20 border-b bg-surface-container-lowest py-10 animate-on-scroll">
        <div class="max-w-container-max mx-auto px-gutter flex flex-col md:flex-row items-center justify-between gap-8 opacity-60 grayscale">
            <span class="font-label-caps text-label-caps text-outline uppercase tracking-widest whitespace-nowrap">Trusted by Industry Leaders</span>
            <div class="flex flex-wrap justify-center md:justify-end gap-12 items-center w-full">
                <span class="font-headline-h3 text-headline-h3 font-bold text-on-surface">SunPower</span>
                <span class="font-headline-h3 text-headline-h3 font-bold text-on-surface">Tesla</span>
                <span class="font-headline-h3 text-headline-h3 font-bold text-on-surface">Enphase</span>
                <span class="font-headline-h3 text-headline-h3 font-bold text-on-surface">SolarEdge</span>
            </div>
        </div>
    </section>

    <!-- Scheme Benefits (Bento Grid) -->
    <section class="w-full py-section-padding bg-background px-gutter animate-on-scroll">
        <div class="max-w-container-max mx-auto">
            <div class="mb-16 max-w-2xl">
                <h2 class="font-headline-h2 text-headline-h2 text-primary mb-4">Government Scheme Benefits</h2>
                <p class="font-body-lg text-body-lg text-on-surface-variant">Maximize your investment with exclusive national subsidies designed to accelerate the transition to clean energy.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Card 1 -->
                <div class="bg-surface-container-lowest border border-outline-variant/50 rounded-xl p-6 md:p-8 flex flex-col justify-between shadow-sm shadow-primary-container/5 relative overflow-hidden group hover:border-primary-container/30 hover:shadow-md hover:scale-[1.02] transition-all duration-300">
                    <div class="absolute top-0 right-0 p-6 opacity-5">
                        <span class="material-symbols-outlined text-[120px]">electric_bolt</span>
                    </div>
                    <div class="mb-8">
                        <div class="w-12 h-12 rounded-full bg-surface flex items-center justify-center border border-outline-variant/30 mb-6 text-primary-container">
                            <span class="material-symbols-outlined">bolt</span>
                        </div>
                        <h3 class="font-headline-h3 text-headline-h3 text-primary mb-2">300 Units Free Power</h3>
                        <p class="font-body-md text-body-md text-on-surface-variant">Eliminate your monthly utility bills entirely. The scheme guarantees a zero-cost energy baseline for standard household consumption.</p>
                    </div>
                    <div>
                        <a class="inline-flex items-center gap-2 font-label-caps text-label-caps text-secondary-container hover:text-secondary transition-colors group" href="<?= site_url('public/pm-surya-ghar.php') ?>">
                            Learn More <span class="material-symbols-outlined text-sm transition-transform group-hover:translate-x-1">arrow_forward</span>
                        </a>
                    </div>
                </div>
                <!-- Card 2 -->
                <div class="bg-surface-container-lowest border border-outline-variant/50 rounded-xl p-6 md:p-8 flex flex-col justify-between shadow-sm shadow-primary-container/5 relative overflow-hidden group hover:border-primary-container/30 hover:shadow-md hover:scale-[1.02] transition-all duration-300 delay-100">
                    <div class="absolute top-0 right-0 p-6 opacity-5">
                        <span class="material-symbols-outlined text-[120px]">account_balance</span>
                    </div>
                    <div class="mb-8">
                        <div class="w-12 h-12 rounded-full bg-surface flex items-center justify-center border border-outline-variant/30 mb-6 text-primary-container">
                            <span class="material-symbols-outlined">payments</span>
                        </div>
                        <h3 class="font-headline-h3 text-headline-h3 text-primary mb-2">₹1.3 Lakh Subsidy</h3>
                        <p class="font-body-md text-body-md text-on-surface-variant">Receive direct financial support deposited directly into your account, significantly lowering the initial barrier to entry.</p>
                    </div>
                    <div>
                        <a class="inline-flex items-center gap-2 font-label-caps text-label-caps text-secondary-container hover:text-secondary transition-colors group" href="<?= site_url('public/pm-surya-ghar.php') ?>">
                            Claim Subsidy <span class="material-symbols-outlined text-sm transition-transform group-hover:translate-x-1">arrow_forward</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About / Editorial Section -->
    <section class="w-full py-section-padding px-gutter bg-surface-container-lowest border-t border-outline-variant/20 animate-on-scroll">
        <div class="max-w-container-max mx-auto grid grid-cols-1 md:grid-cols-12 gap-gutter items-center">
            <div class="col-span-1 md:col-span-6 relative">
                <div class="relative w-full aspect-[3/4] rounded-xl overflow-hidden shadow-sm shadow-primary-container/5 border border-outline-variant/30">
                    <img alt="Abstract close-up of geometric solar panel cells reflecting soft evening light, showcasing premium texture and material" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDG6SRcQMeDCiWxoCyUZFoa-nEl3BOT6w9I-BsSRLlJwASmk2TzqHfFHhZxw3RJ8tQxMrfbssigRS7G6e26ZooHGt2-8EdNjBUl2T9DEOfcW0UqyM3ocAZGVJBvR3UQ7p8JqSR3CazuM81abRLokxN6QT5j5XWE--i3nWrAXY0L_UviF0JMZsflGAEMWzKxShieuE-j8GX7TeRuaTwVElbZfR0LJrVQ2zahlmAw6x_4_XFaOcZWo5CuxJmk6XW2xhaX9x34xxaTrhQd"/>
                </div>
                <!-- Editorial Accent -->
                <div class="absolute bottom-12 -right-6 w-12 h-12 rounded-full bg-secondary-container border-4 border-surface-container-lowest hidden md:block"></div>
            </div>
            <div class="col-span-1 md:col-span-5 md:col-start-8 flex flex-col justify-center py-12 md:py-0">
                <span class="font-label-caps text-label-caps text-outline mb-6 block uppercase tracking-widest">Our Philosophy</span>
                <h2 class="font-headline-h2 text-headline-h2 text-primary mb-8">Redefining Energy Independence</h2>
                <p class="font-body-lg text-body-lg text-on-surface-variant mb-6">
                    We believe that sustainable choices should not demand aesthetic compromise. Our approach marries cutting-edge photovoltaic technology with rigorous architectural integration.
                </p>
                <p class="font-body-md text-body-md text-on-surface-variant mb-10">
                    Every system we design is bespoke, engineered to outlast conventional infrastructure while silently powering your lifestyle. Welcome to the new standard of living.
                </p>
                <div>
                    <a class="inline-flex items-center gap-2 font-label-caps text-label-caps text-primary-container hover:text-primary transition-colors border-b border-primary-container pb-1" href="<?= site_url('public/about.php') ?>">
                        Explore Our Process
                    </a>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include_once __DIR__ . '/includes/landing_footer.php'; ?>
