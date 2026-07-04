<?php include 'includes/header.php'; ?>

<!-- Featured Collection Section -->
<section class="relative h-screen flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0 z-0 scale-105 animate-slow-zoom">
        <img src="https://images.unsplash.com/photo-1515562141207-7a88fb7ce338?q=80&w=2070&auto=format&fit=crop" class="w-full h-full object-cover" alt="Hero Background">
        <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-black/40 to-black/80 backdrop-blur-[1px]"></div>
    </div>
    
    <div class="relative z-10 text-center text-white px-8 max-w-5xl mt-16">
        <div class="flex items-center justify-center gap-4 mb-6 animate-in fade-in slide-in-from-bottom-4 duration-1000">
            <span class="h-[1px] w-12 bg-[#d4af37]/30"></span>
            <span class="text-[10px] uppercase tracking-[0.6em] font-bold text-[#d4af37]">SINCE 1998</span>
            <span class="h-[1px] w-12 bg-[#d4af37]/30"></span>
        </div>
        <h1 class="text-4xl md:text-6xl font-bold mb-6 tracking-tighter leading-[1.1] font-serif animate-in fade-in slide-in-from-bottom-8 duration-1000 delay-200">
            Elegance in Every <br> <span class="text-white italic font-light">Movement</span>
        </h1>
        <p class="text-lg md:text-xl mb-12 text-gray-300 font-medium max-w-2xl mx-auto leading-relaxed animate-in fade-in slide-in-from-bottom-12 duration-1000 delay-500">
            Discover a collection of curated jewellery pieces. Our collections of diamond, gold, and silver are crafted for those who value excellence.
        </p>
        <div class="flex flex-col sm:flex-row gap-6 justify-center animate-in fade-in slide-in-from-bottom-16 duration-1000 delay-700">
            <a href="user/collections.php" class="group bg-[#d4af37] hover:bg-white text-black px-12 py-5 rounded-2xl font-bold transition-all duration-500 shadow-[0_20px_50px_rgba(212,175,55,0.3)] flex items-center justify-center gap-3 active:scale-95">
                Shop Collection <i class="fa-solid fa-gem group-hover:rotate-12 transition"></i>
            </a>
            <a href="user/collections.php?category=New" class="bg-white/5 hover:bg-white/10 backdrop-blur-2xl text-white border border-white/10 px-12 py-5 rounded-2xl font-bold transition-all duration-500 flex items-center justify-center gap-3">
                New arrivals <i class="fa-solid fa-arrow-right-long opacity-50"></i>
            </a>
        </div>
    </div>

    <!-- Scroll Indicator -->
    <div class="absolute bottom-12 left-1/2 -translate-x-1/2 flex flex-col items-center gap-4 text-white/30">
        <span class="text-[10px] uppercase tracking-[0.4em] font-bold">Scroll Down</span>
        <div class="w-[1px] h-12 bg-gradient-to-b from-[#d4af37] to-transparent animate-pulse"></div>
    </div>
</section>

