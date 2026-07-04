<?php 
require_once '../includes/Config.php';
include '../includes/header.php'; 

$category = isset($_GET['category']) ? mysqli_real_escape_string($conn, $_GET['category']) : '';
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'newest';

// Dynamic Sort Query
$order_by = "p.id DESC";
if ($sort == 'price_low') $order_by = "p.price ASC";
if ($sort == 'price_high') $order_by = "p.price DESC";
if ($sort == 'popular') $order_by = "p.rating DESC";

$query = "
    SELECT p.*, c.name as category_name 
    FROM products p 
    LEFT JOIN categories c ON p.category_id = c.id 
    WHERE 1=1
";

if ($category) {
    if (is_numeric($category)) {
        $query .= " AND p.category_id = $category";
    } else {
        $query .= " AND (c.name LIKE '%$category%' OR p.name LIKE '%$category%')";
    }
}

if ($search) {
    $search_safe = mysqli_real_escape_with_like($search, $conn);
    $query .= " AND (p.name LIKE '%$search_safe%' OR p.description LIKE '%$search_safe%')";
}

$query .= " ORDER BY $order_by";
$results = mysqli_query($conn, $query);

// Fetch all categories for filter
$all_cats_res = mysqli_query($conn, "SELECT * FROM categories ORDER BY name ASC");
?>

