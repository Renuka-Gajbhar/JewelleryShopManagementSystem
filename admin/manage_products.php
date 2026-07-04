<?php
require_once '../includes/Config.php';

// Fetch Categories
$categories_res = mysqli_query($conn, "SELECT id, name FROM categories ORDER BY name ASC");

// Handle Add Product
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_product'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $category_id = intval($_POST['category_id']);
    $price = floatval($_POST['price']);
    $original_price = floatval($_POST['original_price']);
    $stock = intval($_POST['stock']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $rating = intval($_POST['rating']);
    
    // Image Upload Handling
    $image_url = 'download.png'; // default fallback image
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $upload_dir = '../uploads/';
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);
        
        $filename = uniqid() . '_' . basename($_FILES['image']['name']);
        $target_file = $upload_dir . $filename;
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image_url = 'uploads/' . $filename;
        } else {
            $msg = "Failed to upload image.";
            $toast_type = "error";
        }
    }

    $query = "INSERT INTO products (category_id, name, description, price, original_price, image_url, stock, rating) 
              VALUES ($category_id, '$name', '$description', $price, $original_price, '$image_url', $stock, $rating)";
              
    if (mysqli_query($conn, $query)) {
        header("Location: manage_products.php?success=1");
        exit();
    } else {
        $msg = "Database Error: " . mysqli_error($conn);
        $toast_type = "error";
    }
}

// Handle Edit Product
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_product'])) {
    $id = intval($_POST['product_id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $category_id = intval($_POST['category_id']);
    $price = floatval($_POST['price']);
    $original_price = floatval($_POST['original_price']);
    $stock = intval($_POST['stock']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $rating = intval($_POST['rating']);
    
    // Image Handling
    $image_update = "";
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $upload_dir = '../uploads/';
        $filename = uniqid() . '_' . basename($_FILES['image']['name']);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $filename)) {
            $image_url = 'uploads/' . $filename;
            $image_update = ", image_url='$image_url'";
        }
    }

    $query = "UPDATE products SET 
              category_id=$category_id, 
              name='$name', 
              description='$description', 
              price=$price, 
              original_price=$original_price, 
              stock=$stock, 
              rating=$rating 
              $image_update 
              WHERE id=$id";
              
    if (mysqli_query($conn, $query)) {
        header("Location: manage_products.php?updated=1");
        exit();
    } else {
        $msg = "Update Error: " . mysqli_error($conn);
        $toast_type = "error";
    }
}

// Handle Delete Product
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $delItemQuery = "DELETE FROM products WHERE id=$id";
    if(mysqli_query($conn, $delItemQuery)){
       header("Location: manage_products.php?deleted=1");
       exit();
    } else {
       $msg = "Error deleting product.";
       $toast_type = "error";
    }
}

// Fetch all products
$products_query = "
    SELECT p.*, c.name as category_name 
    FROM products p 
    LEFT JOIN categories c ON p.category_id = c.id 
    ORDER BY p.id DESC
";
$products_res = mysqli_query($conn, $products_query);
?>

<?php include 'includes/header.php'; ?>

<?php if (isset($_GET['success'])): ?>
    <script> document.addEventListener('DOMContentLoaded', () => { showToast("✅ Product added to the catalog.", "success"); }); </script>
<?php endif; ?>
<?php if (isset($_GET['updated'])): ?>
    <script> document.addEventListener('DOMContentLoaded', () => { showToast("✨ Product details updated.", "success"); }); </script>
<?php endif; ?>
<?php if (isset($_GET['deleted'])): ?>
    <script> document.addEventListener('DOMContentLoaded', () => { showToast("🗑️ Product removed successfully.", "success"); }); </script>
<?php endif; ?>
<?php if (isset($msg)): ?>
    <script> document.addEventListener('DOMContentLoaded', () => { showToast("<?php echo $msg; ?>", "<?php echo $toast_type; ?>"); }); </script>
<?php endif; ?>

<div class="mb-8 flex flex-col md:flex-row justify-between items-center gap-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-900 mb-1">Products</h1>
        <p class="text-slate-400 text-sm">Manage your jewellery catalog</p>
    </div>
    <button onclick="openModal()" class="bg-slate-900 text-white px-6 py-3 rounded-xl hover:bg-primary hover:text-black transition-all shadow-sm active:scale-95 font-bold flex items-center gap-2 text-sm">
        <i class="fa-solid fa-plus"></i> Add New Product
    </button>
