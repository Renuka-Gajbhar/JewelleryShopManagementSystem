<?php
require_once '../includes/Config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: " . BASE_URL . "auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch User Orders
$orders_query = "
    SELECT id, total_amount, status, created_at 
    FROM orders 
    WHERE user_id = $user_id 
    ORDER BY created_at DESC
";
$orders_res = mysqli_query($conn, $orders_query);
?>

<?php include '../includes/header.php'; ?>

<div class="bg-gray-50 min-h-screen py-24">
    <div class="max-w-[1400px] mx-auto px-8">
        <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-8 text-center md:text-left">
            <div class="max-w-2xl">
                <span class="text-white font-bold uppercase tracking-[0.4em] text-xs mb-4 block">Order History</span>
                <h1 class="text-5xl font-serif font-bold text-gray-900 leading-tight">My <span class="italic text-white">Jewellery</span> Orders</h1>
            </div>
            <p class="text-gray-400 font-light max-w-sm mb-2 text-sm leading-relaxed border-l-2 border-primary/20 pl-6 hidden md:block">
                Track your orders from our workshop to your doorstep.
            </p>
        </div>

        <div class="max-w-4xl mx-auto space-y-8">
            <?php if(mysqli_num_rows($orders_res) > 0): ?>
                <?php while($order = mysqli_fetch_assoc($orders_res)): ?>
                    <div class="group bg-white rounded-[3rem] p-8 md:p-12 shadow-sm border border-gray-100 hover:shadow-2xl transition-all duration-700 flex flex-col md:flex-row items-center gap-8 md:gap-12 relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-2 h-full bg-primary/20 group-hover:bg-primary transition-colors duration-700"></div>
                        
                        <div class="flex-grow">
                            <div class="flex flex-wrap items-center gap-4 mb-6">
                                <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Order ID:</span>
                                <span class="text-lg font-bold text-gray-900 font-serif">#<?php echo str_pad($order['id'], 6, '0', STR_PAD_LEFT); ?></span>
                                <span class="px-4 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-widest 
                                    <?php 
                                        if($order['status'] == 'Pending') echo 'bg-amber-50 text-amber-600 border border-amber-100';
                                        elseif($order['status'] == 'Processing') echo 'bg-blue-50 text-blue-600 border border-blue-100';
                                        elseif($order['status'] == 'Shipped') echo 'bg-purple-50 text-purple-600 border border-purple-100';
                                        else echo 'bg-emerald-50 text-emerald-600 border border-emerald-100';
                                    ?>">
                                    <?php echo $order['status']; ?>
                                </span>
                            </div>
                            
                            <div class="flex items-center gap-8">
                                <div>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-1">Order Date</p>
                                    <p class="text-sm font-medium text-gray-600"><?php echo date('M d, Y h:i A', strtotime($order['created_at'])); ?></p>
                                </div>
                                <div>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-1">Total Amount</p>
                                    <p class="text-xl font-bold text-gray-900 font-serif">₹<?php echo number_format($order['total_amount'], 2); ?></p>
                                </div>
                            </div>
                        </div>

                        <div class="flex-shrink-0 w-full md:w-auto">
                            <button onclick="viewDetails(<?php echo $order['id']; ?>)" 
                                class="w-full bg-black text-white px-10 py-5 rounded-2xl font-bold hover:bg-primary hover:text-black transition-all shadow-xl shadow-black/5 active:scale-95 flex items-center justify-center gap-3">
                                <i class="fa-solid fa-eye text-sm"></i> View Details
                            </button>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="bg-white rounded-[4rem] p-24 text-center shadow-sm border border-gray-100">
                    <div class="w-24 h-24 bg-gray-50 rounded-[2rem] flex items-center justify-center text-gray-200 text-4xl mx-auto mb-8">
                        <i class="fa-solid fa-receipt"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4 font-serif italic">No orders found.</h3>
                    <p class="text-gray-400 max-w-sm mx-auto mb-10 font-light">Your order history is empty. Explore our collection to start shopping.</p>
                    <a href="collections.php" class="inline-flex px-12 py-5 bg-black text-white rounded-2xl font-bold hover:bg-primary hover:text-black transition-all shadow-2xl active:scale-95">
                        Shop Now
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- ORDER DETAILS MODAL -->
<div class="fixed inset-0 z-[2000] hidden items-center justify-center p-6 transition-all duration-500 overflow-hidden" id="orderModal">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-md opacity-0 transition-opacity duration-500" id="modalBackdrop"></div>
    
    <div class="relative bg-white w-full max-w-2xl rounded-[4rem] shadow-2xl overflow-hidden scale-90 opacity-0 transition-all duration-500 flex flex-col max-h-[90vh]" id="modalContent">
        <div class="absolute top-8 right-8 z-20">
            <button onclick="closeModal()" class="w-12 h-12 bg-gray-50 rounded-2xl flex items-center justify-center text-gray-400 hover:bg-red-50 hover:text-red-500 transition-all active:scale-90">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <div class="p-12 md:p-16 overflow-y-auto custom-scrollbar">
            <div class="mb-12">
                <span id="modal-status-badge" class="px-4 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-[0.2em] mb-4 inline-block"></span>
                <h2 class="text-3xl font-bold text-gray-900 font-serif">Order Details <span id="modal-order-id" class="italic text-white"></span></h2>
            </div>
            
            <!-- Timeline -->
            <div class="flex justify-between items-start relative mb-16 pt-4">
                <div class="absolute top-10 left-0 right-0 h-1 bg-gray-50 z-0"></div>
                <div class="absolute top-10 left-0 h-1 bg-emerald-500 transition-all duration-1000 z-1" id="timeline-progress" style="width: 0%"></div>
                
                <?php 
                $statusSteps = [
                    ['id' => 'Pending', 'icon' => 'fa-clock', 'label' => 'Order Placed'],
                    ['id' => 'Processing', 'icon' => 'fa-hammer', 'label' => 'Processing'],
                    ['id' => 'Shipped', 'icon' => 'fa-truck', 'label' => 'Shipped'],
                    ['id' => 'Delivered', 'icon' => 'fa-house-circle-check', 'label' => 'Delivered']
                ];
                foreach($statusSteps as $step):
                ?>
                <div class="flex flex-col items-center gap-4 relative z-10 w-1/4 group" id="step-<?php echo $step['id']; ?>">
                    <div class="w-12 h-12 rounded-2xl bg-white border-4 border-gray-50 flex items-center justify-center text-gray-300 transition-all duration-700 step-icon">
                        <i class="fa-solid <?php echo $step['icon']; ?> text-sm"></i>
                    </div>
                    <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest step-label"><?php echo $step['label']; ?></span>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="space-y-10">
                <div>
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-[0.3em] mb-6 flex items-center gap-4">
                        Items Ordered <div class="flex-grow h-px bg-gray-50"></div>
                    </h3>
                    <div class="space-y-6" id="modal-items">
                        <!-- Items List -->
                    </div>
                </div>

                <div>
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-[0.3em] mb-6 flex items-center gap-4">
                        Delivery Address <div class="flex-grow h-px bg-gray-50"></div>
                    </h3>
                    <div class="bg-gray-50 rounded-3xl p-8 border border-gray-100">
                        <div class="flex gap-6 items-start">
                            <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-white text-xl flex-shrink-0 shadow-sm">
                                <i class="fa-solid fa-map-location-dot"></i>
                            </div>
                            <p class="text-gray-600 leading-relaxed font-light italic" id="modal-address"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.custom-scrollbar::-webkit-scrollbar { width: 4px; }
.custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
.custom-scrollbar::-webkit-scrollbar-thumb { background: #eee; border-radius: 10px; }

#orderModal.modal-active { display: flex; }
</style>

<script>
    <?php if(isset($_GET['success']) && isset($_GET['order_id'])): ?>
        document.addEventListener('DOMContentLoaded', () => { 
            showToast("✅ Your order has been placed successfully.", "success");
            viewDetails(<?php echo (int)$_GET['order_id']; ?>);
        });
    <?php endif; ?>

    function viewDetails(orderId) {
        const modal = document.getElementById('orderModal');
        const backdrop = document.getElementById('modalBackdrop');
        const content = document.getElementById('modalContent');
        
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        
        setTimeout(() => {
            backdrop.style.opacity = '1';
            content.style.opacity = '1';
            content.style.transform = 'scale(1)';
        }, 10);

        fetch('api_get_order.php?id=' + orderId)
            .then(res => res.json())
            .then(data => {
                if(data.status === 'success') {
                    document.getElementById('modal-order-id').innerText = '#' + String(orderId).padStart(6, '0');
                    document.getElementById('modal-address').innerText = data.order.shipping_address;
                    
                    const badge = document.getElementById('modal-status-badge');
                    badge.innerText = data.order.status;
                    badge.className = "px-4 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-[0.2em] mb-4 inline-block ";
                    
                    const statuses = ['Pending', 'Processing', 'Shipped', 'Delivered'];
                    const currentIdx = statuses.indexOf(data.order.status);
                    
                    // Reset timeline
                    statuses.forEach(s => {
                        const step = document.getElementById('step-' + s);
                        const icon = step.querySelector('.step-icon');
                        const label = step.querySelector('.step-label');
                        icon.className = "w-12 h-12 rounded-2xl bg-white border-4 border-gray-50 flex items-center justify-center text-gray-300 transition-all duration-700 step-icon";
                        label.className = "text-[9px] font-bold text-gray-400 uppercase tracking-widest step-label";
                    });

                    // Set progress bar
                    const progress = document.getElementById('timeline-progress');
                    progress.className = "absolute top-10 left-0 h-1 transition-all duration-1000 z-1 bg-emerald-500";
                    progress.style.width = (currentIdx / 3 * 100) + '%';

                    // Highlight steps
                    for(let i=0; i<=currentIdx; i++) {
                        const step = document.getElementById('step-' + statuses[i]);
                        const icon = step.querySelector('.step-icon');
                        const label = step.querySelector('.step-label');
                        
                        if(i < currentIdx) {
                            icon.classList.add('bg-emerald-500', 'border-emerald-100', 'text-white');
                            label.classList.add('text-emerald-500');
                        } else {
                            icon.classList.add('bg-primary', 'border-primary/20', 'text-black', 'scale-110', 'shadow-xl', 'shadow-primary/20');
                            label.classList.add('text-white');
                        }
                    }

                    if(data.order.status == 'Pending') badge.classList.add('bg-amber-50', 'text-amber-600');
                    else if(data.order.status == 'Processing') badge.classList.add('bg-blue-50', 'text-blue-600');
                    else if(data.order.status == 'Shipped') badge.classList.add('bg-purple-50', 'text-purple-600');
                    else badge.classList.add('bg-emerald-50', 'text-emerald-600');
                    
                    let itemsHtml = '';
                    data.items.forEach(item => {
                        itemsHtml += `
                            <div class="flex justify-between items-center group/item">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 bg-gray-50 rounded-xl flex items-center justify-center text-[10px] font-bold text-gray-400 border border-gray-100 group-hover/item:border-primary/20 transition">
                                        ${item.quantity}x
                                    </div>
                                    <span class="text-sm font-bold text-gray-900 group-hover/item:text-white transition">${item.name}</span>
                                </div>
                                <span class="text-sm font-bold text-gray-900 font-serif">₹${Number(item.price).toLocaleString()}</span>
                            </div>
                        `;
                    });
                    
                    itemsHtml += `
                        <div class="pt-8 mt-4 border-t border-dashed border-gray-100 flex justify-between items-end">
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Total Amount</span>
                            <span class="text-3xl font-bold text-gray-900 font-serif">₹${Number(data.order.total_amount).toLocaleString()}</span>
                        </div>
                    `;
                    document.getElementById('modal-items').innerHTML = itemsHtml;
                } else {
                    showToast(data.message || "Error exploring journey", "error");
                }
            });
    }

    function closeModal() {
        const modal = document.getElementById('orderModal');
        const backdrop = document.getElementById('modalBackdrop');
        const content = document.getElementById('modalContent');
        
        backdrop.style.opacity = '0';
        content.style.opacity = '0';
        content.style.transform = 'scale(0.9)';
        
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 500);
    }
</script>

<?php include '../includes/footer.php'; ?>
