<?php 
require_once dirname(__FILE__) . '/Config.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start(); 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shine Jewellers | Premium Collections</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #fcfcfc;
            color: #1a1a1a;
            overflow-x: hidden;
        }

        h1, h2, h3, .logo {
            font-family: 'Playfair Display', serif;
        }

        header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.05);
            border-bottom: 1px solid rgba(212, 175, 55, 0.1);
        }

        .nav-container {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 2rem;
        }

        .logo-section {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .logo-text {
            font-size: 1.8rem;
            font-weight: 700;
            background: linear-gradient(45deg, #d4af37, #b8860b);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -0.5px;
        }

        .search-wrapper {
            position: relative;
            flex: 1;
            max-width: 500px;
            margin: 0 2rem;
        }

        .search-bar {
            display: flex;
            background: #f3f4f6;
            border-radius: 50px;
            padding: 4px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 2px solid transparent;
        }

        .search-bar:focus-within {
            background: #fff;
            border-color: #d4af37;
            box-shadow: 0 0 0 4px rgba(212, 175, 55, 0.1);
        }

        .search-select {
            background: transparent;
            padding: 0 15px;
            border-right: 1px solid #e5e7eb;
            outline: none;
            font-size: 0.9rem;
            color: #666;
            cursor: pointer;
        }

        .search-input {
            flex: 1;
            background: transparent;
            border: none;
            padding: 8px 15px;
            outline: none;
            font-size: 0.95rem;
        }

        .search-btn {
            background: #d4af37;
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .search-btn:hover {
            background: #b8860b;
            transform: scale(1.05);
        }

        .suggestions-box {
            position: absolute;
            top: 110%;
            left: 0;
            right: 0;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            display: none;
            overflow: hidden;
            z-index: 1001;
            border: 1px solid #eee;
        }

        .suggestion-item {
            padding: 10px 15px;
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .suggestion-item:hover {
            background: #f9f9f9;
        }

        .suggestion-item img {
            width: 40px;
            height: 40px;
            border-radius: 6px;
            object-fit: cover;
        }

        .nav-links {
            display: flex;
            gap: 1.5rem;
            align-items: center;
        }

        .nav-item {
            color: #4b5563;
            font-size: 1.2rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }

        .nav-item:hover {
            color: #d4af37;
        }

        /* Profile Dropdown */
        .profile-container {
            position: relative;
        }

        .profile-menu {
            position: absolute;
            top: 150%;
            right: 0;
            width: 280px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            padding: 1.5rem;
            display: none;
            animation: slideDown 0.3s ease-out;
            z-index: 1100;
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .show-menu {
            display: block;
        }

        /* Mobile Menu - simplistic for now */
        @media (max-width: 768px) {
            .search-wrapper { display: none; }
            .nav-container { padding: 1rem; }
        }
    </style>
</head>
<body>
    <header>
        <div class="nav-container">
            <a href="<?php echo BASE_URL; ?>index.php" class="logo-section">
                <img src="<?php echo BASE_URL; ?>images/imageshine.png" alt="Logo" class="w-10 h-10 object-contain">
                <span class="logo-text">Shine</span>
            </a>

            <div class="search-wrapper">
                <form action="<?php echo BASE_URL; ?>user/collections.php" method="GET" class="search-bar">
                    <select class="search-select" name="category">
                        <option value="">All Categories</option>
                        <?php 
                        $header_cats = mysqli_query($conn, "SELECT name FROM categories ORDER BY name ASC");
                        while($hc = mysqli_fetch_assoc($header_cats)): 
                        ?>
                            <option value="<?php echo htmlspecialchars($hc['name']); ?>"><?php echo htmlspecialchars($hc['name']); ?></option>
                        <?php endwhile; ?>
                    </select>
                    <input type="text" name="search" id="searchInput" class="search-input" placeholder="Search premium jewellery..." autocomplete="off">
                    <button type="submit" class="search-btn">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </form>
                <div id="suggestionsBox" class="suggestions-box"></div>
            </div>

            <nav class="nav-links">
                <a href="<?php echo BASE_URL; ?>index.php" class="nav-item" title="Home"><i class="fa-solid fa-house"></i></a>
                <a href="<?php echo BASE_URL; ?>user/collections.php" class="nav-item" title="Collections"><i class="fa-solid fa-gem"></i></a>
                <a href="<?php echo BASE_URL; ?>user/card.php" class="nav-item relative" title="Cart">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span id="cart-count" class="absolute -top-2 -right-2 bg-red-500 text-white text-[10px] w-4 h-4 rounded-full flex items-center justify-center hidden">0</span>
                </a>
                <div class="profile-container">
                    <button onclick="toggleProfileMenu()" class="nav-item focus:outline-none">
                        <i class="fa-solid fa-circle-user"></i>
                    </button>
                    <div id="profileMenu" class="profile-menu">
                        <?php if(isset($_SESSION['user_id'])): ?>
                            <div class="flex items-center gap-4 mb-4 pb-4 border-bottom">
                                <img src="<?php echo BASE_URL; ?>images/Renu.jpeg" class="w-12 h-12 rounded-full object-cover border-2 border-[#d4af37]" alt="Profile">
                                <div>
                                    <p class="font-bold text-gray-800"><?php echo htmlspecialchars($_SESSION['user_name']); ?></p>
                                    <p class="text-xs text-gray-500"><?php echo htmlspecialchars($_SESSION['user_email']); ?></p>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <a href="<?php echo BASE_URL; ?>user/profile.php" class="flex items-center gap-3 p-2 hover:bg-gray-50 rounded-lg transition">
                                    <i class="fa-solid fa-user-gear text-white"></i> My Profile
                                </a>
                                <a href="<?php echo BASE_URL; ?>user/ordertrack.php" class="flex items-center gap-3 p-2 hover:bg-gray-50 rounded-lg transition">
                                    <i class="fa-solid fa-box text-white"></i> Track Order
                                </a>
                                <?php if($_SESSION['user_role'] === 'admin'): ?>
                                    <a href="<?php echo BASE_URL; ?>admin/dashboard.php" class="flex items-center gap-3 p-2 bg-blue-50 text-blue-700 rounded-lg transition">
                                        <i class="fa-solid fa-gauge"></i> Admin Dashboard
                                    </a>
                                <?php endif; ?>
                                <hr class="my-2 border-gray-100">
                                <a href="<?php echo BASE_URL; ?>auth/logout.php" class="flex items-center gap-3 p-2 text-red-600 hover:bg-red-50 rounded-lg transition">
                                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                                </a>
                            </div>
                        <?php else: ?>
                            <div class="text-center">
                                <div class="mb-4 text-gray-400"><i class="fa-solid fa-user-circle text-5xl"></i></div>
                                <h4 class="font-bold text-lg mb-2">Join Shine Jewellers</h4>
                                <p class="text-sm text-gray-500 mb-4">Login to track orders and save your favorites.</p>
                                <a href="<?php echo BASE_URL; ?>auth/login.php" class="block w-full bg-[#d4af37] text-white py-2 rounded-lg font-semibold hover:bg-[#b8860b] transition mb-2">Login</a>
                                <a href="<?php echo BASE_URL; ?>auth/register.php" class="block w-full bg-gray-100 text-gray-800 py-2 rounded-lg font-semibold hover:bg-gray-200 transition">Register</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <div id="toast-container" class="fixed bottom-6 right-6 z-[9999] flex flex-col gap-3"></div>

    <script>
        const BASE_URL = '<?php echo BASE_URL; ?>';

        function toggleProfileMenu() {
            document.getElementById('profileMenu').classList.toggle('show-menu');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            const profile = document.querySelector('.profile-container');
            if (profile && !profile.contains(e.target)) {
                document.getElementById('profileMenu').classList.remove('show-menu');
            }
            const suggestionsBox = document.getElementById('suggestionsBox');
            if (suggestionsBox && !document.getElementById('searchInput').contains(e.target)) {
                suggestionsBox.style.display = 'none';
            }
        });

        // Search Suggestions logic
        const searchInput = document.getElementById('searchInput');
        const suggestionsBox = document.getElementById('suggestionsBox');

        if(searchInput) {
            searchInput.addEventListener('input', async function() {
                const query = this.value.trim();
                if (query.length < 2) {
                    suggestionsBox.style.display = 'none';
                    return;
                }

                try {
                    const res = await fetch(`${BASE_URL}includes/search_suggestions.php?q=${encodeURIComponent(query)}`);
                    const data = await res.json();

                    if (data.length > 0) {
                        suggestionsBox.innerHTML = data.map(item => `
                            <div class="suggestion-item" onclick="window.location.href='${BASE_URL}user/productdetail.php?name=${encodeURIComponent(item.name)}'">
                                <img src="${BASE_URL}${item.image_url}" onerror="this.src='${BASE_URL}images/download.png'">
                                <div>
                                    <div class="text-sm font-semibold">${item.name}</div>
                                    <div class="text-xs text-white">₹${new Intl.NumberFormat('en-IN').format(item.price)}</div>
                                </div>
                            </div>
                        `).join('');
                        suggestionsBox.style.display = 'block';
                    } else {
                        suggestionsBox.style.display = 'none';
                    }
                } catch (err) {
                    console.error('Search error:', err);
                }
            });
        }

        // Global Toast Notification
        function showToast(message, type = 'success') {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            const icons = {
                success: 'fa-circle-check',
                error: 'fa-circle-exclamation',
                warning: 'fa-triangle-exclamation'
            };
            const bgColors = {
                success: 'bg-emerald-500',
                error: 'bg-red-500',
                warning: 'bg-amber-500'
            };

            toast.className = `${bgColors[type] || 'bg-gray-800'} text-white px-6 py-4 rounded-xl shadow-2xl flex items-center gap-3 animate-bounce-in transform transition-all duration-300`;
            toast.innerHTML = `<i class="fa-solid ${icons[type]} text-xl"></i> <span class="font-medium">${message}</span>`;
            
            container.appendChild(toast);

            setTimeout(() => {
                toast.classList.add('opacity-0', 'translate-y-4');
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        // Helper for cart updates
        function updateCartCount() {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            const countEl = document.getElementById('cart-count');
            if(countEl) {
                countEl.textContent = cart.length;
                countEl.classList.toggle('hidden', cart.length === 0);
            }
        }
        updateCartCount();

        function addToCart(id, name, price, image) {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            let existingItem = cart.find(item => item.id === id);
            if (existingItem) {
                existingItem.qty = (existingItem.qty || 1) + 1;
            } else {
                cart.push({ id, name, price, image, qty: 1 });
            }
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartCount();
            showToast(`${name} added to cart!`);
        }
    </script>