</div>

<!-- Products Table -->
<div class="bg-white rounded-[3rem] shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto custom-scrollbar">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50/50 text-slate-400 text-[10px] font-bold uppercase tracking-[0.2em]">
                    <th class="py-6 px-10">Image</th>
                    <th class="py-6 px-10">Product Name & Category</th>
                    <th class="py-6 px-10">Price</th>
                    <th class="py-6 px-10">Stock</th>
                    <th class="py-6 px-10 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                <?php if(mysqli_num_rows($products_res) > 0): ?>
                    <?php while($prod = mysqli_fetch_assoc($products_res)): ?>
                    <tr class="hover:bg-slate-50/80 transition-all group">
                        <td class="py-5 px-8">
                            <img src="<?php echo BASE_URL . $prod['image_url']; ?>" alt="Product" class="w-16 h-16 object-cover rounded-xl border border-slate-100">
                        </td>
                        <td class="py-5 px-8">
                            <span class="text-[10px] font-bold text-white uppercase tracking-widest block mb-1"><?php echo htmlspecialchars($prod['category_name'] ?? 'Uncategorized'); ?></span>
                            <h4 class="text-sm font-bold text-slate-900 leading-tight"><?php echo htmlspecialchars($prod['name']); ?></h4>
                        </td>
                        <td class="py-6 px-10">
                            <div class="flex flex-col">
                                <span class="text-lg font-bold text-slate-900 font-serif">₹<?php echo number_format($prod['price'], 0); ?></span>
                                <?php if($prod['original_price'] > $prod['price']): ?>
                                    <span class="text-xs text-slate-400 line-through">₹<?php echo number_format($prod['original_price'], 0); ?></span>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td class="py-6 px-10">
                            <div class="flex items-center gap-3">
                                <?php 
                                    $stockColor = $prod['stock'] > 10 ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : ($prod['stock'] > 0 ? 'bg-amber-50 text-amber-600 border-amber-100' : 'bg-red-50 text-red-600 border-red-100');
                                ?>
                                <span class="px-4 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-widest border <?php echo $stockColor; ?>">
                                    <?php echo $prod['stock']; ?> units
                                </span>
                            </div>
                        </td>
                        <td class="py-6 px-10 text-right">
                            <div class="flex justify-end gap-2">
                                <button onclick="openEditModal(<?php echo htmlspecialchars(json_encode($prod)); ?>)" 
                                        class="w-10 h-10 rounded-xl bg-slate-50 text-slate-400 hover:bg-slate-900 hover:text-white transition active:scale-90 flex items-center justify-center">
                                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                                </button>
                                <a href="?delete=<?php echo $prod['id']; ?>" class="w-10 h-10 rounded-xl bg-red-50 text-red-400 hover:bg-red-600 hover:text-white transition active:scale-90 flex items-center justify-center" onclick="return confirm('Delete this product?');">
                                    <i class="fa-solid fa-trash text-xs"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="py-20 text-center">
                            <i class="fa-solid fa-gem text-5xl text-slate-100 mb-4 block"></i>
                            <h3 class="text-lg font-bold text-slate-500">No products yet</h3>
                            <p class="text-slate-400 text-sm mt-2">Click "Add New Product" to get started.</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div id="add-product-modal" class="fixed inset-0 z-[100] hidden items-center justify-center p-6 bg-slate-900/40 backdrop-blur-sm overflow-hidden">
    <div class="relative bg-white w-full max-w-2xl rounded-[3rem] shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-300 flex flex-col max-h-full">
        <div class="p-8 border-b border-slate-50 flex justify-between items-center">
            <div>
                <h3 class="text-lg font-bold text-slate-900">Add New Product</h3>
                <p class="text-xs text-slate-400 mt-0.5">Fill in the product details below</p>
            </div>
            <button onclick="closeModal()" class="w-9 h-9 rounded-xl bg-white shadow-sm flex items-center justify-center text-slate-400 hover:text-red-500 transition active:scale-90">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        
        <form action="" method="POST" enctype="multipart/form-data" class="flex-1 overflow-y-auto custom-scrollbar p-10 space-y-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-6">
                    <div class="group">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 block group-focus-within:text-white transition">Product Name</label>
                        <input type="text" name="name" required placeholder="e.g. Diamond Necklace" 
                            class="w-full bg-slate-50 border-none rounded-xl py-3 px-5 focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all outline-none">
                    </div>
                    
                    <div class="group">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 block group-focus-within:text-white transition">Category</label>
                        <select name="category_id" required class="w-full bg-slate-50 border-none rounded-xl py-3 px-5 focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all outline-none appearance-none cursor-pointer">
                            <option value="">Select Category</option>
                            <?php 
                            mysqli_data_seek($categories_res, 0); 
                            while($c = mysqli_fetch_assoc($categories_res)): 
                            ?>
                                <option value="<?php echo $c['id']; ?>"><?php echo htmlspecialchars($c['name']); ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="group">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 block group-focus-within:text-white transition">Original Price (₹)</label>
                            <input type="number" step="0.01" name="original_price" id="original_price" required placeholder="0.00" 
                                class="w-full bg-slate-50 border-none rounded-xl py-3 px-5 focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all outline-none">
                        </div>
                        <div class="group">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 block group-focus-within:text-white transition">Sale Price (₹) <span class="text-[8px] text-white italic">(12% Discount)</span></label>
                            <input type="number" step="0.01" name="price" id="price" required placeholder="0.00" 
                                class="w-full bg-slate-50 border-none rounded-xl py-3 px-5 focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all outline-none">
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="group">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 block group-focus-within:text-white transition">Stock Qty</label>
                            <input type="number" name="stock" value="10" required 
                                class="w-full bg-slate-50 border-none rounded-xl py-3 px-5 focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all outline-none">
                        </div>
                        <div class="group">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 block group-focus-within:text-white transition">Rating (1-5)</label>
                            <input type="number" name="rating" min="1" max="5" value="5" required 
                                class="w-full bg-slate-50 border-none rounded-xl py-3 px-5 focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all outline-none">
                        </div>
                    </div>

                    <div class="group">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 block group-focus-within:text-white transition">Product Image</label>
                        <div class="relative group/upload h-28">
                            <input type="file" name="image" id="file-upload" required accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20">
                            <div class="absolute inset-0 border-2 border-dashed border-slate-200 rounded-2xl bg-slate-50 flex flex-col items-center justify-center group-hover/upload:border-primary group-hover/upload:bg-primary/5 transition duration-300">
                                <i class="fa-solid fa-cloud-arrow-up text-xl text-slate-300 group-hover/upload:text-white transition mb-1"></i>
                                <span class="text-[10px] font-bold text-slate-400 group-hover/upload:text-white transition uppercase tracking-widest">Click to Upload</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="group">
                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 block group-focus-within:text-white transition">Description</label>
                <textarea name="description" rows="3" placeholder="Describe the product..." 
                    class="w-full bg-slate-50 border-none rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all outline-none resize-none"></textarea>
            </div>

            <div class="flex gap-4 pt-4">
                <button type="button" onclick="closeModal()" class="flex-1 py-4 rounded-xl border border-slate-100 font-bold text-slate-500 hover:bg-slate-50 transition active:scale-95">Cancel</button>
                <button type="submit" name="add_product" class="flex-[2] py-4 bg-slate-900 text-white rounded-xl font-bold hover:bg-primary hover:text-black transition shadow-sm active:scale-95 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-save"></i> Save Product
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal() {
        const modal = document.getElementById('add-product-modal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        document.getElementById('add-product-modal').classList.add('hidden');
        document.getElementById('edit-product-modal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    function openEditModal(product) {
        const modal = document.getElementById('edit-product-modal');
        const form = modal.querySelector('form');
        
        form.querySelector('[name="product_id"]').value = product.id;
        form.querySelector('[name="name"]').value = product.name;
        form.querySelector('[name="category_id"]').value = product.category_id;
        form.querySelector('[name="original_price"]').value = product.original_price;
        form.querySelector('[name="price"]').value = product.price;
        form.querySelector('[name="stock"]').value = product.stock;
        form.querySelector('[name="rating"]').value = product.rating;
        form.querySelector('[name="description"]').value = product.description;
        
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    // Auto-calculate 12% discount for both forms
    function setupDiscountCalc(originalId, priceId) {
        const originalInput = document.getElementById(originalId);
        const priceInput = document.getElementById(priceId);
        
        originalInput.addEventListener('input', () => {
            const val = parseFloat(originalInput.value);
            if (!isNaN(val)) priceInput.value = (val * 0.88).toFixed(0);
        });
    }

    setupDiscountCalc('original_price', 'price');
    setupDiscountCalc('edit_original_price', 'edit_price');
</script>

<!-- Edit Modal -->
<div id="edit-product-modal" class="fixed inset-0 z-[100] hidden items-center justify-center p-6 bg-slate-900/40 backdrop-blur-sm overflow-hidden">
    <div class="relative bg-white w-full max-w-2xl rounded-[3rem] shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-300 flex flex-col max-h-full">
        <div class="p-8 border-b border-slate-50 flex justify-between items-center">
            <div>
                <h3 class="text-lg font-bold text-slate-900">Edit Product</h3>
                <p class="text-xs text-slate-400 mt-0.5">Modify the product details below</p>
            </div>
            <button onclick="closeModal()" class="w-9 h-9 rounded-xl bg-white shadow-sm flex items-center justify-center text-slate-400 hover:text-red-500 transition active:scale-90">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        
        <form action="" method="POST" enctype="multipart/form-data" class="flex-1 overflow-y-auto custom-scrollbar p-10 space-y-8">
            <input type="hidden" name="product_id">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-6">
                    <div class="group">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 block">Product Name</label>
                        <input type="text" name="name" required class="w-full bg-slate-50 border-none rounded-xl py-3 px-5 focus:ring-2 focus:ring-primary/20 outline-none">
                    </div>
                    <div class="group">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 block">Category</label>
                        <select name="category_id" required class="w-full bg-slate-50 border-none rounded-xl py-3 px-5 focus:ring-2 focus:ring-primary/20 outline-none cursor-pointer">
                            <?php 
                            mysqli_data_seek($categories_res, 0); 
                            while($c = mysqli_fetch_assoc($categories_res)): 
                            ?>
                                <option value="<?php echo $c['id']; ?>"><?php echo htmlspecialchars($c['name']); ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="group">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 block">Original Price (₹)</label>
                            <input type="number" step="0.01" name="original_price" id="edit_original_price" required class="w-full bg-slate-50 border-none rounded-xl py-3 px-5 focus:ring-2 focus:ring-primary/20 outline-none">
                        </div>
                        <div class="group">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 block">Sale Price (₹)</label>
                            <input type="number" step="0.01" name="price" id="edit_price" required class="w-full bg-slate-50 border-none rounded-xl py-3 px-5 focus:ring-2 focus:ring-primary/20 outline-none">
                        </div>
                    </div>
                </div>
                <div class="space-y-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="group">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 block">Stock Qty</label>
                            <input type="number" name="stock" required class="w-full bg-slate-50 border-none rounded-xl py-3 px-5 focus:ring-2 focus:ring-primary/20 outline-none">
                        </div>
                        <div class="group">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 block">Rating (1-5)</label>
                            <input type="number" name="rating" min="1" max="5" required class="w-full bg-slate-50 border-none rounded-xl py-3 px-5 focus:ring-2 focus:ring-primary/20 outline-none">
                        </div>
                    </div>
                    <div class="group">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 block text-white">New Image (Optional)</label>
                        <input type="file" name="image" accept="image/*" class="w-full text-[10px] text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-semibold file:bg-slate-50 file:text-white hover:file:bg-primary/10">
                    </div>
                </div>
            </div>
            <div class="group">
                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 block">Description</label>
                <textarea name="description" rows="3" class="w-full bg-slate-50 border-none rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary/20 outline-none resize-none"></textarea>
            </div>
            <div class="flex gap-4 pt-4">
                <button type="button" onclick="closeModal()" class="flex-1 py-4 rounded-xl border border-slate-100 font-bold text-slate-500 hover:bg-slate-50 active:scale-95 transition">Cancel</button>
                <button type="submit" name="edit_product" class="flex-[2] py-4 bg-slate-900 text-white rounded-xl font-bold hover:bg-primary hover:text-black transition shadow-sm active:scale-95 flex items-center justify-center gap-2 text-sm">
                    <i class="fa-solid fa-save"></i> Update Product
                </button>
            </div>
        </form>
    </div>
</div>


<?php include 'includes/footer.php'; ?>
