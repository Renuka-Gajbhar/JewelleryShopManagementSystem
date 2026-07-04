<?php 
require_once '../includes/Config.php';

// Dashboard Statistics
$stats_query = "
    SELECT 
        (SELECT COUNT(*) FROM orders) as total_orders,
        (SELECT COUNT(*) FROM products) as total_products,
        (SELECT COUNT(*) FROM users WHERE role='user') as total_users,
        (SELECT COALESCE(SUM(total_amount), 0) FROM orders WHERE status='Delivered') as total_earnings
";
$stats_result = mysqli_query($conn, $stats_query);
$stats = mysqli_fetch_assoc($stats_result);

// Recent Orders
$recent_orders_query = "
    SELECT o.id, u.name, o.total_amount, o.status, o.created_at 
    FROM orders o 
    JOIN users u ON o.user_id = u.id 
    ORDER BY o.created_at DESC LIMIT 5
";
$recent_orders = mysqli_query($conn, $recent_orders_query);
?>

<?php include 'includes/header.php'; ?>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
    <!-- Stat Cards -->
    <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-slate-100 hover:shadow-xl transition-all duration-500 group">
        <div class="flex items-center justify-between mb-6">
            <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl group-hover:bg-blue-600 group-hover:text-white transition-all duration-500">
                <i class="fa-solid fa-users"></i>
            </div>
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Customers</span>
        </div>
        <h3 class="text-3xl font-bold text-slate-900 mb-1"><?php echo number_format($stats['total_users']); ?></h3>
        <p class="text-xs text-slate-400 font-medium">Registered Users</p>
    </div>
    
    <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-slate-100 hover:shadow-xl transition-all duration-500 group">
        <div class="flex items-center justify-between mb-6">
            <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl group-hover:bg-emerald-600 group-hover:text-white transition-all duration-500">
                <i class="fa-solid fa-gem"></i>
            </div>
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Products</span>
        </div>
        <h3 class="text-3xl font-bold text-slate-900 mb-1"><?php echo number_format($stats['total_products']); ?></h3>
        <p class="text-xs text-slate-400 font-medium">Total Inventory</p>
    </div>
    
    <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-slate-100 hover:shadow-xl transition-all duration-500 group">
        <div class="flex items-center justify-between mb-6">
            <div class="w-14 h-14 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl group-hover:bg-purple-600 group-hover:text-white transition-all duration-500">
                <i class="fa-solid fa-receipt"></i>
            </div>
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Orders</span>
        </div>
        <h3 class="text-3xl font-bold text-slate-900 mb-1"><?php echo number_format($stats['total_orders']); ?></h3>
        <p class="text-xs text-slate-400 font-medium">Total Received</p>
    </div>
    
    <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-slate-100 hover:shadow-xl transition-all duration-500 group">
        <div class="flex items-center justify-between mb-6">
            <div class="w-14 h-14 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl group-hover:bg-amber-600 group-hover:text-white transition-all duration-500">
                <i class="fa-solid fa-indian-rupee-sign"></i>
            </div>
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Revenue</span>
        </div>
        <h3 class="text-3xl font-bold text-slate-900 mb-1">₹<?php echo number_format($stats['total_earnings'], 0); ?></h3>
        <p class="text-xs text-slate-400 font-medium">From Delivered Orders</p>
    </div>
</div>

<div class="bg-white rounded-[3rem] shadow-sm border border-slate-100 overflow-hidden">
    <div class="p-10 border-b border-slate-50 flex justify-between items-center">
        <div>
            <h3 class="text-xl font-bold text-slate-900 font-serif">Recent Orders</h3>
            <p class="text-xs text-slate-400 font-medium mt-1">Latest 5 orders</p>
        </div>
        <a href="manage_orders.php" class="px-6 py-3 bg-slate-50 text-slate-600 rounded-xl text-xs font-bold uppercase tracking-widest hover:bg-primary hover:text-white transition-all">
            View All Orders
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50/50 text-slate-400 text-[10px] font-bold uppercase tracking-[0.2em]">
                    <th class="py-6 px-10">Order ID</th>
                    <th class="py-6 px-10">Customer</th>
                    <th class="py-6 px-10">Date</th>
                    <th class="py-6 px-10">Amount</th>
                    <th class="py-6 px-10 text-right">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                <?php if(mysqli_num_rows($recent_orders) > 0): ?>
                    <?php while($row = mysqli_fetch_assoc($recent_orders)): ?>
                    <tr class="hover:bg-slate-50/80 transition-all group">
                        <td class="py-6 px-10 text-sm font-bold text-slate-900">#<?php echo str_pad($row['id'], 6, '0', STR_PAD_LEFT); ?></td>
                        <td class="py-6 px-10">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-[10px] font-bold text-slate-400 group-hover:bg-primary group-hover:text-white transition-all">
                                    <?php echo strtoupper(substr($row['name'], 0, 1)); ?>
                                </div>
                                <span class="text-sm font-medium text-slate-700"><?php echo htmlspecialchars($row['name']); ?></span>
                            </div>
                        </td>
                        <td class="py-6 px-10 text-sm text-slate-500"><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                        <td class="py-6 px-10 text-sm font-bold text-slate-900">₹<?php echo number_format($row['total_amount'], 2); ?></td>
                        <td class="py-6 px-10 text-right">
                            <?php 
                                $statusClass = '';
                                switch($row['status']){
                                    case 'Pending': $statusClass = 'bg-amber-50 text-amber-600 border-amber-100'; break;
                                    case 'Processing': $statusClass = 'bg-blue-50 text-blue-600 border-blue-100'; break;
                                    case 'Shipped': $statusClass = 'bg-purple-50 text-purple-600 border-purple-100'; break;
                                    case 'Delivered': $statusClass = 'bg-emerald-50 text-emerald-600 border-emerald-100'; break;
                                }
                            ?>
                            <span class="px-4 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-widest border <?php echo $statusClass; ?>">
                                <?php echo $row['status']; ?>
                            </span>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="py-20 text-center">
                            <i class="fa-solid fa-receipt text-4xl text-slate-100 mb-4 block"></i>
                            <p class="text-slate-400 text-sm font-medium">No orders yet.</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
