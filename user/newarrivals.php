<?php 
require_once '../includes/Config.php';
include '../includes/header.php'; 
?>

<div class="bg-slate-50 py-10 lg:py-16 min-h-screen">
    <div class="max-w-[1400px] mx-auto px-8">
        <!-- Breadcrumbs -->
        <nav class="flex items-center gap-3 text-[10px] uppercase tracking-[0.3em] text-gray-400 mb-12">
            <a href="<?php echo BASE_URL; ?>index.php" class="hover:text-white transition">Home</a>
            <span class="w-1 h-1 rounded-full bg-gray-300"></span>
            <span class="text-gray-900 font-bold">New Arrivals</span>
        </nav>
        <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-8">
            <div class="max-w-2xl">
                <span class="text-[#d4af37] font-bold uppercase tracking-[0.4em] text-[10px] mb-4 block">The Latest Creations</span>
                <h1 class="text-4xl md:text-5xl font-serif font-bold text-slate-900 leading-tight">Fresh from our <span class="italic text-[#d4af37] font-light">Jewellery</span> Workshop</h1>
            </div>
            <p class="text-slate-400 font-light max-w-sm mb-2 text-sm leading-relaxed border-l-2 border-[#d4af37]/20 pl-6 italic">
                Discover our newest products, where timeless tradition meets contemporary elegance. Each piece is freshly unveiled.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
            <?php
            $new_res = mysqli_query($conn, "SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id ORDER BY p.id DESC LIMIT 9");
            if(mysqli_num_rows($new_res) > 0):
                while($prod = mysqli_fetch_assoc($new_res)):
                    $discount = $prod['original_price'] > 0 ? round((($prod['original_price'] - $prod['price']) / $prod['original_price']) * 100) : 0;
            ?>
            <div class="group relative bg-white rounded-[3rem] overflow-hidden hover:shadow-2xl transition-all duration-700 border border-slate-100 hover:border-white">
                <div class="absolute top-6 left-6 z-20 flex flex-col gap-2">
                    <span class="bg-slate-900 text-white text-[9px] font-bold px-4 py-1.5 rounded-full uppercase tracking-[0.3em] shadow-xl">New Arrival</span>
                    <?php if($discount > 0): ?>
                        <span class="bg-[#d4af37] text-black text-[9px] font-bold px-4 py-1.5 rounded-full uppercase tracking-[0.3em] shadow-xl">-<?php echo $discount; ?>% OFF</span>
                    <?php endif; ?>
                </div>

                <div class="aspect-[4/5] overflow-hidden relative">
                    <img src="<?php echo BASE_URL . $prod['image_url']; ?>" 
                         class="w-full h-full object-cover group-hover:scale-110 transition duration-[2s]" 
                         onerror="this.src='<?php echo BASE_URL; ?>images/download.png'">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
                    
                    <div class="absolute bottom-0 left-0 right-0 p-8 translate-y-full group-hover:translate-y-0 transition-transform duration-500 flex gap-4 justify-center">
                        <a href="productdetail.php?id=<?php echo $prod['id']; ?>" 
                           class="flex-1 bg-white/90 backdrop-blur text-slate-900 py-4 rounded-2xl font-bold text-center text-[10px] uppercase tracking-[0.2em] hover:bg-[#d4af37] hover:text-black transition-all shadow-2xl">
                            <i class="fa-solid fa-eye mr-2"></i>View Details
                        </a>
                        <button onclick="addToCart(<?php echo $prod['id']; ?>, '<?php echo addslashes($prod['name']); ?>', <?php echo $prod['price']; ?>, '<?php echo addslashes($prod['image_url']); ?>')"
                                class="flex-1 bg-slate-900/90 backdrop-blur text-white py-4 rounded-2xl font-bold text-center text-[10px] uppercase tracking-[0.2em] hover:bg-[#d4af37] hover:text-black transition-all shadow-2xl">
                            <i class="fa-solid fa-cart-shopping mr-2"></i>Add to Cart
                        </button>
                    </div>
                </div>

                <div class="p-8">
                    <span class="text-[9px] font-bold text-[#d4af37] uppercase tracking-[0.4em] block mb-3">New Product</span>
                    <h3 class="text-xl font-bold text-slate-900 font-serif group-hover:text-[#d4af37] transition duration-300 mb-1"><?php echo htmlspecialchars($prod['name']); ?></h3>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mb-5"><?php echo htmlspecialchars($prod['category_name'] ?: 'Jewellery'); ?> Collection</p>
                    
                    <div class="flex items-baseline gap-3 pt-5 border-t border-slate-50">
                        <span class="text-2xl font-bold text-slate-900 font-serif">₹<?php echo number_format($prod['price'], 0); ?></span>
                        <?php if($prod['original_price'] > $prod['price']): ?>
                            <span class="text-sm text-slate-300 line-through">₹<?php echo number_format($prod['original_price'], 0); ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php 
                endwhile;
            else:
            ?>
            <div class="col-span-full py-20 text-center bg-gray-50 rounded-[3rem]">
                <i class="fa-solid fa-gem text-5xl text-gray-200 mb-6"></i>
                <h3 class="text-2xl font-bold text-gray-400">Our collections are currently being updated.</h3>
                <p class="text-gray-400 mt-4">Check back soon for our latest creations.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>