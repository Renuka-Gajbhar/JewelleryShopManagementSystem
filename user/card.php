<?php 
require_once '../includes/Config.php';
include '../includes/header.php'; 
?>

<div class="bg-slate-50 min-h-screen py-10 lg:py-16">
    <div class="max-w-[1400px] mx-auto px-8">
        <!-- Breadcrumbs -->
        <nav class="flex items-center gap-3 text-[10px] uppercase tracking-[0.3em] text-gray-400 mb-10">
            <a href="<?php echo BASE_URL; ?>index.php" class="hover:text-slate-700 transition text-slate-400">Home</a>
            <span class="w-1 h-1 rounded-full bg-gray-300"></span>
            <span class="text-gray-900 font-bold uppercase">My Cart</span>
        </nav>

        <div class="flex flex-col lg:flex-row justify-between items-end mb-12 gap-6">
            <div class="text-left">
                <span class="text-[#d4af37] font-bold tracking-[0.4em] text-[10px] uppercase mb-3 block">Items in Cart</span>
                <h1 class="text-4xl md:text-5xl font-bold text-slate-900 font-serif">Shopping Cart <span class="text-slate-300 font-light ml-3 font-sans text-2xl">(<span id="title-count">0</span>)</span></h1>
            </div>
            <button onclick="window.location.href='collections.php'" class="group text-[10px] font-bold uppercase tracking-[0.3em] text-slate-900 flex items-center gap-3 hover:text-white transition duration-500">
                Continue Shopping <i class="fa-solid fa-arrow-right-long group-hover:translate-x-2 transition duration-500"></i>
            </button>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-16">
            <!-- Cart Items -->
            <div class="lg:col-span-8">
                <div id="cart-container" class="space-y-8">
                    <!-- JS will render items here -->
                </div>
                
                <div id="empty-vault-action" class="mt-8 hidden">
                    <div class="bg-white p-10 rounded-3xl text-center border border-slate-100 shadow-sm">
                        <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mx-auto mb-6 text-slate-200 text-3xl">
                            <i class="fa-solid fa-cart-shopping opacity-20"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-900 font-serif mb-4">Your Cart is Empty</h3>
                        <p class="text-slate-400 max-w-xs mx-auto mb-8 leading-relaxed text-sm">Looks like you haven't added anything yet. Explore our collections!</p>
                        <a href="collections.php" class="inline-block bg-slate-900 text-white px-8 py-4 rounded-xl font-bold uppercase text-[10px] tracking-[0.3em] hover:bg-[#d4af37] hover:text-black transition-all duration-300 shadow-xl">Browse Collections</a>
                    </div>
                </div>
            </div>
            
            <!-- Summary -->
            <div class="lg:col-span-4">
                <div class="bg-white p-8 rounded-3xl shadow-xl shadow-slate-200/50 sticky top-24 border border-slate-50">
                    <div class="flex items-center gap-4 mb-10">
                        <span class="text-[10px] font-bold text-slate-900 uppercase tracking-[0.4em]">Order Summary</span>
                        <div class="h-[1px] flex-1 bg-slate-50"></div>
                    </div>
                    
                    <div class="space-y-8 mb-12">
                        <div class="flex justify-between items-center text-slate-400">
                            <span class="text-[10px] font-bold uppercase tracking-wider">Subtotal</span>
                            <span id="subtotal" class="font-bold text-slate-900 text-lg font-serif">₹0</span>
                        </div>
                        <div class="flex justify-between items-center text-slate-400">
                            <span class="text-[10px] font-bold uppercase tracking-wider">Shipping</span>
                            <span class="text-[#d4af37] font-bold uppercase tracking-[0.2em] text-[10px] bg-[#d4af37]/5 px-4 py-1.5 border border-[#d4af37]/20 rounded-full">Free</span>
                        </div>
                        <div class="flex justify-between items-center text-slate-400">
                            <span class="text-[10px] font-bold uppercase tracking-wider">GST (3%)</span>
                            <span id="tax-estimate" class="font-bold text-slate-900 text-lg font-serif">₹0</span>
                        </div>
                    </div>
                    
                    <div class="pt-10 border-t border-slate-50 mb-12">
                        <div class="flex justify-between items-end">
                            <div>
                                <span class="text-slate-300 text-[9px] uppercase tracking-[0.4em] font-bold block mb-2">Grand Total</span>
                                <span id="order-total" class="text-4xl font-bold text-slate-900 font-serif">₹0</span>
                            </div>
                            <div class="text-white text-xl mb-1">
                                <i class="fa-solid fa-signature"></i>
                            </div>
                        </div>
                    </div>
                    
                    <button onclick="proceedToCheckout()" class="w-full bg-slate-900 hover:bg-[#d4af37] hover:border-[#d4af37] border md:border-transparent text-white hover:text-black py-4 rounded-xl font-bold transition-all duration-300 shadow-xl flex items-center justify-center gap-3 active:scale-95 uppercase tracking-[0.2em] text-xs">
                        Proceed to Checkout <i class="fa-solid fa-arrow-right-long"></i>
                    </button>
                    
                    <div class="mt-10 flex items-center justify-center gap-4">
                        <div class="flex -space-x-3 overflow-hidden">
                            <i class="fa-brands fa-cc-visa text-slate-200 text-xl"></i>
                            <i class="fa-brands fa-cc-mastercard text-slate-200 text-xl"></i>
                            <i class="fa-brands fa-cc-apple-pay text-slate-200 text-xl"></i>
                        </div>
                        <span class="h-4 w-[1px] bg-slate-100"></span>
                        <p class="text-[9px] text-slate-300 font-bold uppercase tracking-widest">Secure Payment</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function renderCart() {
        const cart = JSON.parse(localStorage.getItem("cart")) || [];
        const container = document.getElementById("cart-container");
        const titleCount = document.getElementById("title-count");
        const subtotalEl = document.getElementById("subtotal");
        const taxEl = document.getElementById("tax-estimate");
        const orderTotalEl = document.getElementById("order-total");
        const emptyVaultBox = document.getElementById("empty-vault-action");
        
        container.innerHTML = "";
        let subtotal = 0;
        let totalItems = 0;

        if (cart.length === 0) {
            emptyVaultBox.classList.remove("hidden");
            titleCount.innerText = "0";
            subtotalEl.innerText = "₹0";
            taxEl.innerText = "₹0";
            orderTotalEl.innerText = "₹0";
            updateCartCount();
            return;
        }

        emptyVaultBox.classList.add("hidden");

        cart.forEach((item, index) => {
            const hasQty = item.qty || 1;
            const itemTotal = item.price * hasQty;
            subtotal += itemTotal;
            totalItems += hasQty;

            container.innerHTML += `
                <div class="bg-white p-6 lg:p-8 rounded-3xl shadow-sm hover:shadow-xl transition-all duration-500 border border-slate-50 flex flex-col md:flex-row items-center gap-8 group relative overflow-hidden">
                    <div class="absolute inset-0 bg-slate-50/50 -translate-x-full group-hover:translate-x-0 transition-transform duration-700 pointer-events-none"></div>
                    
                    <div class="w-40 h-48 rounded-[1.5rem] overflow-hidden bg-slate-50 flex-shrink-0 relative z-10 border border-gray-100">
                        <img src="${BASE_URL}${item.image}" alt="${item.name}" class="w-full h-full object-cover group-hover:scale-110 transition duration-1000" onerror="this.src='${BASE_URL}images/download.png'">
                    </div>
                    
                    <div class="flex-grow relative z-10 w-full">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <span class="text-[9px] font-bold text-[#d4af37] uppercase tracking-[0.4em] block mb-2">Jewellery Item</span>
                                <h3 class="text-2xl font-bold text-slate-900 font-serif mb-1 leading-tight">${item.name}</h3>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Master Category: Fine Jewellery</p>
                            </div>
                            <button onclick="removeItem(${index})" class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-300 hover:text-red-500 hover:bg-red-50 transition-all duration-300 hover:rotate-6">
                                <i class="fa-solid fa-trash-can text-sm"></i>
                            </button>
                        </div>
                        
                        <div class="flex flex-wrap items-center justify-between gap-6 mt-6 border-t border-slate-50 pt-6">
                            <div class="flex items-baseline gap-3">
                                <p class="text-2xl font-bold text-slate-900 font-serif">₹${new Intl.NumberFormat('en-IN').format(item.price)}</p>
                                <span class="text-slate-300 text-[9px] font-bold uppercase tracking-widest">/ Item</span>
                            </div>
                            
                            <div class="flex items-center bg-slate-50 rounded-xl p-1 border border-slate-100 shadow-inner">
                                <button onclick="updateQty(${index}, -1)" class="w-10 h-10 rounded-lg flex items-center justify-center text-slate-400 hover:bg-white hover:text-slate-900 hover:shadow-sm transition-all duration-200 active:scale-95">-</button>
                                <span class="w-10 text-center font-bold text-slate-900 text-lg font-serif">${hasQty}</span>
                                <button onclick="updateQty(${index}, 1)" class="w-10 h-10 rounded-lg flex items-center justify-center text-slate-400 hover:bg-white hover:text-slate-900 hover:shadow-sm transition-all duration-200 active:scale-95">+</button>
                            </div>
                        </div>
                    </div>
                    <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-[#d4af37]/20 group-hover:bg-[#d4af37] transition-colors duration-500"></div>
                </div>
            `;
        });

        const tax = subtotal * 0.03; // 3% GST for jewellery
        const grandTotal = subtotal + tax;

        titleCount.innerText = totalItems;
        subtotalEl.innerText = "₹" + new Intl.NumberFormat('en-IN').format(subtotal);
        taxEl.innerText = "₹" + new Intl.NumberFormat('en-IN').format(tax);
        orderTotalEl.innerText = "₹" + new Intl.NumberFormat('en-IN').format(grandTotal);
        updateCartCount();
    }

    function updateQty(index, change) {
        let cart = JSON.parse(localStorage.getItem("cart")) || [];
        if (!cart[index].qty) cart[index].qty = 1;
        if(cart[index].qty + change > 0) {
            cart[index].qty += change;
            localStorage.setItem("cart", JSON.stringify(cart));
            renderCart();
        }
    }

    function removeItem(index) {
        let cart = JSON.parse(localStorage.getItem("cart")) || [];
        const itemName = cart[index].name;
        cart.splice(index, 1);
        localStorage.setItem("cart", JSON.stringify(cart));
        renderCart();
        showToast(`Product removed from cart`, "error");
    }

    function proceedToCheckout() {
        const cart = JSON.parse(localStorage.getItem("cart")) || [];
        if(cart.length === 0) {
            showToast("Your cart is empty!", "error");
            return;
        }
        <?php if(!isset($_SESSION['user_id'])): ?>
            showToast("Please login to checkout", "warning");
            setTimeout(() => { window.location.href = '<?php echo BASE_URL; ?>auth/login.php'; }, 2000);
            return;
        <?php endif; ?>
        
        window.location.href = 'checkout.php';
    }

    document.addEventListener("DOMContentLoaded", renderCart);
</script>

<?php include '../includes/footer.php'; ?>