<!-- The Essence Selection -->
<section class="py-20 bg-white relative overflow-hidden">
    <div class="absolute -right-20 top-40 w-96 h-96 bg-[#d4af37]/5 rounded-full blur-[100px]"></div>
    <div class="max-w-[1400px] mx-auto px-8">
        <div class="flex flex-col items-center text-center mb-16">
            <span class="text-[#d4af37] font-bold tracking-[0.4em] text-[10px] uppercase mb-4 block">CATEGORIES</span>
            <h2 class="text-3xl md:text-4xl font-bold text-slate-900 font-serif">Our Collections</h2>
            <div class="h-1 w-20 bg-slate-900 mt-8"></div>
        </div>
        
        <div class="flex flex-wrap justify-center gap-6 sm:gap-10">
            <?php
            // Fetch real categories from DB
            $cat_query = "SELECT * FROM categories ORDER BY name ASC LIMIT 6";
            $cat_res = mysqli_query($conn, $cat_query);
            
            if(mysqli_num_rows($cat_res) > 0):
                while($cat = mysqli_fetch_assoc($cat_res)):
                    $cat_img = !empty($cat['image_url']) ? BASE_URL . $cat['image_url'] : 'https://images.unsplash.com/photo-1515562141207-7a88fb7ce338?q=80&w=400&auto=format&fit=crop';
            ?>
            <a href="user/collections.php?category=<?php echo urlencode($cat['name']); ?>" class="group flex flex-col items-center bg-white p-6 rounded-3xl shadow-sm hover:shadow-2xl border border-gray-100 transition-all duration-500 hover:-translate-y-2 w-[180px]">
                <div class="w-[100px] h-[100px] rounded-full overflow-hidden bg-slate-50 mb-5 border-[3px] border-transparent group-hover:border-[#d4af37]/20 transition-colors">
                    <img src="<?php echo $cat_img; ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" alt="<?php echo htmlspecialchars($cat['name']); ?>">
                </div>
                <h4 class="font-bold text-sm text-slate-800 font-serif tracking-wide text-center group-hover:text-[#d4af37] transition duration-300"><?php echo htmlspecialchars($cat['name']); ?></h4>
            </a>
            <?php 
                endwhile;
            else:
                echo '<p class="w-full text-center text-slate-400 font-serif italic">No categories found.</p>';
            endif; 
            ?>
        </div>
    </div>
</section>

<!-- Latest Revelations -->
<section class="py-20 bg-slate-50 relative">
    <div class="max-w-[1400px] mx-auto px-8">
        <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6">
            <div class="text-left">
                <span class="text-[#d4af37] font-bold tracking-[0.4em] text-[10px] uppercase mb-4 block">NEW PRODUCTS</span>
                <h2 class="text-3xl md:text-4xl font-bold text-slate-900 font-serif">New Arrivals</h2>
            </div>
            <a href="user/collections.php" class="group flex items-center gap-4 text-slate-900 font-bold uppercase text-[10px] tracking-[0.3em] hover:text-white transition-all">
                Full Collection <i class="fa-solid fa-arrow-right-long group-hover:translate-x-2 transition duration-500"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <?php
            require_once 'includes/Config.php';
            $products_query = "
                SELECT p.*, c.name as category_name 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                ORDER BY p.id DESC LIMIT 8
            ";
            $products_res = mysqli_query($conn, $products_query);
            if(mysqli_num_rows($products_res) > 0){
                while($prod = mysqli_fetch_assoc($products_res)){
                    $priceFormat = number_format($prod['price'], 0);
                    $origFormat = number_format($prod['original_price'], 0);
                    $discount = $prod['original_price'] > 0 ? round((($prod['original_price'] - $prod['price']) / $prod['original_price']) * 100) : 0;
            ?>
                <div class="group bg-white rounded-[2rem] overflow-hidden shadow-sm hover:shadow-xl transition-all duration-500 border border-slate-100 flex flex-col h-full active:scale-[0.98]">
                    <div class="relative overflow-hidden bg-slate-50">
                        <a href="user/productdetail.php?id=<?php echo $prod['id']; ?>" class="block h-[250px] w-full">
                            <img src="<?php echo BASE_URL . $prod['image_url']; ?>" alt="<?php echo htmlspecialchars($prod['name']); ?>" 
                                 class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110"
                                 onerror="this.src='<?php echo BASE_URL; ?>images/download.png'">
                            <div class="absolute inset-0 bg-black/5 group-hover:bg-black/0 transition-colors duration-700"></div>
                        </a>
                        
                        <?php if($discount > 0): ?>
                            <div class="absolute top-6 left-6 flex flex-col gap-2">
                                <span class="bg-[#d4af37] text-black text-[9px] font-bold px-3 py-1.5 rounded-full uppercase tracking-widest shadow-xl">Exclusive</span>
                                <span class="bg-black text-white text-[9px] font-bold px-3 py-1.5 rounded-full uppercase tracking-widest shadow-xl text-center">-<?php echo $discount; ?>%</span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="p-8 flex-1 flex flex-col">
                        <div class="flex-1">
                            <span class="text-[10px] font-bold text-[#d4af37] uppercase tracking-[0.2em] block mb-3"><?php echo htmlspecialchars($prod['category_name'] ?: 'Featured'); ?></span>
                            <h3 class="text-xl font-bold text-slate-900 font-serif mb-4 leading-tight line-clamp-2"><?php echo htmlspecialchars($prod['name']); ?></h3>
                        
                        </div>

                        <div class="flex items-baseline gap-3 mt-auto mb-6">
                            <span class="text-xl font-bold text-slate-900 font-serif">₹<?php echo $priceFormat; ?></span>
                            <?php if($prod['original_price'] > $prod['price']): ?>
                                <span class="text-xs text-gray-400 line-through font-light italic">₹<?php echo $origFormat; ?></span>
                            <?php endif; ?>
                        </div>
                        
                        <button onclick="addToCart(<?php echo $prod['id']; ?>, '<?php echo addslashes($prod['name']); ?>', <?php echo $prod['price']; ?>, '<?php echo addslashes($prod['image_url']); ?>')" 
                                class="w-full bg-slate-900 text-white py-4 rounded-2xl font-bold hover:bg-[#d4af37] hover:text-black transition-all duration-300 shadow-xl flex items-center justify-center gap-3 active:scale-95">
                            <i class="fa-solid fa-cart-shopping"></i> Add to Cart
                        </button>
                    </div>
                </div>
            <?php
                }
            } else {
                echo '<p class="col-span-full py-40 text-center text-gray-400 font-serif italic text-2xl">No products are available at the moment. Please check back later.</p>';
            }
            ?>
        </div>
    </div>
