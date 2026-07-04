<footer class="bg-slate-950 text-slate-400 pt-32 pb-16 relative overflow-hidden">
    <!-- Sophisticated Background Pattern -->
    <div class="absolute inset-0 opacity-[0.03] pointer-events-none">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cpath d=\"M54.627 0l.83.83L6.12 50.166l-.83-.83L54.627 0zM.664 54.627L6.12 60l-.83-.83-4.626-4.626.83-.83-.664.83zM0 54.627L54.627 0h.83L0 55.457v-.83zm60 6.12l-6.12-6.12.83-.83 6.12 6.12v.83zM0 6.12L6.12 0h.83L0 6.95v-.83zm60 54.627L6.12 6.12.83-5.29 6.12 0v6.12zm0-6.12L6.12 60h.83L0 6.95v-.83z\" fill=\"%23d4af37\" fill-opacity=\"0.4\" fill-rule=\"evenodd\"/%3E%3C/svg%3E');"></div>
    </div>

    <div class="max-w-[1400px] mx-auto px-8 relative z-10 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-16 lg:gap-8">
        <!-- Brand Narrative -->
        <div class="lg:col-span-4 max-w-sm">
            <a href="<?php echo BASE_URL; ?>index.php" class="flex items-center gap-4 mb-10 group">
                <img src="<?php echo BASE_URL; ?>images/imageshine.png" alt="Logo" class="w-12 h-12 object-contain grayscale brightness-200">
                <span class="text-3xl font-bold text-white font-serif tracking-tight">Shine <span class="text-white italic font-light">Jewellers</span></span>
            </a>
            <p class="text-slate-500 leading-relaxed italic text-lg mb-10">
                "We don't merely craft jewellery; we forge legacies that transcend generations. Every facet is a story, every metal a silent oath of timelessness."
            </p>
            <div class="flex gap-6">
                <a href="#" class="w-12 h-12 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center hover:bg-primary hover:text-black transition-all duration-500 group">
                    <i class="fa-brands fa-instagram text-lg group-hover:scale-110 transition"></i>
                </a>
                <a href="#" class="w-12 h-12 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center hover:bg-primary hover:text-black transition-all duration-500 group">
                    <i class="fa-brands fa-facebook-f text-lg group-hover:scale-110 transition"></i>
                </a>
                <a href="#" class="w-12 h-12 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center hover:bg-primary hover:text-black transition-all duration-500 group">
                    <i class="fa-brands fa-pinterest-p text-lg group-hover:scale-110 transition"></i>
                </a>
            </div>
        </div>

        <!-- Links Grid -->
        <div class="lg:col-span-2">
            <h3 class="text-white font-bold mb-10 uppercase tracking-[0.3em] text-[10px]">Quick Links</h3>
            <ul class="space-y-5">
                <li><a href="<?php echo BASE_URL; ?>index.php" class="text-sm hover:text-white transition-all duration-300 flex items-center gap-2 group"><span class="w-0 group-hover:w-4 h-[1px] bg-primary transition-all"></span> Home</a></li>
                <li><a href="<?php echo BASE_URL; ?>user/collections.php" class="text-sm hover:text-white transition-all duration-300 flex items-center gap-2 group"><span class="w-0 group-hover:w-4 h-[1px] bg-primary transition-all"></span> Collections</a></li>
                <li><a href="<?php echo BASE_URL; ?>user/collections.php?category=New" class="text-sm hover:text-white transition-all duration-300 flex items-center gap-2 group"><span class="w-0 group-hover:w-4 h-[1px] bg-primary transition-all"></span> New Arrivals</a></li>
                <li><a href="<?php echo BASE_URL; ?>user/offers.php" class="text-sm hover:text-white transition-all duration-300 flex items-center gap-2 group"><span class="w-0 group-hover:w-4 h-[1px] bg-primary transition-all"></span> Special Offers</a></li>
            </ul>
        </div>

        <div class="lg:col-span-2">
            <h3 class="text-white font-bold mb-10 uppercase tracking-[0.3em] text-[10px]">Customer Care</h3>
            <ul class="space-y-5">
                <li><a href="<?php echo BASE_URL; ?>user/ordertrack.php" class="text-sm hover:text-white transition-all duration-300 flex items-center gap-2 group"><span class="w-0 group-hover:w-4 h-[1px] bg-primary transition-all"></span> Track Order</a></li>
                <li><a href="<?php echo BASE_URL; ?>user/returnpolicy.php" class="text-sm hover:text-white transition-all duration-300 flex items-center gap-2 group"><span class="w-0 group-hover:w-4 h-[1px] bg-primary transition-all"></span> Returns & Refunds</a></li>
                <li><a href="<?php echo BASE_URL; ?>user/contactnew.php" class="text-sm hover:text-white transition-all duration-300 flex items-center gap-2 group"><span class="w-0 group-hover:w-4 h-[1px] bg-primary transition-all"></span> Contact Us</a></li>
                <li><a href="#" class="text-sm hover:text-white transition-all duration-300 flex items-center gap-2 group"><span class="w-0 group-hover:w-4 h-[1px] bg-primary transition-all"></span> FAQ</a></li>
            </ul>
        </div>

        <!-- Contact & Newsletter -->
        <div class="lg:col-span-4">
            <h3 class="text-white font-bold mb-10 uppercase tracking-[0.3em] text-[10px]">Newsletter</h3>
            <div class="bg-white/5 p-8 rounded-[2rem] border border-white/5 backdrop-blur-sm">
                <p class="text-xs text-slate-400 mb-6 font-medium leading-relaxed uppercase tracking-wider">Join for exclusive updates and new arrivals.</p>
                <div class="relative flex mb-8">
                    <input type="email" placeholder="Enter Email" class="bg-white/5 border-none rounded-2xl py-5 pl-8 pr-16 text-sm w-full focus:ring-1 focus:ring-primary/40 outline-none transition-all placeholder:text-slate-600">
                    <button class="absolute right-2 top-2 bottom-2 bg-primary text-black px-6 rounded-xl hover:bg-white transition-all duration-500 shadow-xl">
                        <i class="fa-solid fa-paper-plane"></i>
                    </button>
                </div>
                <div class="flex flex-col gap-4 text-xs">
                    <div class="flex items-center gap-4 text-slate-500">
                        <i class="fa-solid fa-location-dot text-white w-4"></i>
                        <span>Main Market, Near MIT, Basmath</span>
                    </div>
                    <div class="flex items-center gap-4 text-slate-500">
                        <i class="fa-solid fa-phone-volume text-white w-4"></i>
                        <span>+91 98765 43210</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Rights & Legal -->
    <div class="max-w-[1400px] mx-auto px-8 mt-32 pt-12 border-t border-white/5 flex flex-col md:flex-row justify-between items-center gap-10">
        <p class="text-[10px] font-bold uppercase tracking-[0.4em] text-slate-600">
            © <?php echo date('Y'); ?> Shine Jewellers Heritage. Forged with passion.
        </p>
        <div class="flex gap-12 text-[10px] font-bold uppercase tracking-[0.3em] text-slate-600">
            <a href="#" class="hover:text-white transition-colors">Privacy Policy</a>
            <a href="#" class="hover:text-white transition-colors">Terms of Service</a>
            <a href="#" class="hover:text-white transition-colors">Cookies Policy</a>
        </div>
    </div>
</footer>

</body>
</html>
