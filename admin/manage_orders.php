<?php
require_once '../includes/Config.php';

// Handle Status Update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_status'])) {
    $order_id = (int)$_POST['order_id'];
    $new_status = mysqli_real_escape_string($conn, $_POST['status']);
    
    $update_query = "UPDATE orders SET status='$new_status' WHERE id=$order_id";
    if (mysqli_query($conn, $update_query)) {
        $msg = "✅ Status updated to $new_status.";
        $toast_type = "success";
    } else {
        $msg = "Error updating status.";
        $toast_type = "error";
    }
}

// Fetch Orders
$orders_query = "
    SELECT o.id, o.total_amount, o.status, o.payment_id, o.created_at, u.name as customer_name, u.email 
    FROM orders o 
    JOIN users u ON o.user_id = u.id 
    ORDER BY o.created_at DESC
";
$orders_res = mysqli_query($conn, $orders_query);
?>

<?php include 'includes/header.php'; ?>

<?php if (isset($msg)): ?>
    <script> document.addEventListener('DOMContentLoaded', () => { showToast("<?php echo $msg; ?>", "<?php echo $toast_type; ?>"); }); </script>
<?php endif; ?>

<div class="mb-12">
    <h1 class="text-3xl font-bold text-slate-900 font-serif mb-1">Orders</h1>
    <p class="text-slate-400 text-sm font-medium uppercase tracking-widest">Manage and process customer orders</p>
</div>

<div class="bg-white rounded-[3rem] shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto custom-scrollbar">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50/50 text-slate-400 text-[10px] font-bold uppercase tracking-[0.2em]">
                    <th class="py-6 px-10">Order ID</th>
                    <th class="py-6 px-10">Customer Info</th>
                    <th class="py-6 px-10">Order Date</th>
                    <th class="py-6 px-10">Amount</th>
                    <th class="py-6 px-10 text-right">Order Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                <?php if(mysqli_num_rows($orders_res) > 0): ?>
                    <?php while($order = mysqli_fetch_assoc($orders_res)): ?>
                    <tr class="hover:bg-slate-50/80 transition-all group">
                        <td class="py-6 px-10">
                            <span class="text-sm font-bold text-slate-900 font-mono">#<?php echo str_pad($order['id'], 6, '0', STR_PAD_LEFT); ?></span>
                            <?php if($order['payment_id'] != 'cash_on_delivery'): ?>
                                <span class="block text-[9px] text-emerald-500 font-bold uppercase tracking-[0.2em] mt-1 italic">Digital Payment</span>
                            <?php else: ?>
                                <span class="block text-[9px] text-amber-500 font-bold uppercase tracking-[0.2em] mt-1 italic">COD</span>
                            <?php endif; ?>
                        </td>
                        <td class="py-6 px-10">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-xs font-bold text-slate-400 group-hover:bg-primary group-hover:text-black transition-all">
                                    <?php echo strtoupper(substr($order['customer_name'], 0, 1)); ?>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-900 leading-none mb-1"><?php echo htmlspecialchars($order['customer_name']); ?></p>
                                    <p class="text-xs text-slate-400 font-medium"><?php echo htmlspecialchars($order['email']); ?></p>
                                </div>
                            </div>
                        </td>
                        <td class="py-6 px-10 text-sm text-slate-500"><?php echo date('M d, Y', strtotime($order['created_at'])); ?></td>
                        <td class="py-6 px-10 text-sm font-bold text-slate-900">₹<?php echo number_format($order['total_amount'], 2); ?></td>
                        <td class="py-6 px-10 text-right">
                            <form action="" method="POST" class="flex items-center justify-end gap-3 group-hover:translate-x-[-10px] transition duration-500">
                                <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                <div class="relative">
                                    <select name="status" onchange="this.form.submit()" class="block w-40 bg-slate-50 border-none rounded-xl py-2 px-4 text-[10px] font-bold uppercase tracking-widest appearance-none cursor-pointer focus:ring-2 focus:ring-primary/20 transition-all
                                        <?php 
                                            if($order['status'] == 'Pending') echo 'text-amber-600';
                                            elseif($order['status'] == 'Processing') echo 'text-blue-600';
                                            elseif($order['status'] == 'Shipped') echo 'text-purple-600';
                                            elseif($order['status'] == 'Delivered') echo 'text-emerald-600';
                                        ?>">
                                        <option value="Pending" <?php echo $order['status'] == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                        <option value="Processing" <?php echo $order['status'] == 'Processing' ? 'selected' : ''; ?>>Processing</option>
                                        <option value="Shipped" <?php echo $order['status'] == 'Shipped' ? 'selected' : ''; ?>>Shipped</option>
                                        <option value="Delivered" <?php echo $order['status'] == 'Delivered' ? 'selected' : ''; ?>>Delivered</option>
                                    </select>
                                    <input type="hidden" name="update_status" value="1">
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-400">
                                        <i class="fa-solid fa-chevron-down text-[8px]"></i>
                                    </div>
                                </div>
                                <button type="button" onclick="viewDetails(<?php echo $order['id']; ?>)" class="w-10 h-10 rounded-xl bg-slate-50 text-slate-400 hover:bg-slate-900 hover:text-white transition active:scale-90 flex items-center justify-center">
                                    <i class="fa-solid fa-eye text-xs"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="py-16 text-center">
                            <div class="w-24 h-24 bg-slate-50 rounded-[2rem] flex items-center justify-center text-slate-200 text-4xl mx-auto mb-6">
                                <i class="fa-solid fa-receipt"></i>
                            </div>
                            <h3 class="text-xl font-bold text-slate-900 font-serif">Empty Orders</h3>
                            <p class="text-slate-400 text-sm font-medium mt-2">No orders have been placed yet.</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    function viewDetails(orderId) {
        // Feature to be implemented: Detailed Order Inspect Modal
        showToast("🔍 Viewing order #" + String(orderId).padStart(6, '0'), "success");
    }
</script>

<?php include 'includes/footer.php'; ?>
