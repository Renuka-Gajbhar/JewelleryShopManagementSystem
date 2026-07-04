<?php 
require_once '../includes/Config.php';
include '../includes/header.php'; 
?>

<div class="bg-gray-50 py-24 min-h-screen">
    <div class="max-w-[1400px] mx-auto px-8">
        <div class="max-w-4xl mx-auto text-center mb-20">
            <span class="text-white font-bold uppercase tracking-[0.4em] text-xs mb-4 block">Concierge & Support</span>
            <h1 class="text-4xl md:text-5xl font-serif font-bold text-gray-900 mb-8 leading-tight">We are here to <span class="italic text-[#d4af37]">Help</span></h1>
            <p class="text-gray-400 font-light text-lg leading-relaxed max-w-2xl mx-auto">
                Whether you're looking for a custom piece or have questions about our collections, our team is here to assist you.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-start">
            <!-- Contact details -->
            <div class="lg:col-span-5 space-y-12">
                <div class="bg-white rounded-[3rem] p-12 shadow-sm border border-gray-100 group hover:shadow-2xl transition duration-700">
                    <div class="flex items-start gap-8">
                        <div class="w-16 h-16 bg-primary/10 rounded-2xl flex items-center justify-center text-white text-2xl group-hover:bg-primary group-hover:text-white transition duration-500">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-3 font-serif italic">Our Store</h3>
                            <p class="text-gray-400 leading-relaxed font-light">Near Busstand, Basmath-431512<br>Maharashtra, India</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-[3rem] p-12 shadow-sm border border-gray-100 group hover:shadow-2xl transition duration-700">
                    <div class="flex items-start gap-8">
                        <div class="w-16 h-16 bg-primary/10 rounded-2xl flex items-center justify-center text-white text-2xl group-hover:bg-primary group-hover:text-white transition duration-500">
                            <i class="fa-solid fa-phone"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-3 font-serif italic">Call Us</h3>
                            <p class="text-gray-400 leading-relaxed font-light">+91 82628 86250<br><span class="text-xs uppercase tracking-widest font-bold mt-2 inline-block">Mon-Sat, 10am - 8pm</span></p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-[3rem] p-12 shadow-sm border border-gray-100 group hover:shadow-2xl transition duration-700">
                    <div class="flex items-start gap-8">
                        <div class="w-16 h-16 bg-primary/10 rounded-2xl flex items-center justify-center text-white text-2xl group-hover:bg-primary group-hover:text-white transition duration-500">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-3 font-serif italic">Email Us</h3>
                            <p class="text-gray-400 leading-relaxed font-light">shinejwellery@gmail.com<br><span class="text-xs uppercase tracking-widest font-bold mt-2 inline-block">24/7 Response Guaranteed</span></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact form -->
            <div class="lg:col-span-7">
                <div class="bg-white rounded-[4rem] p-12 md:p-16 shadow-2xl border border-gray-50 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-primary/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
                    
                    <form onsubmit="sendMessage(event)" class="relative z-10 space-y-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="group">
                                <label class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3 block group-focus-within:text-white transition">Full Name</label>
                                <input type="text" id="name" required placeholder="Full Name" 
                                    class="w-full bg-gray-50 border-none rounded-2xl py-4 px-6 focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all outline-none">
                            </div>
                            <div class="group">
                                <label class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3 block group-focus-within:text-white transition">Email Address</label>
                                <input type="email" id="email" required placeholder="name@luxury.com" 
                                    class="w-full bg-gray-50 border-none rounded-2xl py-4 px-6 focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all outline-none">
                            </div>
                        </div>

                        <div class="group">
                            <label class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3 block group-focus-within:text-white transition">Interested Collection</label>
                            <input type="text" id="product" placeholder="e.g. Diamond Necklace" 
                                class="w-full bg-gray-50 border-none rounded-2xl py-4 px-6 focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all outline-none">
                        </div>

                        <div class="group">
                            <label class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3 block group-focus-within:text-white transition">Your Message</label>
                            <textarea id="feedback" required rows="5" placeholder="How may we assist you today?" 
                                class="w-full bg-gray-50 border-none rounded-2xl py-4 px-6 focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all outline-none resize-none"></textarea>
                        </div>

                        <div class="pt-6">
                            <button type="submit" class="w-full bg-black text-white py-6 rounded-3xl font-bold text-lg hover:bg-primary hover:text-black transition-all shadow-2xl shadow-black/10 flex items-center justify-center gap-4 group active:scale-95">
                                Send Inquiry <i class="fa-solid fa-paper-plane text-sm group-hover:translate-x-1 group-hover:-translate-y-1 transition duration-300"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function sendMessage(event) {
  event.preventDefault();

  let name = document.getElementById("name").value;
  let email = document.getElementById("email").value;
  let product = document.getElementById("product").value;
  let feedback = document.getElementById("feedback").value;

  let ownerEmail = "renukagajbhar82@gmail.com"; 

  let subject = "New Contact Message - Shine Jewellery Shop";
  let body =
    "Customer Name: " + name + "%0D%0A" +
    "Email: " + email + "%0D%0A" +
    "Product Interest: " + product + "%0D%0A" +
    "Message: " + feedback;

  window.location.href = `mailto:${ownerEmail}?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`;
  
  showToast("✅ Inquiry drafted successfully. Opening your mail client...", "success");
}
</script>

<?php include '../includes/footer.php'; ?>
