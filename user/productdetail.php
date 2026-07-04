<?php
require_once '../includes/Config.php';

// Handle Review Submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_review'])) {
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../auth/login.php");
        exit();
    }
    
    $user_id = $_SESSION['user_id'];
    $product_id = (int)$_POST['product_id'];
    $rating = (int)$_POST['rating'];
    $comment = mysqli_real_escape_string($conn, $_POST['comment']);
    
    $insert_review = "INSERT INTO reviews (product_id, user_id, rating, comment) VALUES ($product_id, $user_id, $rating, '$comment')";
    if (mysqli_query($conn, $insert_review)) {
        // Update average product rating if needed, or just let it stay static for now
        header("Location: productdetail.php?id=$product_id&reviewed=1");
        exit();
    }
}
include '../includes/header.php'; 

$prod = null;
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $query = "SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.id = $id";
    $result = mysqli_query($conn, $query);
    $prod = mysqli_fetch_assoc($result);
} elseif (isset($_GET['name'])) {
    $name = mysqli_real_escape_string($conn, $_GET['name']);
    $query = "SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.name = '$name' LIMIT 1";
    $result = mysqli_query($conn, $query);
    $prod = mysqli_fetch_assoc($result);
}

if (!$prod) {
    echo "<div class='min-h-[80vh] flex flex-col items-center justify-center p-20 bg-gray-50'>";
    echo "  <div class='w-24 h-24 bg-white rounded-[2rem] shadow-sm flex items-center justify-center text-gray-200 text-4xl mb-8'><i class='fa-solid fa-gem'></i></div>";
    echo "  <h2 class='text-3xl font-bold text-gray-900 font-serif mb-4'>Product Not Found</h2>";
    echo "  <p class='text-gray-400 mb-10'>The product you are looking for is not available.</p>";
    echo "  <a href='collections.php' class='px-10 py-4 bg-slate-900 text-white rounded-2xl font-bold uppercase text-xs tracking-widest hover:bg-primary hover:text-black transition shadow-xl'>Return to Shop</a>";
    echo "</div>";
    include '../includes/footer.php';
    exit();
}

$priceFormat = number_format($prod['price'], 0);
$origFormat = number_format($prod['original_price'], 0);
$discount = $prod['original_price'] > 0 ? round((($prod['original_price'] - $prod['price']) / $prod['original_price']) * 100) : 0;
?>

