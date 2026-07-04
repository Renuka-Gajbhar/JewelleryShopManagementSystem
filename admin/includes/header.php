<?php
require_once '../includes/Config.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: " . BASE_URL . "auth/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shine | Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
        .sidebar-link.active {
            background: linear-gradient(90deg, rgba(212, 175, 55, 0.1) 0%, rgba(212, 175, 55, 0) 100%);
            border-right: 4px solid #d4af37;
            color: #d4af37 !important;
        }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
        
        .toast-container { position: fixed; bottom: 2rem; right: 2rem; z-index: 9999; display: flex; flex-direction: column; gap: 0.75rem; }
        .toast { padding: 1rem 1.5rem; border-radius: 1rem; color: white; font-weight: 600; display: flex; align-items: center; gap: 0.75rem; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); animation: slideIn 0.3s ease-out forwards; }
        .toast.success { background-color: #059669; }
        .toast.error { background-color: #dc2626; }
        @keyframes slideIn { from { opacity: 0; transform: translateX(20px); } to { opacity: 1; transform: translateX(0); } }
    </style>
</head>
<body class="flex overflow-hidden h-screen">
    <!-- Sidebar -->
    <aside class="w-72 bg-white border-r border-slate-200 flex flex-col hidden lg:flex">
        <div class="p-8 border-b border-slate-50">
            <h1 class="text-2xl font-serif font-bold text-slate-900 flex items-center gap-3">
                <i class="fa-solid fa-gem text-white"></i> Shine <span class="text-xs uppercase tracking-widest text-slate-400 font-sans ml-2">Admin</span>
            </h1>
        </div>
        
        <nav class="flex-1 p-6 space-y-2 overflow-y-auto custom-scrollbar">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-4 px-4">Main Menu</p>
            
            <a href="dashboard.php" class="sidebar-link flex items-center gap-4 px-4 py-3 rounded-2xl text-slate-500 font-medium hover:bg-slate-50 transition-all <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active text-white' : ''; ?>">
                <i class="fa-solid fa-chart-line"></i> Dashboard
            </a>
            
            <a href="manage_categories.php" class="sidebar-link flex items-center gap-4 px-4 py-3 rounded-2xl text-slate-500 font-medium hover:bg-slate-50 transition-all <?php echo basename($_SERVER['PHP_SELF']) == 'manage_categories.php' ? 'active text-white' : ''; ?>">
                <i class="fa-solid fa-shapes"></i> Categories
            </a>
            
            <a href="manage_products.php" class="sidebar-link flex items-center gap-4 px-4 py-3 rounded-2xl text-slate-500 font-medium hover:bg-slate-50 transition-all <?php echo basename($_SERVER['PHP_SELF']) == 'manage_products.php' ? 'active text-white' : ''; ?>">
                <i class="fa-solid fa-gem"></i> Products
            </a>
            
            <a href="manage_orders.php" class="sidebar-link flex items-center gap-4 px-4 py-3 rounded-2xl text-slate-500 font-medium hover:bg-slate-50 transition-all <?php echo basename($_SERVER['PHP_SELF']) == 'manage_orders.php' ? 'active text-white' : ''; ?>">
                <i class="fa-solid fa-receipt"></i> Orders
            </a>
            
            <a href="manage_users.php" class="sidebar-link flex items-center gap-4 px-4 py-3 rounded-2xl text-slate-500 font-medium hover:bg-slate-50 transition-all <?php echo basename($_SERVER['PHP_SELF']) == 'manage_users.php' ? 'active text-white' : ''; ?>">
                <i class="fa-solid fa-users"></i> Customers
            </a>

            <div class="pt-8 space-y-2">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-4 px-4">Links</p>
                <a href="../index.php" class="flex items-center gap-4 px-4 py-3 rounded-2xl text-slate-500 font-medium hover:bg-blue-50 hover:text-blue-600 transition-all">
                    <i class="fa-solid fa-globe"></i> View Website
                </a>
                <a href="../auth/logout.php" class="flex items-center gap-4 px-4 py-3 rounded-2xl text-slate-500 font-medium hover:bg-red-50 hover:text-red-600 transition-all">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </a>
            </div>
        </nav>

        <div class="p-8 border-t border-slate-50">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-slate-900 flex items-center justify-center text-white font-bold text-xl">
                    <?php echo strtoupper(substr($_SESSION['user_name'], 0, 1)); ?>
                </div>
                <div>
                    <p class="text-sm font-bold text-slate-900"><?php echo htmlspecialchars($_SESSION['user_name']); ?></p>
                    <p class="text-[10px] font-bold text-white uppercase tracking-widest">Administrator</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Top Navigation -->
        <header class="h-24 bg-white border-b border-slate-200 px-8 flex items-center justify-between flex-shrink-0">
            <div class="flex items-center gap-4">
                <button class="lg:hidden w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-500">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <h2 class="text-xl font-bold text-slate-900">
                    <?php 
                        $page = basename($_SERVER['PHP_SELF'], ".php");
                        echo ucwords(str_replace(['manage_', 'dashboard'], ['', 'Dashboard'], $page));
                    ?>
                </h2>
            </div>
            
            <div class="flex items-center gap-6">
                <div class="hidden md:flex flex-col text-right">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-[0.2em]"><?php echo date('l, d M Y'); ?></p>
                </div>
                <div class="w-px h-8 bg-slate-200"></div>
                <button class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-500 hover:bg-slate-100 transition">
                    <i class="fa-solid fa-bell text-sm"></i>
                </button>
            </div>
        </header>

        <!-- Dynamic Content -->
        <main class="flex-1 overflow-y-auto p-8 custom-scrollbar">
            <div id="toast-container" class="toast-container"></div>
            <script>
                function showToast(message, type = 'success') {
                    const container = document.getElementById('toast-container');
                    const toast = document.createElement('div');
                    toast.className = `toast ${type}`;
                    toast.innerHTML = `<i class="fa-solid ${type === 'success' ? 'fa-circle-check' : 'fa-circle-exclamation'}"></i> ${message}`;
                    container.appendChild(toast);
                    setTimeout(() => {
                        toast.style.opacity = '0';
                        toast.style.transform = 'translateY(10px)';
                        setTimeout(() => toast.remove(), 300);
                    }, 4000);
                }
            </script>
