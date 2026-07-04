<?php 
require_once '../includes/Config.php';
include '../includes/header.php'; 
?>

<div class="bg-gray-50 py-16 min-h-screen">
    <div class="max-w-[1400px] mx-auto px-8">
        <!-- Luxury Banner -->
        <div class="bg-black rounded-[3rem] p-10 md:p-16 relative overflow-hidden mb-16 shadow-2xl">
            <div class="absolute inset-0 opacity-40">
                <img src="https://images.unsplash.com/photo-1549416805-4f40f09079be?q=80&w=2070&auto=format&fit=crop" class="w-full h-full object-cover grayscale brightness-50" alt="Background">
            </div>
            <div class="relative z-10 text-center max-w-3xl mx-auto border border-[#d4af37]/20 p-10 rounded-3xl backdrop-blur-sm bg-black/40">
                <span class="text-[#d4af37] font-bold uppercase tracking-[0.5em] text-xs mb-4 block">Exclusive Offers</span>
                <h1 class="text-4xl md:text-5xl font-serif font-bold text-white mb-6">Special <span class="italic">Deals</span></h1>
                <p class="text-gray-300 font-light mb-8 text-lg leading-relaxed">Save more on your favorite jewellery with our seasonal offers. Specially curated for our valued customers.</p>
                <div class="inline-flex items-center gap-4 bg-[#d4af37]/10 border border-[#d4af37]/20 px-8 py-4 rounded-full backdrop-blur-md">
                    <span class="text-[#d4af37] text-sm uppercase tracking-widest font-bold">Use Coupon Code:</span>
                    <span class="text-white text-xl font-bold font-serif tracking-widest">GOLD10</span>
                </div>
            </div>
            <!-- Animated dots or something -->
            <div class="absolute top-10 left-10 w-2 h-2 bg-[#d4af37] rounded-full animate-pulse-slow"></div>
            <div class="absolute bottom-10 right-10 w-2 h-2 bg-[#d4af37] rounded-full animate-pulse-slow delay-700"></div>
        </div>

        <!-- Offers Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
            <div class="group bg-white rounded-3xl p-8 shadow-sm hover:shadow-2xl transition-all duration-700 border border-gray-100 flex flex-col items-center text-center relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-[#d4af37]/5 rounded-full -translate-x-1/2 -translate-y-1/2 blur-2xl group-hover:bg-[#d4af37]/20 transition duration-700"></div>
                
                <div class="w-16 h-16 bg-slate-50 border border-slate-100 rounded-2xl flex items-center justify-center text-[#d4af37] text-2xl mb-6 group-hover:scale-110 group-hover:rotate-12 transition duration-500">
                    <i class="fa-solid fa-gem"></i>
                </div>
                
                <h3 class="text-xl font-bold text-gray-900 mb-3 font-serif italic">Wedding Special</h3>
                <p class="text-gray-400 mb-8 font-light leading-relaxed text-sm">Make your special day even better with <span class="text-[#d4af37] font-bold">10% OFF</span> on our entire gold collection.</p>
                
                <div class="w-full mt-auto space-y-4">
                    <div class="bg-gray-50 border border-dashed border-gray-200 py-3 rounded-xl flex items-center justify-center gap-3">
                        <span class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Code:</span>
                        <span class="text-[#d4af37] font-bold font-serif">GOLD10</span>
                    </div>
                    <button onclick="applyOffer('GOLD10')" class="w-full bg-slate-900 text-white py-4 rounded-xl font-bold hover:bg-[#d4af37] hover:text-black transition shadow-xl active:scale-95 text-xs uppercase tracking-widest border border-transparent hover:border-[#d4af37]">Apply Offer</button>
                </div>
            </div>

            <div class="group bg-white rounded-3xl p-8 shadow-sm hover:shadow-2xl transition-all duration-700 border border-gray-100 flex flex-col items-center text-center relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-[#d4af37]/5 rounded-full -translate-x-1/2 -translate-y-1/2 blur-2xl group-hover:bg-[#d4af37]/20 transition duration-700"></div>
                
                <div class="w-16 h-16 bg-slate-50 border border-slate-100 rounded-2xl flex items-center justify-center text-[#d4af37] text-2xl mb-6 group-hover:scale-110 group-hover:rotate-12 transition duration-500">
                    <i class="fa-solid fa-star"></i>
                </div>
                
                <h3 class="text-xl font-bold text-gray-900 mb-3 font-serif italic">Diamond Delight</h3>
                <p class="text-gray-400 mb-8 font-light leading-relaxed text-sm">Get a flat <span class="text-[#d4af37] font-bold">₹5,000 discount</span> on our selected diamond collection.</p>
                
                <div class="w-full mt-auto space-y-4">
                    <div class="bg-gray-50 border border-dashed border-gray-200 py-3 rounded-xl flex items-center justify-center gap-3">
                        <span class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Code:</span>
                        <span class="text-[#d4af37] font-bold font-serif">DIAMOND5K</span>
                    </div>
                    <button onclick="applyOffer('DIAMOND5K')" class="w-full bg-slate-900 text-white py-4 rounded-xl font-bold hover:bg-[#d4af37] hover:text-black transition shadow-xl active:scale-95 text-xs uppercase tracking-widest border border-transparent hover:border-[#d4af37]">Apply Offer</button>
                </div>
            </div>

            <div class="group bg-white rounded-3xl p-8 shadow-sm hover:shadow-2xl transition-all duration-700 border border-gray-100 flex flex-col items-center text-center relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-[#d4af37]/5 rounded-full -translate-x-1/2 -translate-y-1/2 blur-2xl group-hover:bg-[#d4af37]/20 transition duration-700"></div>
                
                <div class="w-16 h-16 bg-slate-50 border border-slate-100 rounded-2xl flex items-center justify-center text-[#d4af37] text-2xl mb-6 group-hover:scale-110 group-hover:rotate-12 transition duration-500">
                    <i class="fa-solid fa-gift"></i>
                </div>
                
                <h3 class="text-xl font-bold text-gray-900 mb-3 font-serif italic">Festival Special</h3>
                <p class="text-gray-400 mb-8 font-light leading-relaxed text-sm">Enjoy <span class="text-[#d4af37] font-bold">Zero Making Charges</span> on all collections.</p>
                
                <div class="w-full mt-auto space-y-4">
                    <div class="bg-gray-50 border border-dashed border-gray-200 py-3 rounded-xl flex items-center justify-center gap-3">
                        <span class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Code:</span>
                        <span class="text-[#d4af37] font-bold font-serif">NOMAKE</span>
                    </div>
                    <button onclick="applyOffer('NOMAKE')" class="w-full bg-slate-900 text-white py-4 rounded-xl font-bold hover:bg-[#d4af37] hover:text-black transition shadow-xl active:scale-95 text-xs uppercase tracking-widest border border-transparent hover:border-[#d4af37]">Apply Offer</button>
                </div>
            </div>
        </div>

        <!-- Presentation Video -->
        <div class="mt-20">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-bold text-gray-900 mb-4 font-serif italic">The Art of Creation</h2>
                <div class="w-24 h-1 bg-[#d4af37] mx-auto rounded-full"></div>
            </div>
            <div class="max-w-[1000px] mx-auto rounded-3xl overflow-hidden shadow-2xl border-4 border-white bg-white">
                <iframe width="100%" height="450" src="https://www.youtube.com/embed/SpUK7U7kDtE" title="Jewellery Video Presentation" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes pulse-slow {
    0%, 100% { opacity: 0.3; transform: scale(1); }
    50% { opacity: 1; transform: scale(1.5); }
}
.animate-pulse-slow { animation: pulse-slow 4s infinite ease-in-out; }
</style>

<script>
    function applyOffer(code) {
        localStorage.setItem("appliedOffer", code);
        showToast(`✅ ${code} Activated. Discount applied to your cart.`, "success");
    }
</script>

<?php include '../includes/footer.php'; ?>
