<?php
require_once '../includes/Config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: " . BASE_URL . "auth/login.php");
    exit();
}
?>
<?php include '../includes/header.php'; ?>

<div class="bg-slate-50 min-h-screen py-10 lg:py-16">
    <div class="max-w-[1400px] mx-auto px-8">
        <!-- Breadcrumbs -->
        <nav class="flex items-center gap-3 text-[10px] uppercase tracking-[0.3em] text-gray-400 mb-12">
            <a href="<?php echo BASE_URL; ?>index.php" class="hover:text-white transition">Home</a>
            <span class="w-1 h-1 rounded-full bg-gray-300"></span>
            <a href="card.php" class="hover:text-white transition">Cart</a>
            <span class="w-1 h-1 rounded-full bg-gray-300"></span>
            <span class="text-gray-900 font-bold tracking-widest">CHECKOUT</span>
        </nav>

        <div class="mb-12">
            <span class="text-[#d4af37] font-bold tracking-[0.4em] text-[10px] uppercase mb-4 block">SECURE CHECKOUT</span>
            <h1 class="text-4xl md:text-5xl font-bold text-slate-900 font-serif">Checkout</h1>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-16">
            <!-- Delivery Details -->
            <div class="lg:col-span-8">
                <div class="bg-white rounded-[4rem] p-8 md:p-12 shadow-2xl border border-white relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-slate-50 rounded-full blur-[100px] -translate-y-1/2 translate-x-1/2 opacity-60"></div>
                    
                    <div class="flex items-center gap-6 mb-16 relative z-10">
                        <div class="w-14 h-14 rounded-2xl bg-slate-900 flex items-center justify-center text-white font-serif font-bold text-2xl shadow-xl">1</div>
                        <div>
                            <h2 class="text-3xl font-bold text-slate-900 font-serif">Delivery Details</h2>
                            <p class="text-xs text-slate-400 font-bold uppercase tracking-[0.2em] mt-1">Where should we deliver your order?</p>
                        </div>
                    </div>

                    <form id="checkout-form" class="space-y-10 relative z-10" onsubmit="return startPayment(event)">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                            <div class="group">
                                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-3 block group-focus-within:text-white transition">Full Name</label>
                                <input type="text" id="name" required value="<?php echo htmlspecialchars($_SESSION['user_name']); ?>" 
                                    class="w-full bg-slate-50 border-none rounded-2xl py-5 px-8 focus:ring-2 focus:ring-[#d4af37]/20 focus:bg-white transition-all outline-none font-medium">
                            </div>
                            <div class="group">
                                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-3 block group-focus-within:text-white transition">Mobile Number</label>
                                <input type="tel" id="mobile" required placeholder="+91 00000 00000" 
                                    class="w-full bg-slate-50 border-none rounded-2xl py-5 px-8 focus:ring-2 focus:ring-[#d4af37]/20 focus:bg-white transition-all outline-none font-medium">
                            </div>
                        </div>

                        <div class="group md:col-span-2">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-3 block group-focus-within:text-white transition">Email Address</label>
                            <input type="email" id="email" required value="<?php echo htmlspecialchars($_SESSION['user_email']); ?>" 
                                class="w-full bg-slate-50 border-none rounded-2xl py-5 px-8 focus:ring-2 focus:ring-[#d4af37]/20 focus:bg-white transition-all outline-none font-medium">
                        </div>

                        <div class="group">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-3 block group-focus-within:text-white transition">Street Address</label>
                            <textarea id="address" required rows="3" placeholder="Flat/House No., Street, Landmark" 
                                class="w-full bg-slate-50 border-none rounded-2xl py-5 px-8 focus:ring-2 focus:ring-[#d4af37]/20 focus:bg-white transition-all outline-none resize-none font-medium"></textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                            <div class="group">
                                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-3 block group-focus-within:text-white transition">City</label>
                                <input type="text" id="city" required class="w-full bg-slate-50 border-none rounded-2xl py-5 px-8 focus:ring-2 focus:ring-[#d4af37]/20 focus:bg-white transition-all outline-none font-medium">
                            </div>
                            <div class="group">
                                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-3 block group-focus-within:text-white transition">State</label>
                                <input type="text" id="state" required class="w-full bg-slate-50 border-none rounded-2xl py-5 px-8 focus:ring-2 focus:ring-[#d4af37]/20 focus:bg-white transition-all outline-none font-medium">
                            </div>
                            <div class="group">
                                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-3 block group-focus-within:text-white transition">Pincode</label>
                                <input type="text" id="pincode" required class="w-full bg-slate-50 border-none rounded-2xl py-5 px-8 focus:ring-2 focus:ring-[#d4af37]/20 focus:bg-white transition-all outline-none font-medium">
                            </div>
                        </div>

                        <input type="hidden" id="finalHiddenTotal">
                        <input type="hidden" id="cartDataJson">

                        <div class="pt-16">
                            <button type="submit" id="place-order-btn" class="w-full bg-slate-900 text-white py-6 rounded-3xl font-bold text-sm uppercase tracking-[0.4em] hover:bg-[#d4af37] hover:text-black transition-all duration-500 shadow-xl flex items-center justify-center gap-6 active:scale-95 border border-transparent hover:border-[#d4af37]">
                                Place Order <i class="fa-solid fa-arrow-right-long"></i>
                            </button>
                            <p class="text-center mt-6 text-[9px] text-slate-400 font-bold uppercase tracking-[0.3em]">Secured Offline Checkout</p>
                        </div>
                    </form>
                </div>
            </div>

            <!-- The Summary Sidebar -->
            <div class="lg:col-span-4">
                <div class="bg-white p-10 rounded-3xl shadow-2xl border border-slate-50 sticky top-24">
                    <div class="flex items-center gap-6 mb-10 pb-8 border-b border-slate-50">
                        <div class="w-12 h-12 rounded-2xl bg-[#d4af37]/5 flex items-center justify-center text-[#d4af37] font-serif font-bold text-2xl border border-[#d4af37]/20">2</div>
                        <div>
                            <h2 class="text-2xl font-bold text-slate-900 font-serif">Order Summary</h2>
                            <p class="text-[9px] text-slate-400 font-bold uppercase tracking-[0.2em] mt-1">Review your items</p>
                        </div>
                    </div>

                    <div id="checkout-items" class="max-h-[400px] overflow-y-auto pr-6 mb-12 space-y-6 custom-scrollbar">
                        <!-- Items rendered by JS -->
                    </div>

                    <div class="space-y-6 pt-10 border-t border-slate-50">
                        <div class="flex justify-between items-center text-slate-400">
                            <span class="text-[10px] font-bold uppercase tracking-wider">Subtotal</span>
                            <span id="subtotal" class="text-slate-900 font-bold font-serif text-lg">₹0</span>
                        </div>
                        <div class="flex justify-between items-center text-slate-400">
                            <span class="text-[10px] font-bold uppercase tracking-wider">Shipping</span>
                            <span class="text-[#d4af37] font-bold uppercase tracking-[0.2em] text-[9px] px-3 py-1 bg-[#d4af37]/5 border border-[#d4af37]/20 rounded-full">Free</span>
                        </div>
                        <div class="flex justify-between items-center text-slate-400">
                            <span class="text-[10px] font-bold uppercase tracking-wider">GST (3%)</span>
                            <span id="tax" class="text-slate-900 font-bold font-serif text-lg">₹0</span>
                        </div>
                        <div class="pt-10 mt-6 border-t-[1px] border-slate-100 flex flex-col items-center">
                            <span class="text-[10px] font-bold text-slate-300 uppercase tracking-[0.6em] mb-4">Total Amount</span>
                            <span id="grand-total" class="text-5xl font-bold text-slate-900 font-serif">₹0</span>
                        </div>
                    </div>

                    <div class="mt-12 p-8 bg-slate-50 rounded-[2rem] border border-slate-100">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-8 h-8 rounded-full bg-emerald-500/10 flex items-center justify-center text-emerald-500">
                                <i class="fa-solid fa-lock text-xs"></i>
                            </div>
                            <span class="text-[10px] font-bold text-slate-700 uppercase tracking-widest">Secure Payment</span>
                        </div>
                        <p class="text-[10px] text-slate-400 leading-relaxed italic">"Your payment information is processed securely through encrypted channels."</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.custom-scrollbar::-webkit-scrollbar { width: 3px; }
.custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
.custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
</style>

</style>

<script>
    let grandTotalAmt = 0;
    
    document.addEventListener("DOMContentLoaded", () => {
        const cart = JSON.parse(localStorage.getItem("cart")) || [];
        if (cart.length === 0) {
            window.location.href = "card.php";
            return;
        }
        
        document.getElementById('cartDataJson').value = JSON.stringify(cart);
        
        const itemsContainer = document.getElementById("checkout-items");
        let subtotalAmt = 0;
        
        cart.forEach(item => {
            const hasQty = item.qty || 1;
            const itemTotal = item.price * hasQty;
            subtotalAmt += itemTotal;
            itemsContainer.innerHTML += `
                <div class="flex gap-6 items-center group">
                    <div class="w-16 h-20 rounded-xl overflow-hidden bg-slate-50 flex-shrink-0 border border-slate-100 shadow-inner">
                        <img src="${BASE_URL}${item.image}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700" onerror="this.src='${BASE_URL}images/download.png'">
                    </div>
                    <div class="flex-grow">
                        <p class="text-sm font-bold text-slate-900 font-serif line-clamp-1 mb-1">${item.name}</p>
                        <p class="text-[9px] text-slate-400 font-bold tracking-[0.1em] uppercase">${hasQty} x ₹${new Intl.NumberFormat('en-IN').format(item.price)}</p>
                    </div>
                    <span class="text-sm font-bold text-slate-900 font-serif whitespace-nowrap">₹${new Intl.NumberFormat('en-IN').format(itemTotal)}</span>
                </div>
            `;
        });
        
        const taxAmt = Math.round(subtotalAmt * 0.03);
        grandTotalAmt = subtotalAmt + taxAmt;
        
        document.getElementById("subtotal").innerText = '₹' + new Intl.NumberFormat('en-IN').format(subtotalAmt);
        document.getElementById("tax").innerText = '₹' + new Intl.NumberFormat('en-IN').format(taxAmt);
        document.getElementById("grand-total").innerText = '₹' + new Intl.NumberFormat('en-IN').format(grandTotalAmt);
        document.getElementById("finalHiddenTotal").value = grandTotalAmt;
    });

    async function startPayment(e) {
        e.preventDefault();
        
        const btn = document.getElementById('place-order-btn');
        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Processing Order...';
        
        const addressStr = document.getElementById('address').value + ", " + 
                         document.getElementById('city').value + ", " + 
                         document.getElementById('state').value + " - " + 
                         document.getElementById('pincode').value;
                         
        const formData = new FormData();
        formData.append('place_order', 1);
        formData.append('cart', document.getElementById('cartDataJson').value);
        formData.append('total_amount', document.getElementById('finalHiddenTotal').value);
        formData.append('shipping_address', addressStr);
        
        try {
            const res = await fetch('process_order.php', {
                method: 'POST',
                body: formData
            });
            const data = await res.json();
            
            if(data.status === 'success') {
                localStorage.removeItem("cart"); 
                showToast("✨ Order Placed Successfully!", "success");
                setTimeout(() => {
                    window.location.href = 'ordertrack.php?success=1&order_id=' + data.order_id;
                }, 1500);
            } else {
                showToast(data.message || "Failed to place order", "error");
                btn.disabled = false;
                btn.innerHTML = 'Place Order <i class="fa-solid fa-arrow-right-long"></i>';
            }
        } catch (err) {
            console.error(err);
            showToast("Connection failed. Check network.", "error");
            btn.disabled = false;
            btn.innerHTML = 'Place Order <i class="fa-solid fa-arrow-right-long"></i>';
        }
    }
</script>

<?php include '../includes/footer.php'; ?>
