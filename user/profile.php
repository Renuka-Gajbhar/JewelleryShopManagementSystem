<?php 
require_once '../includes/Config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: " . BASE_URL . "auth/login.php");
    exit();
}

// Fetch user data including profile pic
$user_id = $_SESSION['user_id'];
$user_res = mysqli_query($conn, "SELECT * FROM users WHERE id=$user_id");
$user = mysqli_fetch_assoc($user_res);

include '../includes/header.php'; 
?>

<div class="bg-gray-50/50 py-16 min-h-screen">
    <div class="max-w-4xl mx-auto px-6">
        <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
            <!-- Header -->
            <div class="bg-slate-900 p-12 text-center">
                <div class="relative inline-block">
                    <div class="w-32 h-32 rounded-full border-4 border-white shadow-lg overflow-hidden bg-gray-100 mx-auto">
                        <img src="<?php echo BASE_URL . ($user['profile_pic'] ?? 'images/imageshine.png'); ?>" class="w-full h-full object-cover" alt="Profile">
                    </div>
                </div>
                <h1 class="text-2xl font-bold text-white mt-4"><?php echo htmlspecialchars($user['name']); ?></h1>
                <p class="text-slate-400 text-xs uppercase tracking-widest mt-1">Customer Profile</p>
            </div>

            <!-- Details -->
            <div class="p-12 space-y-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Email Address</label>
                        <p class="text-slate-900 font-medium"><?php echo htmlspecialchars($user['email']); ?></p>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Phone Number</label>
                        <p class="text-slate-900 font-medium"><?php echo htmlspecialchars($user['phone'] ?? 'Not provided'); ?></p>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Location</label>
                        <p class="text-slate-900 font-medium">India</p>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Member Since</label>
                        <p class="text-slate-900 font-medium"><?php echo date('F Y', strtotime($user['created_at'])); ?></p>
                    </div>
                </div>

                <div class="pt-8 border-t border-gray-50 flex flex-wrap gap-4">
                    <a href="ordertrack.php" class="bg-slate-900 text-white px-8 py-4 rounded-xl font-bold text-sm hover:bg-black transition flex items-center gap-2">
                        <i class="fa-solid fa-box-open"></i> My Orders
                    </a>
                    <a href="#" class="bg-slate-50 text-slate-600 px-8 py-4 rounded-xl font-bold text-sm hover:bg-slate-100 transition flex items-center gap-2 border border-slate-100">
                        <i class="fa-solid fa-user-gear"></i> Edit Profile
                    </a>
                    <a href="<?php echo BASE_URL; ?>auth/logout.php" class="bg-red-50 text-red-600 px-8 py-4 rounded-xl font-bold text-sm hover:bg-red-600 hover:text-white transition flex items-center gap-2 border border-red-100">
                        <i class="fa-solid fa-right-from-bracket"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>