<div class="bg-gray-50 min-h-screen">
    <!-- Luxury Header Section -->
    <div class="bg-white border-b border-gray-100 py-16">
        <div class="max-w-[1400px] mx-auto px-8 flex flex-col items-center text-center">
            <nav class="flex items-center gap-3 text-[10px] uppercase tracking-[0.3em] text-gray-400 mb-6">
                <a href="<?php echo BASE_URL; ?>index.php" class="hover:text-white transition-colors">Home</a>
                <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                <span class="text-gray-900 font-bold">Collections</span>
            </nav>
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 font-serif mb-6">
                <?php 
                if ($search) echo 'Results for "' . htmlspecialchars($search) . '"';
                elseif ($category) {
                    if (is_numeric($category)) {
                        $cat_name_res = mysqli_query($conn, "SELECT name FROM categories WHERE id=$category");
                        $cat_name = mysqli_fetch_assoc($cat_name_res);
                        echo htmlspecialchars($cat_name['name']) . ' Collection';
                    } else {
                        echo htmlspecialchars($category) . ' Collection';
                    }
                }
                else echo 'All Collections';
                ?>
            </h1>
            <div class="h-1 w-24 bg-[#d4af37] rounded-full mb-6"></div>
            <p class="text-gray-500 font-medium text-lg"><?php echo mysqli_num_rows($results); ?> products found</p>
        </div>
    </div>

    <div class="max-w-[1400px] mx-auto px-8 py-16">
        <!-- Premium Filter Workspace -->
        <div class="flex flex-col lg:flex-row items-center justify-between gap-10 mb-20 bg-white p-8 rounded-[3rem] shadow-sm border border-gray-100">
            <div class="flex items-center gap-4 overflow-x-auto pb-2 scrollbar-hide w-full lg:w-auto px-2">
                <a href="collections.php" class="px-8 py-3 rounded-2xl border transition-all whitespace-nowrap font-bold text-xs uppercase tracking-widest <?php echo !$category ? 'bg-slate-900 text-white border-slate-900' : 'bg-white text-slate-400 border-slate-100 hover:border-[#d4af37] hover:text-[#d4af37]'; ?>">
                    All Categories
                </a>
                <?php while($cat = mysqli_fetch_assoc($all_cats_res)): 
                    $active = ($category == $cat['id'] || $category == $cat['name']) ? 'bg-slate-900 text-white border-slate-900' : 'bg-white text-slate-400 border-slate-100 hover:border-[#d4af37] hover:text-[#d4af37]';
                ?>
                    <a href="collections.php?category=<?php echo $cat['id']; ?>" class="px-8 py-3 rounded-2xl border transition-all whitespace-nowrap font-bold text-xs uppercase tracking-widest <?php echo $active; ?>">
                        <?php echo htmlspecialchars($cat['name']); ?>
                    </a>
                <?php endwhile; ?>
            </div>
            
            <div class="flex items-center gap-8 w-full lg:w-auto border-t lg:border-t-0 pt-6 lg:pt-0 border-gray-100">
                <div class="flex items-center gap-3">
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Sort By:</span>
                    <select onchange="window.location.href='collections.php?category=<?php echo $category; ?>&search=<?php echo $search; ?>&sort=' + this.value" 
                            class="bg-transparent border-none text-xs font-bold uppercase tracking-widest focus:ring-0 cursor-pointer text-gray-900 hover:text-white transition">
                        <option value="newest" <?php echo $sort == 'newest' ? 'selected' : ''; ?>>Newest First</option>
                        <option value="price_low" <?php echo $sort == 'price_low' ? 'selected' : ''; ?>>Price: Low to High</option>
                        <option value="price_high" <?php echo $sort == 'price_high' ? 'selected' : ''; ?>>Price: High to Low</option>
                        <option value="popular" <?php echo $sort == 'popular' ? 'selected' : ''; ?>>Most Popular</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Exquisite Product Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-12">
            <?php
            if(mysqli_num_rows($results) > 0){
                while($prod = mysqli_fetch_assoc($results)){
                    $priceFormat = number_format($prod['price'], 0);
                    $origFormat = number_format($prod['original_price'], 0);
                    $discount = $prod['original_price'] > 0 ? round((($prod['original_price'] - $prod['price']) / $prod['original_price']) * 100) : 0;
            ?>
                <div class="group bg-white rounded-[2.5rem] overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-700 border border-gray-50 flex flex-col h-full animate-in fade-in slide-in-from-bottom-4 duration-1000">
                    <div class="relative overflow-hidden bg-gray-50">
                        <a href="productdetail.php?id=<?php echo $prod['id']; ?>" class="block h-[250px] w-full">
                            <img src="<?php echo BASE_URL . $prod['image_url']; ?>" alt="<?php echo htmlspecialchars($prod['name']); ?>" 
                                 class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110"
                                 onerror="this.src='<?php echo BASE_URL; ?>images/download.png'">
                            <div class="absolute inset-0 bg-black/5 group-hover:bg-black/0 transition-colors duration-700"></div>
                        </a>
                        
                        <?php if($discount > 0): ?>
                            <div class="absolute top-6 left-6 flex flex-col gap-2">
                                <span class="bg-[#d4af37] text-black text-[9px] font-bold px-3 py-1.5 rounded-full uppercase tracking-widest shadow-xl">Exclusive Offer</span>
                                <span class="bg-black text-white text-[9px] font-bold px-3 py-1.5 rounded-full uppercase tracking-widest shadow-xl text-center">-<?php echo $discount; ?>%</span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="p-8 flex-1 flex flex-col">
                        <div class="flex-1">
                            <span class="text-[10px] font-bold text-[#d4af37] uppercase tracking-[0.2em] block mb-3"><?php echo htmlspecialchars($prod['category_name'] ?: 'Unique Creation'); ?></span>
                            <h3 class="text-xl font-bold text-slate-900 font-serif mb-4 leading-tight line-clamp-2 h-14"><?php echo htmlspecialchars($prod['name']); ?></h3>
                        </div>

                        <div class="flex items-baseline gap-4 mt-auto mb-6">
                            <span class="text-2xl font-bold text-slate-900 font-serif">₹<?php echo $priceFormat; ?></span>
                            <?php if($prod['original_price'] > $prod['price']): ?>
                                <span class="text-sm text-gray-400 line-through font-light italic">₹<?php echo $origFormat; ?></span>
                            <?php endif; ?>
                        </div>
                        
                        <button onclick="addToCart(<?php echo $prod['id']; ?>, '<?php echo addslashes($prod['name']); ?>', <?php echo $prod['price']; ?>, '<?php echo addslashes($prod['image_url']); ?>')" 
                                class="w-full bg-slate-900 text-white py-4 rounded-2xl font-bold hover:bg-[#d4af37] hover:text-black transition-all duration-300 shadow-xl active:scale-95 flex items-center justify-center gap-3">
                            <i class="fa-solid fa-cart-shopping"></i> Add to Cart
                        </button>
                    </div>
                </div>
            <?php
                }
            } else {
                ?>
                <div class="col-span-full py-40 flex flex-col items-center text-center">
                    <div class="w-24 h-24 bg-white rounded-[2rem] shadow-sm flex items-center justify-center text-gray-200 text-4xl mb-8">
                        <i class="fa-solid fa-gem"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-400 font-serif">No products found for this search.</h3>
                    <p class="text-gray-400 font-medium mt-2 mb-8">Try adjusting your filters or search terms.</p>
                    <a href="collections.php" class="px-10 py-4 bg-slate-900 text-white rounded-2xl font-bold uppercase text-xs tracking-widest hover:bg-[#d4af37] hover:text-black transition shadow-xl active:scale-95">Universal View</a>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
