<!-- Footer -->
<footer class="w-full bg-obsidian-deep border-t border-gold-imperial/20 mt-section-padding relative overflow-hidden text-on-surface">
    <!-- Atmospheric 3D Logo Watermark -->
    <div class="absolute -right-20 -bottom-20 opacity-[0.03] pointer-events-none select-none z-0">
        <img src="<?= site_url('public/assets/img/3D_logo.jpeg') ?>" alt="" class="w-[500px] h-auto object-cover filter contrast-200 grayscale"/>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-12 gap-12 px-6 md:px-12 py-16 max-w-container-max mx-auto relative z-10">
        <div class="col-span-1 md:col-span-5">
            <a class="flex items-center gap-3 mb-6" href="<?= site_url('public/index.php') ?>">
                <img alt="Sahu Innovation Logo" class="h-10 w-auto object-contain" src="<?= site_url('public/assets/img/logo.png') ?>"/>
                <div class="flex flex-col">
                    <span class="text-xl font-display font-bold tracking-tight text-white leading-none">SAHU</span>
                    <span class="gold-gradient-text font-serif-title text-[10px] font-semibold tracking-[0.22em] uppercase mt-0.5">INNOVATION</span>
                </div>
            </a>
            <p class="font-body-md text-sm leading-relaxed text-on-surface-variant max-w-md mb-8">
                Harmonizing advanced photovoltaic engineering with uncompromising architectural aesthetics. Sahu Innovation transforms luxury residential properties into self-sustaining powerhouses with guaranteed government subsidy verification and zero initial capital outlay.
            </p>
            <div class="flex flex-wrap gap-3">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-charcoal-surface border border-gold-imperial/30 text-xs font-mono-data text-gold-champagne">
                    <span class="material-symbols-outlined text-sm text-gold-imperial">shield</span>
                    25-Year Solar Warranty
                </span>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-charcoal-surface border border-gold-imperial/30 text-xs font-mono-data text-gold-champagne">
                    <span class="material-symbols-outlined text-sm text-gold-imperial">description</span>
                    5-Year Vendor Agreement
                </span>
            </div>
        </div>
        
        <div class="col-span-1 md:col-span-3 flex flex-col gap-3.5">
            <h4 class="font-label-caps text-gold-imperial mb-2 tracking-widest uppercase">Company & Philosophy</h4>
            <a class="font-body-md text-sm text-on-surface-variant hover:text-gold-champagne transition-colors flex items-center gap-2" href="<?= site_url('public/about.php') ?>">
                <span class="text-gold-imperial/60">▪</span> About Sahu Innovation
            </a>
            <a class="font-body-md text-sm text-on-surface-variant hover:text-gold-champagne transition-colors flex items-center gap-2" href="<?= site_url('public/about.php#warranties') ?>">
                <span class="text-gold-imperial/60">▪</span> Warranties & Legal Agreement
            </a>
            <a class="font-body-md text-sm text-on-surface-variant hover:text-gold-champagne transition-colors flex items-center gap-2" href="<?= site_url('public/how-it-works.php') ?>">
                <span class="text-gold-imperial/60">▪</span> 11-Stage Engineering Process
            </a>
            <a class="font-body-md text-sm text-on-surface-variant hover:text-gold-champagne transition-colors flex items-center gap-2" href="<?= site_url('public/savings-benefits.php') ?>">
                <span class="text-gold-imperial/60">▪</span> Financial ROI & Savings
            </a>
        </div>

        <div class="col-span-1 md:col-span-4 flex flex-col gap-3.5">
            <h4 class="font-label-caps text-gold-imperial mb-2 tracking-widest uppercase">PM Surya Ghar Yojana (₹1.3L Subsidy)</h4>
            <div class="p-4 rounded-xl bg-charcoal-surface border border-gold-imperial/20 shadow-lg">
                <p class="text-xs text-on-surface/90 font-mono-data mb-2">
                    <strong class="text-gold-champagne">Direct Subsidy Breakdown:</strong><br/>
                    • Central Subsidy: <span class="text-white">₹85,800</span> (30 Days)<br/>
                    • State Subsidy: <span class="text-white">₹45,000</span> (60-180 Days)<br/>
                    • Total Government Credit: <strong class="text-emerald-trust">₹1,30,800</strong>
                </p>
                <a href="<?= site_url('public/pm-surya-ghar.php') ?>" class="inline-flex items-center gap-1.5 text-xs font-label-caps text-gold-imperial hover:underline tracking-wider uppercase mt-1">
                    Document Verification Checklist &rarr;
                </a>
            </div>
            <div class="flex items-center gap-3 mt-2">
                <a href="<?= site_url('public/login.php') ?>" class="font-label-caps text-xs text-white bg-charcoal-light hover:bg-gold-imperial hover:text-obsidian-deep px-4 py-2 rounded-lg border border-gold-imperial/30 transition-all">Partner Portal Login</a>
                <a href="<?= site_url('public/about.php#calculator') ?>" class="font-label-caps text-xs text-gold-champagne hover:underline">Calculate Your Subsidy</a>
            </div>
        </div>
    </div>
    
    <div class="border-t border-outline-variant/20 py-6 px-6 md:px-12 max-w-container-max mx-auto flex flex-col sm:flex-row justify-between items-center gap-4 text-xs font-mono-data text-on-surface-variant/70 relative z-10">
        <div>
            © <?= date('Y') ?> Sahu Innovation. Architectural Solar Excellence. All rights reserved.
        </div>
        <div class="flex gap-6">
            <span>Zero Down Payment Available</span>
            <span>▪</span>
            <span>300 Units/Month Generation Guarantee</span>
        </div>
    </div>
</footer>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: "0px 0px -50px 0px"
    });

    document.querySelectorAll('.animate-on-scroll').forEach((el) => {
        observer.observe(el);
    });
});
</script>
</body>
</html>
