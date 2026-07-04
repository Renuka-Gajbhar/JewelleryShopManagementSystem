<?php 
require_once '../includes/Config.php';
include '../includes/header.php'; 
?>

<div class="bg-gray-50 py-24 min-h-screen">
    <div class="max-w-[1400px] mx-auto px-8">
        <div class="max-w-4xl mx-auto text-center mb-20">
            <span class="text-white font-bold uppercase tracking-[0.4em] text-xs mb-4 block">Assurance & Trust</span>
            <h1 class="text-4xl md:text-5xl font-serif font-bold text-gray-900 mb-8 leading-tight">Return & <span class="italic text-[#d4af37]">Exchange</span> Policy</h1>
            <p class="text-gray-400 font-light text-lg leading-relaxed max-w-2xl mx-auto">
                Our commitment to excellence extends beyond the acquisition. We ensure your satisfaction with transparent and fair policies.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 max-w-5xl mx-auto mb-20">
            <div class="bg-white rounded-[3rem] p-12 shadow-sm border border-gray-100 hover:shadow-2xl transition duration-700">
                <div class="w-16 h-16 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-500 text-2xl mb-8">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-6 font-serif italic">Eligibility for Return</h2>
                <ul class="space-y-4">
                    <li class="flex items-center gap-4 text-gray-500 font-light">
                        <div class="w-1.5 h-1.5 rounded-full bg-primary/40"></div>
                        Initiate within <strong class="text-gray-900 font-bold">7 days</strong> of purchase.                    </li>
                    <li class="flex items-center gap-4 text-gray-500 font-light">
                        <div class="w-1.5 h-1.5 rounded-full bg-primary/40"></div>
                        Product must be <strong class="text-gray-900 font-bold">unused</strong> & in original state.
                    </li>
                    <li class="flex items-center gap-4 text-gray-500 font-light">
                        <div class="w-1.5 h-1.5 rounded-full bg-primary/40"></div>
                        Original <strong class="text-gray-900 font-bold">Tag and Invoice</strong> must be present.
                    </li>
                </ul>
            </div>

            <div class="bg-white rounded-[3rem] p-12 shadow-sm border border-gray-100 hover:shadow-2xl transition duration-700">
                <div class="w-16 h-16 bg-red-50 rounded-2xl flex items-center justify-center text-red-500 text-2xl mb-8">
                    <i class="fa-solid fa-circle-xmark"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-6 font-serif italic">Non-Returnable Items</h2>
                <ul class="space-y-4">
                    <li class="flex items-center gap-4 text-gray-500 font-light">
                        <div class="w-1.5 h-1.5 rounded-full bg-red-200"></div>
                        Bespoke and <strong class="text-gray-900 font-bold">Customized creations</strong>.
                    </li>
                    <li class="flex items-center gap-4 text-gray-500 font-light">
                        <div class="w-1.5 h-1.5 rounded-full bg-red-200"></div>
                        Loose <strong class="text-gray-900 font-bold">Gemstones and Diamonds</strong>.
                    </li>
                    <li class="flex items-center gap-4 text-gray-500 font-light">
                        <div class="w-1.5 h-1.5 rounded-full bg-red-200"></div>
                        Items showing signs of <strong class="text-gray-900 font-bold">wear or damage</strong>.
                    </li>
                </ul>
            </div>
        </div>

        <div class="max-w-2xl mx-auto bg-black rounded-[3.5rem] p-12 text-center shadow-2xl relative overflow-hidden">
            <div class="absolute inset-0 opacity-20">
                <img src="https://images.unsplash.com/photo-1601121141461-9d6647bca1ed?q=80&w=2031&auto=format&fit=crop" class="w-full h-full object-cover grayscale" alt="Bkg">
            </div>
            <div class="relative z-10">
                <div class="flex items-center justify-center gap-4 mb-10">
                    <input type="checkbox" id="agree" class="w-6 h-6 rounded border-white/20 bg-white/5 text-white focus:ring-primary/40 focus:ring-offset-black">
                        I have read and agreed to the <span class="text-white border-b border-primary/40">Return Policy</span>.
                </div>
                <button id="returnBtn" disabled onclick="returnRequest()" 
                    class="w-full bg-primary text-black py-6 rounded-3xl font-bold text-lg hover:scale-105 transition-all shadow-xl shadow-primary/10 disabled:opacity-20 disabled:cursor-not-allowed disabled:hover:scale-100">
                    Request Return
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    const agreeCheckbox = document.getElementById("agree");
    const returnBtn = document.getElementById("returnBtn");

    agreeCheckbox.addEventListener("change", function () {
        returnBtn.disabled = !this.checked;
    });

    function returnRequest() {
        showToast("✅ Your request has been sent to our support team.", "success");
    }
</script>

<?php include '../includes/footer.php'; ?>
