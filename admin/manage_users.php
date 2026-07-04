<?php
require_once '../includes/Config.php';

// Handle Delete User (Optional)
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    
    // Prevent admin self-deletion
    if($id === $_SESSION['user_id']){
        $msg = "⚠️ You cannot delete your own account.";
        $toast_type = "warning";
    } else {
        $delItemQuery = "DELETE FROM users WHERE id=$id AND role='user'"; // only allow deleting users, not admins
        if(mysqli_query($conn, $delItemQuery)){
           $msg = "🗑️ Customer record deleted.";
           $toast_type = "success";
        } else {
           $msg = "Error deleting customer.";
           $toast_type = "error";
        }
    }
}

// Fetch Users
$users_query = "
    SELECT u.id, u.name, u.email, u.phone, u.role, u.created_at, 
           (SELECT COUNT(*) FROM orders WHERE user_id = u.id) as order_count 
    FROM users u 
    ORDER BY u.created_at DESC
";
$users_res = mysqli_query($conn, $users_query);
?>

<?php include 'includes/header.php'; ?>

<?php if (isset($msg)): ?>
    <script> document.addEventListener('DOMContentLoaded', () => { showToast("<?php echo $msg; ?>", "<?php echo $toast_type; ?>"); }); </script>
<?php endif; ?>

<div class="mb-12">
    <h1 class="text-3xl font-bold text-slate-900 mb-1">Customers</h1>
    <p class="text-slate-400 text-sm">Manage registered users and theirs orders</p>
</div>

<div class="bg-white rounded-[3rem] shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto custom-scrollbar">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50/50 text-slate-400 text-[10px] font-bold uppercase tracking-[0.2em]">
                    <th class="py-6 px-10">ID</th>
                    <th class="py-6 px-10">Customer Name</th>
                    <th class="py-6 px-10">Contact Info</th>
                    <th class="py-6 px-10 text-center">Orders</th>
                    <th class="py-6 px-10">Role</th>
                    <th class="py-6 px-10 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                <?php if(mysqli_num_rows($users_res) > 0): ?>
                    <?php while($u = mysqli_fetch_assoc($users_res)): ?>
                    <tr class="hover:bg-slate-50/80 transition-all group">
                        <td class="py-6 px-10 font-mono text-xs text-slate-400">#<?php echo str_pad($u['id'], 4, '0', STR_PAD_LEFT); ?></td>
                        <td class="py-6 px-10">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-slate-900 flex items-center justify-center text-white font-bold text-lg group-hover:scale-110 transition duration-500">
                                    <?php echo strtoupper(substr($u['name'], 0, 1)); ?>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-900 leading-none mb-1"><?php echo htmlspecialchars($u['name']); ?></p>
                                    <p class="text-[10px] text-slate-400 font-medium uppercase tracking-widest">Member since <?php echo date('M Y', strtotime($u['created_at'])); ?></p>
                                </div>
                            </div>
                        </td>
                        <td class="py-6 px-10">
                            <div class="flex flex-col gap-1">
                                <div class="flex items-center gap-2 text-xs text-slate-600">
                                    <i class="fa-regular fa-envelope text-[10px] text-white"></i>
                                    <span><?php echo htmlspecialchars($u['email']); ?></span>
                                </div>
                                <div class="flex items-center gap-2 text-xs text-slate-400">
                                    <i class="fa-solid fa-phone text-[10px]"></i>
                                    <span><?php echo htmlspecialchars($u['phone']); ?></span>
                                </div>
                            </div>
                        </td>
                        <td class="py-6 px-10 text-center">
                            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-blue-50 text-blue-600 font-bold text-xs border border-blue-100">
                                <?php echo $u['order_count']; ?>
                            </span>
                        </td>
                        <td class="py-6 px-10">
                            <?php 
                                $roleClass = $u['role'] === 'admin' ? 'bg-primary/10 text-white border-primary/20' : 'bg-slate-50 text-slate-500 border-slate-100';
                            ?>
                            <span class="px-4 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-widest border <?php echo $roleClass; ?>">
                                <?php echo $u['role']; ?>
                            </span>
                        </td>
                        <td class="py-6 px-10 text-right">
                            <?php if($u['role'] !== 'admin'): ?>
                                <a href="?delete=<?php echo $u['id']; ?>" class="w-10 h-10 rounded-xl bg-red-50 text-red-400 hover:bg-red-600 hover:text-white transition active:scale-90 flex items-center justify-center ml-auto" onclick="return confirm('Delete this customer?');">
                                    <i class="fa-solid fa-user-xmark text-xs"></i>
                                </a>
                            <?php else: ?>
                                <span class="text-[10px] font-bold text-slate-300 uppercase tracking-widest italic">Protected</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="py-16 text-center">
                            <div class="w-20 h-20 bg-slate-50 rounded-[2rem] flex items-center justify-center text-slate-200 text-3xl mx-auto mb-6">
                                <i class="fa-solid fa-users-slash"></i>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 font-serif">The registry is empty.</h3>
                            <p class="text-slate-400 text-xs font-medium mt-2">No customers have registered yet.</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