</section>

<!-- The Grand Invitation -->
<section class="py-20 bg-white flex justify-center">
    <div class="max-w-[1400px] w-full px-8">
        <div class="bg-slate-900 rounded-[3rem] overflow-hidden relative min-h-[400px] flex items-center p-8 md:p-16 shadow-2xl">
            <div class="absolute right-0 top-0 w-1/2 h-full hidden lg:block">
                <img src="https://images.unsplash.com/photo-1601121141461-9d6647bca1ed?q=80&w=2070&auto=format&fit=crop" class="w-full h-full object-cover scale-110 hover:scale-100 transition duration-[2s]">
                <div class="absolute inset-0 bg-gradient-to-r from-slate-900 via-slate-900/40 to-transparent"></div>
            </div>
            <div class="relative z-10 max-w-xl text-white">
                <span class="text-[#d4af37] font-bold tracking-[0.6em] text-[10px] uppercase mb-6 block">JOIN OUR COMMUNITY</span>
                <h2 class="text-3xl md:text-4xl font-bold mb-8 leading-[1.2] font-serif">Member <br> <span class="text-[#d4af37] italic font-light">Benefits</span></h2>
                <p class="text-gray-400 mb-10 text-md font-light leading-relaxed">Join our exclusive membership. Get 15% off on your first purchase and stay updated with new collections.</p>
                <div class="flex flex-wrap gap-4">
                    <a href="auth/register.php" class="inline-block bg-[#d4af37] text-black px-12 py-5 rounded-2xl font-bold hover:shadow-[0_20px_50px_rgba(212,175,55,0.4)] transition-all duration-500 active:scale-95">Register Now</a>
                    <a href="user/offers.php" class="inline-block bg-white/5 border border-white/10 text-white px-12 py-5 rounded-2xl font-bold hover:bg-white/10 transition-all duration-500">View Offers</a>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    @keyframes slow-zoom {
        from { transform: scale(1); }
        to { transform: scale(1.15); }
    }
    .animate-slow-zoom {
        animation: slow-zoom 30s linear infinite alternate;
    }
    .perspective-1000 {
        perspective: 1000px;
    }
</style>

<?php include 'includes/footer.php'; ?>