<div class="bg-slate-50 min-h-screen py-10 lg:py-16">
    <div class="max-w-[1400px] mx-auto px-8">
        <!-- Breadcrumbs -->
        <nav class="flex items-center gap-3 text-[10px] uppercase tracking-[0.3em] text-gray-400 mb-12">
            <a href="<?php echo BASE_URL; ?>index.php" class="hover:text-white transition">Home</a>
            <span class="w-1 h-1 rounded-full bg-gray-300"></span>
            <a href="collections.php" class="hover:text-white transition">Collections</a>
            <span class="w-1 h-1 rounded-full bg-gray-300"></span>
            <span class="text-gray-900 font-bold"><?php echo htmlspecialchars($prod['name']); ?></span>
        </nav>

        <div class="bg-white rounded-[4rem] overflow-hidden shadow-2xl flex flex-col lg:flex-row gap-0 border border-white">
            <!-- Image Showcase -->
            <div class="lg:w-1/2 p-8 lg:p-12 bg-slate-50/50">
                <div class="aspect-square rounded-[3rem] overflow-hidden bg-white shadow-inner group relative">
                    <img src="<?php echo BASE_URL . $prod['image_url']; ?>" 
                         alt="<?php echo htmlspecialchars($prod['name']); ?>" 
                         class="w-full h-full object-cover transition-transform duration-[1.5s] group-hover:scale-110"
                         onerror="this.src='<?php echo BASE_URL; ?>images/download.png'">
                    
                    <?php if($discount > 0): ?>
                        <div class="absolute top-8 left-8 flex flex-col gap-2">
                            <span class="bg-primary text-black text-[10px] font-bold px-4 py-2 rounded-full uppercase tracking-widest shadow-2xl">Special Offer</span>
                            <span class="bg-black text-white text-[10px] font-bold px-4 py-2 rounded-full uppercase tracking-widest shadow-2xl text-center">-<?php echo $discount; ?>% OFF</span>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="grid grid-cols-4 gap-6 mt-8">
                    <div class="aspect-square rounded-2xl bg-white border-2 border-primary overflow-hidden cursor-pointer shadow-sm">
                        <img src="<?php echo BASE_URL . $prod['image_url']; ?>" class="w-full h-full object-cover p-2" onerror="this.src='<?php echo BASE_URL; ?>images/download.png'">
                    </div>
                    <!-- Additional placeholder perspectives -->
                    <div class="aspect-square rounded-2xl bg-white/50 border border-gray-100 overflow-hidden cursor-not-allowed opacity-40"></div>
                    <div class="aspect-square rounded-2xl bg-white/50 border border-gray-100 overflow-hidden cursor-not-allowed opacity-40"></div>
                </div>
            </div>

            <!-- Content Area -->
            <div class="lg:w-1/2 p-10 lg:p-24 flex flex-col justify-center">
                <div class="mb-12">
                    <div class="flex items-center gap-4 mb-8">
                        <span class="text-[10px] font-bold text-[#d4af37] uppercase tracking-[0.4em] px-4 py-2 bg-[#d4af37]/5 rounded-full border border-[#d4af37]/10">
                            <?php echo htmlspecialchars($prod['category_name'] ?: 'Product'); ?>
                        </span>
                        <div class="h-[1px] flex-1 bg-gray-100"></div>
                    </div>
                    
                    <h1 class="text-3xl lg:text-5xl font-bold text-slate-900 font-serif mb-8 leading-[1.1] animate-in fade-in slide-in-from-left-4 duration-700">
                        <?php echo htmlspecialchars($prod['name']); ?>
                    </h1>
                    
                    <div class="flex items-center gap-6 mb-12">
                        <div class="flex text-[#d4af37] text-xs gap-1.5">
                            <?php for($i=0; $i<5; $i++) echo $i<$prod['rating'] ? '<i class="fa-solid fa-star"></i>' : '<i class="fa-regular fa-star"></i>'; ?>
                        </div>
                        <span class="text-[10px] text-gray-400 font-bold uppercase tracking-[0.2em] decoration-[#d4af37] decoration-2"><?php echo $prod['rating']; ?>.0 Product Rating</span>
                    </div>

                    <div class="flex items-baseline gap-6 mb-12">
                        <span class="text-5xl font-bold text-slate-900 font-serif">₹<?php echo $priceFormat; ?></span>
                        <?php if($prod['original_price'] > $prod['price']): ?>
                            <span class="text-2xl text-gray-300 line-through font-light italic">₹<?php echo $origFormat; ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="prose prose-slate text-slate-500 mb-12 border-t border-b border-gray-50 py-12 leading-relaxed">
                        <p class="text-lg italic font-light">
                            <?php echo nl2br(htmlspecialchars($prod['description'] ?: "This exquisite piece embodies the pinnacle of craftsmanship. Designed for those who appreciate understated elegance, it features high-grade materials polished to a mirror finish. Ideal for gala evenings and cherished milestones alike.")); ?>
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
                        <div class="flex items-center gap-4 p-4 rounded-2xl bg-slate-50 border border-slate-100">
                            <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-white shadow-sm">
                                <i class="fa-solid fa-truck-fast text-xs"></i>
                            </div>
                            <span class="text-[10px] font-bold uppercase tracking-widest text-slate-600">Fast Delivery</span>
                        </div>
                        <div class="flex items-center gap-4 p-4 rounded-2xl bg-slate-50 border border-slate-100">
                            <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-white shadow-sm">
                                <i class="fa-solid fa-shield-halved text-xs"></i>
                            </div>
                            <span class="text-[10px] font-bold uppercase tracking-widest text-slate-600">Quality Guarantee</span>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-6">
                    <button onclick="addToCart(<?php echo $prod['id']; ?>, '<?php echo addslashes($prod['name']); ?>', <?php echo $prod['price']; ?>, '<?php echo addslashes($prod['image_url']); ?>')" 
                            class="flex-[2] bg-slate-900 text-white hover:bg-[#d4af37] hover:text-black py-6 rounded-2xl font-bold transition-all duration-500 shadow-2xl flex items-center justify-center gap-4 active:scale-95 group border border-transparent hover:border-[#d4af37]">
                        <i class="fa-solid fa-cart-shopping group-hover:rotate-12 transition"></i> Add to Cart
                    </button>
                    <button onclick="window.location.href='card.php'" class="flex-1 bg-white border-2 border-slate-900 text-slate-900 hover:bg-slate-900 hover:text-white py-6 rounded-2xl font-bold transition-all duration-500 flex items-center justify-center gap-4">
                        <i class="fa-solid fa-bolt"></i> Order Now
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Reviews Section -->
    <div class="max-w-[1400px] mx-auto px-8 mt-24">
        <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-8">
            <div class="text-left">
                <span class="text-[#d4af37] font-bold tracking-[0.4em] text-[10px] uppercase mb-6 block">COMMUNITY FEEDBACK</span>
                <h2 class="text-4xl font-bold text-slate-900 font-serif">Reviews & Ratings</h2>
            </div>
            <div class="flex items-center gap-6 p-6 bg-white rounded-3xl shadow-sm border border-slate-50">
                <div class="flex text-[#d4af37] text-xl gap-1">
                    <?php for($i=0; $i<5; $i++) echo $i<$prod['rating'] ? '<i class="fa-solid fa-star"></i>' : '<i class="fa-regular fa-star"></i>'; ?>
                </div>
                <div class="h-8 w-[1px] bg-slate-100"></div>
                <span class="text-2xl font-bold text-slate-900 font-serif"><?php echo $prod['rating']; ?>.0</span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-16">
            <!-- Review Form -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-[3rem] p-10 shadow-xl border border-white sticky top-32">
                    <h3 class="text-2xl font-bold text-slate-900 mb-2">Write a Review</h3>
                    <p class="text-slate-400 text-sm mb-10">Share your experience with this piece</p>

                    <?php if (isset($_SESSION['user_id'])): ?>
                    <form action="" method="POST" class="space-y-8">
                        <input type="hidden" name="product_id" value="<?php echo $prod['id']; ?>">
                        
                        <div class="group">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-4 block">Select Rating</label>
                            <div class="flex gap-4 star-rating">
                                <?php for($i=1; $i<=5; $i++): ?>
                                <label class="cursor-pointer transition-transform hover:scale-125">
                                    <input type="radio" name="rating" value="<?php echo $i; ?>" required class="hidden peer">
                                    <i class="fa-solid fa-star text-2xl text-slate-200 peer-checked:text-[#d4af37] transition-colors"></i>
                                </label>
                                <?php endfor; ?>
                            </div>
                        </div>

                        <div class="group">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-4 block">Your Comment</label>
                            <textarea name="comment" rows="4" required placeholder="What did you think of the craftsmanship?" 
                                class="w-full bg-slate-50 border-none rounded-[2rem] py-6 px-8 focus:ring-2 focus:ring-[#d4af37]/20 focus:bg-white transition-all outline-none resize-none"></textarea>
                        </div>

                        <button type="submit" name="submit_review" class="w-full bg-slate-900 text-white py-5 rounded-2xl font-bold text-xs uppercase tracking-widest hover:bg-black transition-all shadow-xl active:scale-[0.98]">
                            Post Review
                        </button>
                    </form>
                    <?php else: ?>
                    <div class="text-center py-10">
                        <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-300 text-2xl mx-auto mb-6">
                            <i class="fa-solid fa-lock"></i>
                        </div>
                        <p class="text-slate-500 mb-8 font-medium">Please sign in to share your thoughts.</p>
                        <a href="../auth/login.php" class="inline-block px-10 py-4 bg-slate-900 text-white rounded-xl font-bold uppercase text-[10px] tracking-widest hover:bg-[#d4af37] hover:text-black transition">Sign In</a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Review List -->
            <div class="lg:col-span-2 space-y-8">
                <?php
                $reviews_query = "
                    SELECT r.*, u.name as user_name, u.profile_pic 
                    FROM reviews r 
                    JOIN users u ON r.user_id = u.id 
                    WHERE r.product_id = {$prod['id']} 
                    ORDER BY r.created_at DESC
                ";
                $reviews_res = mysqli_query($conn, $reviews_query);
                
                if (mysqli_num_rows($reviews_res) > 0):
                    while ($review = mysqli_fetch_assoc($reviews_res)):
                ?>
                <div class="bg-white rounded-[3rem] p-10 shadow-sm border border-slate-50 hover:shadow-xl transition-all duration-500 group">
                    <div class="flex flex-col md:flex-row gap-8">
                        <div class="flex-shrink-0">
                            <img src="<?php echo BASE_URL . $review['profile_pic']; ?>" 
                                 class="w-16 h-16 rounded-2xl object-cover shadow-lg border-4 border-white"
                                 onerror="this.src='https://ui-avatars.com/api/?name=<?php echo urlencode($review['user_name']); ?>&background=f1f5f9&color=64748b'">
                        </div>
                        <div class="flex-1">
                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                                <div>
                                    <h4 class="text-lg font-bold text-slate-900 mb-1"><?php echo htmlspecialchars($review['user_name']); ?></h4>
                                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest"><?php echo date('F d, Y', strtotime($review['created_at'])); ?></span>
                                </div>
                                <div class="flex text-[#d4af37] text-xs gap-1.5 bg-[#d4af37]/5 px-4 py-2 rounded-full border border-[#d4af37]/10">
                                    <?php for($i=0; $i<5; $i++) echo $i<$review['rating'] ? '<i class="fa-solid fa-star"></i>' : '<i class="fa-regular fa-star"></i>'; ?>
                                </div>
                            </div>
                            <p class="text-slate-500 leading-relaxed italic pr-12">"<?php echo nl2br(htmlspecialchars($review['comment'])); ?>"</p>
                        </div>
                    </div>
                </div>
                <?php 
                    endwhile;
                else: 
                ?>
                <div class="bg-white rounded-[4rem] p-32 text-center border-2 border-dashed border-slate-100">
                    <div class="w-20 h-20 bg-slate-50 rounded-[2rem] flex items-center justify-center text-slate-200 text-3xl mx-auto mb-8">
                        <i class="fa-solid fa-comments"></i>
                    </div>
                    <h4 class="text-xl font-bold text-slate-900 mb-2">No reviews yet</h4>
                    <p class="text-slate-400">Be the first to share your experience with this masterpiece.</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
    .star-rating input:checked ~ i {
        color: #D4AF37;
    }
</style>

<?php include '../includes/footer.php'; ?>
