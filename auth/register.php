<?php
require_once '../includes/Config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $role = ($email === 'admin@gmail.com') ? 'admin' : 'user';

    // Check if email already exists
    $checkEmail = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $checkEmail);
    
    if (mysqli_num_rows($result) > 0) {
        $error = "This email is already registered.";
    } else {
        $profile_pic = 'default_profile.png';
        if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
            $upload_dir = '../uploads/profiles/';
            if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);
            $filename = uniqid() . '_' . basename($_FILES['profile_pic']['name']);
            if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $upload_dir . $filename)) {
                $profile_pic = 'uploads/profiles/' . $filename;
            }
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $insertQuery = "INSERT INTO users (name, email, password, phone, role, profile_pic) VALUES ('$name', '$email', '$hashed_password', '$phone', '$role', '$profile_pic')";
        
        if (mysqli_query($conn, $insertQuery)) {
            header("Location: login.php?registered=true");
            exit();
        } else {
            $error = "Registration failed. Please try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account | Shine Jewellers</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Outfit', sans-serif; background-color: #fcfcfc; }
    </style>
</head>
<body class="bg-slate-50 h-screen overflow-hidden flex items-center justify-center">

    <!-- Luxury Backdrops -->
    <div class="absolute top-0 right-0 w-[800px] h-[800px] bg-primary/5 rounded-full blur-[120px] translate-x-1/2 -translate-y-1/2 opacity-60"></div>
    <div class="absolute bottom-0 left-0 w-[600px] h-[600px] bg-primary/10 rounded-full blur-[100px] -translate-x-1/4 translate-y-1/4 opacity-40"></div>

    <div class="max-w-[550px] w-full bg-white rounded-[3rem] shadow-2xl overflow-hidden relative z-10 border border-white p-8 md:p-12">
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-slate-900 mb-1">Create Account</h1>
            <p class="text-slate-400 text-sm">Join Shine Jewellers today</p>
        </div>

        <?php if(isset($error)): ?>
            <div class="bg-red-50 text-red-600 px-6 py-3 rounded-2xl mb-6 flex items-center gap-4 border border-red-100 shadow-sm transition-all">
                <i class="fa-solid fa-circle-exclamation text-sm"></i>
                <span class="text-[11px] font-bold uppercase tracking-widest"><?php echo $error; ?></span>
            </div>
        <?php endif; ?>

        <form action="" method="POST" enctype="multipart/form-data" class="space-y-4">
            <div class="flex justify-center mb-2">
                <div class="relative group/pic">
                    <div class="w-16 h-16 rounded-full bg-slate-100 border-2 border-dashed border-slate-200 flex items-center justify-center overflow-hidden transition-all group-hover/pic:border-primary">
                        <img id="preview" src="https://ui-avatars.com/api/?name=User&background=f1f5f9&color=64748b" class="w-full h-full object-cover hidden">
                        <i id="placeholder" class="fa-solid fa-camera text-xl text-slate-300 group-hover/pic:text-white"></i>
                    </div>
                    <input type="file" name="profile_pic" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer" onchange="previewImage(this)">
                    <div class="absolute -bottom-1 -right-1 bg-primary text-black shadow-md border border-white rounded-full w-6 h-6 flex items-center justify-center text-[10px]">
                        <i class="fa-solid fa-plus font-bold text-[8px]"></i>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="group">
                    <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1.5 block">Full Name</label>
                    <input type="text" name="name" required placeholder="John Doe" 
                        class="w-full bg-slate-50 border-none rounded-xl py-3 px-5 focus:ring-2 focus:ring-slate-200 focus:bg-white transition-all outline-none font-medium text-sm">
                </div>

                <div class="group">
                    <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1.5 block">Email Address</label>
                    <input type="email" name="email" required placeholder="john@example.com" 
                        class="w-full bg-slate-50 border-none rounded-xl py-3 px-5 focus:ring-2 focus:ring-slate-200 focus:bg-white transition-all outline-none font-medium text-sm">
                </div>

                <div class="group">
                    <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1.5 block">Phone Number</label>
                    <input type="tel" name="phone" required placeholder="+91 00000 00000" 
                        class="w-full bg-slate-50 border-none rounded-xl py-3 px-5 focus:ring-2 focus:ring-slate-200 focus:bg-white transition-all outline-none font-medium text-sm">
                </div>

                <div class="group">
                    <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1.5 block">Password</label>
                    <input type="password" name="password" required placeholder="••••••••" 
                        class="w-full bg-slate-50 border-none rounded-xl py-3 px-5 focus:ring-2 focus:ring-slate-200 focus:bg-white transition-all outline-none font-medium text-sm">
                </div>
            </div>

            <button type="submit" class="w-full bg-slate-900 text-white py-4 rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-black transition-all shadow-xl active:scale-[0.98] mt-2">
                Create Account
            </button>
        </form>

        <div class="mt-6 text-center pt-4 border-t border-slate-50">
            <p class="text-slate-400 text-[10px] font-bold uppercase tracking-[0.2em]">
                Already have an account? 
                <a href="login.php" class="text-white hover:text-slate-900 transition ml-2">Sign In</a>
            </p>
        </div>
    </div>

    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview').src = e.target.result;
                    document.getElementById('preview').classList.remove('hidden');
                    document.getElementById('placeholder').classList.add('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

</body>
</html>
