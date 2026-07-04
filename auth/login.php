<?php
require_once '../includes/Config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_role'] = $user['role'];
            
            if ($user['role'] === 'admin') {
                header("Location: " . BASE_URL . "admin/dashboard.php");
            } else {
                header("Location: " . BASE_URL . "index.php");
            }
            exit();
        } else {
            $error = "Incorrect credentials. Please try again.";
        }
    } else {
        $error = "No account found with this email.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Shine Jewellers</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Outfit', sans-serif; background-color: #fcfcfc; }
    </style>
</head>
<body class="bg-slate-50 h-screen overflow-hidden flex items-center justify-center p-4">

    <div class="max-w-[450px] w-full bg-white rounded-[3rem] shadow-2xl overflow-hidden relative z-10 border border-white p-10 ">
        <div class="mb-5 text-center">
            <h1 class="text-3xl font-bold text-slate-900 mb-2">Sign In</h1>
            <p class="text-slate-400">Enter your details to access your account</p>
        </div>

        <?php if(isset($_GET['registered'])): ?>
            <div class="bg-emerald-50 text-emerald-600 px-6 py-4 rounded-xl mb-8 border border-emerald-100 flex items-center gap-3">
                <i class="fa-solid fa-circle-check"></i>
                <span class="text-[10px] font-bold uppercase tracking-widest">Account created! Please login.</span>
            </div>
        <?php endif; ?>

        <?php if(isset($error)): ?>
            <div class="bg-red-50 text-red-600 px-6 py-4 rounded-xl mb-8 border border-red-100 flex items-center gap-3">
                <i class="fa-solid fa-circle-exclamation"></i>
                <span class="text-[10px] font-bold uppercase tracking-widest"><?php echo $error; ?></span>
            </div>
        <?php endif; ?>

        <form action="" method="POST" class="space-y-6">
            <div>
                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 block">Email Address</label>
                <input type="email" name="email" required placeholder="name@example.com" 
                    class="w-full bg-slate-50 border-none rounded-2xl py-5 px-8 focus:ring-2 focus:ring-slate-200 focus:bg-white transition-all outline-none font-medium text-sm">
            </div>

            <div>
                <div class="flex justify-between items-center mb-2">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block">Password</label>
                    <a href="#" class="text-[10px] font-bold text-white uppercase tracking-widest">Forgot?</a>
                </div>
                <input type="password" name="password" required placeholder="••••••••" 
                    class="w-full bg-slate-50 border-none rounded-2xl py-5 px-8 focus:ring-2 focus:ring-slate-200 focus:bg-white transition-all outline-none font-medium text-sm">
            </div>

            <button type="submit" class="w-full bg-slate-900 text-white py-3 rounded-2xl font-bold text-xs uppercase tracking-widest hover:bg-black transition-all shadow-xl active:scale-[0.98] mt-4">
                Sign In
            </button>
        </form>

        <div class="mt-5 text-center pt-4 border-t border-slate-50">
            <p class="text-slate-400 text-[10px] font-bold uppercase tracking-[0.2em]">
                Don't have an account? 
                <a href="register.php" class="text-white hover:text-slate-900 transition ml-2">Create Account</a>
            </p>
        </div>
    </div>

</body>
</html>
