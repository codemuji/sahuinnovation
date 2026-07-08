<!-- Footer -->
<footer class="w-full bg-[#FAF9F6] border-t border-[#E5DED4] mt-section-padding">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-12 px-6 md:px-12 py-12 md:py-16 max-w-container-max mx-auto">
        <div class="col-span-1 md:col-span-2">
            <a class="text-xl font-display font-black text-[#0B1F3A] block mb-6" href="#">Sahu Innovation</a>
            <p class="font-body-md text-sm tracking-wide text-[#0B1F3A]/60 max-w-sm">
                © <?= date('Y') ?> Sahu Innovation. Architectural Solar Excellence. Designed for a sustainable future.
            </p>
        </div>
        <div class="col-span-1 flex flex-col gap-4">
            <h4 class="font-label-caps text-label-caps text-[#0B1F3A] mb-2">Company</h4>
            <a class="font-body-md text-sm text-[#0B1F3A]/60 hover:text-[#0B1F3A] transition-opacity" href="<?= site_url('public/about.php') ?>">About Us</a>
            <a class="font-body-md text-sm text-[#0B1F3A]/60 hover:text-[#0B1F3A] transition-opacity" href="<?= site_url('public/how-it-works.php') ?>">Process</a>
            <a class="font-body-md text-sm text-[#0B1F3A]/60 hover:text-[#0B1F3A] transition-opacity" href="<?= site_url('public/savings-benefits.php') ?>">Savings</a>
        </div>
        <div class="col-span-1 flex flex-col gap-4">
            <h4 class="font-label-caps text-label-caps text-[#0B1F3A] mb-2">Portal</h4>
            <a class="font-body-md text-sm text-[#0B1F3A]/60 hover:text-[#0B1F3A] transition-opacity" href="<?= site_url('public/login.php') ?>">Login</a>
            <a class="font-body-md text-sm text-[#0B1F3A]/60 hover:text-[#0B1F3A] transition-opacity" href="#">Partner Portal</a>
        </div>
    </div>
</footer>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                // Optional: stop observing once animated
                // observer.unobserve(entry.target); 
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
