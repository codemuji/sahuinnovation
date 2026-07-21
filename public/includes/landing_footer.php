<!-- Footer -->
<footer class="w-full bg-navy-deep border-t border-gold-imperial/30 mt-section-padding relative overflow-hidden text-white shadow-2xl">
    <!-- Atmospheric 3D Logo Watermark -->
    <div class="absolute -right-20 -bottom-20 opacity-[0.04] pointer-events-none select-none z-0">
        <img src="<?= site_url('public/assets/img/3D_logo.jpeg') ?>" alt="" class="w-[500px] h-auto object-cover filter contrast-200 grayscale"/>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-12 gap-12 px-6 md:px-12 py-16 max-w-container-max mx-auto relative z-10">
        <div class="col-span-1 md:col-span-5">
            <a class="flex items-center gap-3.5 mb-6 group" href="<?= site_url('public/index.php') ?>">
                <img alt="Sahu Innovation Logo" class="h-11 w-auto object-contain transition-transform duration-300 group-hover:scale-105" src="<?= site_url('public/assets/img/logo.png') ?>"/>
                <div class="flex flex-col">
                    <span class="text-xl font-display font-bold tracking-tight text-white leading-none">SAHU</span>
                    <span class="gold-gradient-text font-serif-title text-[10px] font-semibold tracking-[0.22em] uppercase mt-0.5">INNOVATION</span>
                </div>
            </a>
            <p class="font-body-md text-sm leading-relaxed text-slate-300 max-w-md mb-8">
                Harmonizing advanced photovoltaic engineering with uncompromising architectural aesthetics. Sahu Innovation transforms luxury residential properties into self-sustaining powerhouses with guaranteed government subsidy verification and zero initial capital outlay.
            </p>
            <div class="flex flex-wrap gap-3">
                <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-navy-light border border-gold-imperial/40 text-xs font-mono-data text-gold-light shadow-sm">
                    <span class="material-symbols-outlined text-sm text-gold-imperial">shield</span>
                    25-Year Solar Warranty
                </span>
                <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-navy-light border border-gold-imperial/40 text-xs font-mono-data text-gold-light shadow-sm">
                    <span class="material-symbols-outlined text-sm text-gold-imperial">description</span>
                    5-Year Vendor Agreement
                </span>
            </div>
        </div>
        
        <div class="col-span-1 md:col-span-3 flex flex-col gap-3.5">
            <h4 class="font-label-caps text-gold-imperial font-bold mb-2 tracking-widest uppercase">Company & Philosophy</h4>
            <a class="font-body-md text-sm text-slate-300 hover:text-gold-imperial transition-colors flex items-center gap-2" href="<?= site_url('public/about.php') ?>">
                <span class="text-gold-imperial/60">▪</span> About Sahu Innovation
            </a>
            <a class="font-body-md text-sm text-slate-300 hover:text-gold-imperial transition-colors flex items-center gap-2" href="<?= site_url('public/about.php#warranties') ?>">
                <span class="text-gold-imperial/60">▪</span> Warranties & Legal Agreement
            </a>
            <a class="font-body-md text-sm text-slate-300 hover:text-gold-imperial transition-colors flex items-center gap-2" href="<?= site_url('public/how-it-works.php') ?>">
                <span class="text-gold-imperial/60">▪</span> 11-Stage Engineering Process
            </a>
            <a class="font-body-md text-sm text-slate-300 hover:text-gold-imperial transition-colors flex items-center gap-2" href="<?= site_url('public/savings-benefits.php') ?>">
                <span class="text-gold-imperial/60">▪</span> Financial ROI & Savings
            </a>
        </div>

        <div class="col-span-1 md:col-span-4 flex flex-col gap-3.5">
            <h4 class="font-label-caps text-gold-imperial font-bold mb-2 tracking-widest uppercase">PM Surya Ghar Yojana (₹1.3L Subsidy)</h4>
            <div class="p-5 rounded-xl bg-navy-light/90 border border-gold-imperial/30 shadow-xl backdrop-blur-md">
                <p class="text-xs text-slate-200 font-mono-data mb-3 leading-relaxed">
                    <strong class="text-gold-light font-bold">Direct Subsidy Breakdown:</strong><br/>
                    • Central Subsidy: <span class="text-white font-bold">₹85,800</span> (30 Days)<br/>
                    • State Subsidy: <span class="text-white font-bold">₹45,000</span> (60-180 Days)<br/>
                    • Total Government Credit: <strong class="text-emerald-400 font-bold">₹1,30,800</strong>
                </p>
                <a href="<?= site_url('public/pm-surya-ghar.php') ?>" class="inline-flex items-center gap-1.5 text-xs font-label-caps text-gold-imperial hover:underline tracking-wider uppercase mt-1 font-bold">
                    Document Verification Checklist &rarr;
                </a>
            </div>
            <div class="flex items-center gap-3 mt-2">
                <a href="<?= site_url('public/login.php') ?>" class="font-label-caps text-xs text-white bg-navy-primary hover:bg-gold-imperial hover:text-navy-deep px-4 py-2.5 rounded-lg border border-gold-imperial/40 transition-all font-bold shadow-sm">Partner Portal Login</a>
                <a href="<?= site_url('public/about.php#calculator') ?>" class="font-label-caps text-xs text-gold-light hover:underline font-bold">Calculate Your Subsidy</a>
            </div>
        </div>
    </div>
    
    <div class="border-t border-white/10 py-6 px-6 md:px-12 max-w-container-max mx-auto flex flex-col sm:flex-row justify-between items-center gap-4 text-xs font-mono-data text-slate-400 relative z-10">
        <div>
            © <?= date('Y') ?> Sahu Innovation. Architectural Solar Excellence. All rights reserved.
        </div>
        <div class="flex gap-6">
            <span class="text-slate-300">Zero Down Payment Available</span>
            <span>▪</span>
            <span class="text-slate-300">300 Units/Month Generation Guarantee</span>
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
