<?php
require_once '../includes/Config.php';

// Handle Add Category
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_category'])) {
    $cat_name = mysqli_real_escape_string($conn, $_POST['category_name']);
    
    $check_query = "SELECT * FROM categories WHERE name='$cat_name'";
    $check_res = mysqli_query($conn, $check_query);
    
    if (mysqli_num_rows($check_res) > 0) {
        $msg = "Category already exists!";
        $toast_type = "error";
    } else {
    // Category Image Handling
    $image_url = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $upload_dir = '../uploads/categories/';
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);
        $filename = uniqid() . '_' . basename($_FILES['image']['name']);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $filename)) {
            $image_url = 'uploads/categories/' . $filename;
        }
    }

    $query = "INSERT INTO categories (name, image_url) VALUES ('$cat_name', '$image_url')";
    if (mysqli_query($conn, $query)) {
        $msg = "✅ New category created: $cat_name.";
        $toast_type = "success";
    } else {
        $msg = "Error adding category: " . mysqli_error($conn);
        $toast_type = "error";
    }
    }
}

// Handle Delete Category
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $delItemQuery = "DELETE FROM categories WHERE id=$id";
    if(mysqli_query($conn, $delItemQuery)){
       $msg = "🗑️ Category deleted.";
       $toast_type = "success";
    } else {
       $msg = "⚠️ Cannot delete category; it is used by products.";
       $toast_type = "error";
    }
}

$categories = mysqli_query($conn, "SELECT * FROM categories ORDER BY id DESC");
?>

<?php include 'includes/header.php'; ?>

<?php if (isset($msg)): ?>
    <script> document.addEventListener('DOMContentLoaded', () => { showToast("<?php echo $msg; ?>", "<?php echo $toast_type; ?>"); }); </script>
<?php endif; ?>

<div class="mb-12">
    <h1 class="text-3xl font-bold text-slate-900 mb-1">Categories</h1>
    <p class="text-slate-400 text-sm">Organize your jewelery collections</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
    
    <!-- Add Category Form -->
    <div class="lg:col-span-1 bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-10 h-fit">
        <div class="mb-8">
            <h3 class="text-xl font-bold text-slate-900">Add New Category</h3>
            <p class="text-xs text-slate-400 mt-1">Define a new category for products</p>
        </div>
        
        <form action="" method="POST" enctype="multipart/form-data" class="space-y-6">
            <div class="group">
                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 block group-focus-within:text-white transition">Category Name</label>
                <input type="text" name="category_name" required placeholder="e.g. Necklaces, Rings..." 
                    class="w-full bg-slate-50 border-none rounded-xl py-4 px-6 focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all outline-none">
            </div>

            <div class="group">
                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 block">Category Image</label>
                <div class="relative group/upload h-24">
                    <input type="file" name="image" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20">
                    <div class="absolute inset-0 border-2 border-dashed border-slate-200 rounded-xl bg-slate-50 flex flex-col items-center justify-center group-hover/upload:border-primary transition">
                        <i class="fa-solid fa-cloud-arrow-up text-lg text-slate-300 group-hover/upload:text-white transition mb-1"></i>
                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest group-hover/upload:text-white transition">Upload Image</span>
                    </div>
                </div>
            </div>
            
            <button type="submit" name="add_category" class="w-full py-4 bg-slate-900 text-white rounded-xl font-bold hover:bg-black transition shadow-sm active:scale-95 flex items-center justify-center gap-2"> 
                <i class="fa-solid fa-plus-circle"></i> Create Category 
            </button>
        </form>
    </div>

    <!-- Categories List -->
    <div class="lg:col-span-2 bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-10 border-b border-slate-50">
            <h3 class="text-xl font-bold text-slate-900">Manage Categories</h3>
            <p class="text-xs text-slate-400 mt-1">Current categories available</p>
        </div>
        
        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50 text-slate-400 text-[10px] font-bold uppercase tracking-[0.2em]">
                        <th class="py-6 px-10">ID</th>
                        <th class="py-6 px-10">Category Name</th>
                        <th class="py-6 px-10 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php if(mysqli_num_rows($categories) > 0): ?>
                        <?php while($cat = mysqli_fetch_assoc($categories)): ?>
                        <tr class="hover:bg-slate-50/80 transition-all group">
                            <td class="py-6 px-10 font-mono text-xs text-slate-400">#<?php echo str_pad($cat['id'], 3, '0', STR_PAD_LEFT); ?></td>
                            <td class="py-6 px-10">
                                <span class="text-sm font-bold text-slate-900"><?php echo htmlspecialchars($cat['name']); ?></span>
                            </td>
                            <td class="py-6 px-10 text-right">
                                <a href="?delete=<?php echo $cat['id']; ?>" class="w-10 h-10 rounded-xl bg-red-50 text-red-400 hover:bg-red-600 hover:text-white transition active:scale-90 flex items-center justify-center ml-auto" onclick="return confirm('Delete this category?');">
                                    <i class="fa-solid fa-trash text-xs"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="py-16 text-center">
                                <div class="w-20 h-20 bg-slate-50 rounded-[2rem] flex items-center justify-center text-slate-200 text-3xl mx-auto mb-6">
                                    <i class="fa-solid fa-shapes"></i>
                                </div>
                                <h3 class="text-lg font-bold text-slate-900">No categories found</h3>
                                <p class="text-slate-400 text-xs mt-2">Start by creating your first category.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
