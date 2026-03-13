<?php
$currentPage = 'merch';
$pageTitle = 'Shop';
$metaDescription = 'Official Darren Connell merchandise. Tour t-shirts, Glasgow humor magnets, banter mugs and more.';
?>
<!DOCTYPE html>
<html class="dark" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<?php require __DIR__ . '/../includes/meta-stitch.php'; ?>
<title>Darren Connell Shop - Official Merchandise</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet"/>
<script id="tailwind-config">
    tailwind.config = {
        darkMode: "class",
        theme: {
            extend: {
                colors: {
                    "primary": "#f46a25",
                    "background-light": "#f8f6f5",
                    "background-dark": "#221610",
                },
                fontFamily: { "display": ["Space Grotesk"] },
                borderRadius: {"DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px"},
            },
        },
    }
</script>
<style>
    body { font-family: 'Space Grotesk', sans-serif; min-height: max(884px, 100dvh); }
    .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; font-family: 'Material Symbols Outlined'; font-weight: normal; font-style: normal; display: inline-block; line-height: 1; }
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>
</head>
<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 antialiased">
<?php require __DIR__ . '/../includes/navbar-stitch.php'; ?>
<div class="relative flex min-h-screen w-full flex-col overflow-x-hidden">
<!-- Category Tabs -->
<nav class="bg-background-light dark:bg-background-dark border-b border-primary/10">
<div class="flex px-4 gap-6 overflow-x-auto no-scrollbar">
<a class="flex flex-col items-center justify-center border-b-2 border-primary text-primary pb-3 pt-4 whitespace-nowrap" href="#">
<span class="text-sm font-bold">All Items</span>
</a>
<a class="flex flex-col items-center justify-center border-b-2 border-transparent text-slate-500 dark:text-slate-400 pb-3 pt-4 whitespace-nowrap hover:text-primary transition-colors" href="#">
<span class="text-sm font-bold">Tour Apparel</span>
</a>
<a class="flex flex-col items-center justify-center border-b-2 border-transparent text-slate-500 dark:text-slate-400 pb-3 pt-4 whitespace-nowrap hover:text-primary transition-colors" href="#">
<span class="text-sm font-bold">Banter Mugs</span>
</a>
<a class="flex flex-col items-center justify-center border-b-2 border-transparent text-slate-500 dark:text-slate-400 pb-3 pt-4 whitespace-nowrap hover:text-primary transition-colors" href="#">
<span class="text-sm font-bold">Glasgow Humor</span>
</a>
</div>
</nav>
<main id="main-content" class="flex-1">
<!-- Featured Tour Merch -->
<section class="p-4">
<h1 class="text-slate-900 dark:text-slate-100 text-2xl font-bold leading-tight mb-4">Tour Merchandise</h1>
<div class="@container">
<div class="flex flex-col items-stretch justify-start rounded-xl @xl:flex-row @xl:items-start overflow-hidden border border-primary/10 bg-primary/5">
<div class="w-full bg-center bg-no-repeat aspect-square @xl:aspect-video bg-cover" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuAf9wbGAXxz4De4SK03As0NAInpUEBDrE_hNIEDEt_Zkptx9skUU4HK7KWKMBHzAZ1nKhmak164465u7jnrXgO01PAYT12uSnFnQQ-bf8-q1Xz3krJZBZkpE4R9J-vJJtu7wxljkTatTbmfTCMMrwsTeoOCDXLoAFTG__wmfeDs5r1342EABpQWH9H8YLuwR_kreqBn31tdjoPfmjVk7Gy4Zbc820mzLdzofz_IW7RnLN54CaWUJXFmHKUWeNzP0Wt1-5K_gzmOnyw");'></div>
<div class="flex w-full min-w-72 grow flex-col items-stretch justify-center gap-2 p-6">
<div class="flex justify-between items-start">
<div>
<span class="inline-block px-2 py-1 rounded bg-primary/20 text-primary text-[10px] font-bold uppercase tracking-wider mb-2">Best Seller</span>
<h3 class="text-slate-900 dark:text-slate-100 text-2xl font-bold leading-tight">'Banter' 2024 Tour Tee</h3>
</div>
<p class="text-primary text-xl font-bold">£25.00</p>
</div>
<p class="text-slate-600 dark:text-slate-400 text-base font-normal leading-relaxed">
    Heavyweight 100% organic cotton tee featuring the iconic 2024 Glasgow 'Banter' tour dates on the back. Limited edition run.
</p>
<div class="mt-4 flex flex-wrap gap-2">
<span class="px-3 py-1 border border-primary/20 rounded-lg text-xs font-medium">S</span>
<span class="px-3 py-1 border border-primary/20 rounded-lg text-xs font-medium bg-primary/10">M</span>
<span class="px-3 py-1 border border-primary/20 rounded-lg text-xs font-medium">L</span>
<span class="px-3 py-1 border border-primary/20 rounded-lg text-xs font-medium">XL</span>
</div>
<button class="mt-4 flex w-full cursor-pointer items-center justify-center rounded-lg h-12 px-6 bg-primary text-white text-base font-bold shadow-lg shadow-primary/20 hover:brightness-110 active:scale-95 transition-all">
<span class="material-symbols-outlined mr-2">shopping_bag</span>
    Add to Cart
</button>
</div>
</div>
</div>
</section>
<!-- Product Grid -->
<section class="p-4 pb-24">
<div class="grid grid-cols-2 gap-4">
<div class="flex flex-col gap-3 group">
<div class="aspect-square w-full overflow-hidden rounded-xl bg-primary/5 relative">
<div class="h-full w-full bg-center bg-cover transition-transform duration-500 group-hover:scale-105" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuDTxmQTxcV3WzpENHs-GH-lO9PDcfeW7Z1gcEf_jElrziMJbziucunGV4EZSN63rHNVwLJ37oC2bFdLoSNSY7k_NukIJr1ieOW9SW0p_CORniymBYy20WjpPG5GZECYxhUffshf-Nua-rKyQS_sgrGCZ6UuEd4w-dcI63Soo49bWYYdmPM3GF-oc1LGKSR0lmn4wXxptMQI6OFGswwhGCwSp_e2hNu5GKGp3BAKTA2pxOTvx_QyM3U0KHkgsXriuQN4ThFQcAZJ8Kw");'></div>
<button class="absolute bottom-2 right-2 size-10 rounded-full bg-white dark:bg-slate-800 flex items-center justify-center text-primary shadow-lg">
<span class="material-symbols-outlined text-xl">add_shopping_cart</span>
</button>
</div>
<div>
<p class="text-slate-900 dark:text-slate-100 font-bold">Banter Mug: 'Pure Dead Brilliant'</p>
<p class="text-primary font-medium">£12.50</p>
</div>
</div>
<div class="flex flex-col gap-3 group">
<div class="aspect-square w-full overflow-hidden rounded-xl bg-primary/5 relative">
<div class="h-full w-full bg-center bg-cover transition-transform duration-500 group-hover:scale-105" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuBV2IlOsoESoLInduqYEHqAT10zqux5ekb-GiC06mIynmoToqJLVAWjbtcwHl0v8I9UnZBoRSP9RZVtnYrSFWMqMyzmoqYlntkqPPEzrfXx6OPbEFfyjtlL3jJ6Jsf_IfYWA7X0qBVeMTCJfWigAkZaJKbROjuISDPNiqOV2nnKTc1fnuRQNEYXaF1Keg6DzC0C0-aIy0VYw3VRJE4GIcVDvvGsCpRyaxj0ScgVrSsSgJI_yl-BFpuhuyI_G2bm6yjRrUzpWIT8wQc");'></div>
<button class="absolute bottom-2 right-2 size-10 rounded-full bg-white dark:bg-slate-800 flex items-center justify-center text-primary shadow-lg">
<span class="material-symbols-outlined text-xl">add_shopping_cart</span>
</button>
</div>
<div>
<p class="text-slate-900 dark:text-slate-100 font-bold">Banter Mug: 'How's it hingin'?'</p>
<p class="text-primary font-medium">£12.50</p>
</div>
</div>
<div class="col-span-2 pt-4">
<h2 class="text-slate-900 dark:text-slate-100 text-xl font-bold">Glasgow Humor Magnets</h2>
</div>
<div class="flex flex-col gap-3 group">
<div class="aspect-[4/3] w-full overflow-hidden rounded-xl bg-primary/5 relative">
<div class="h-full w-full bg-center bg-cover transition-transform duration-500 group-hover:scale-105" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuAlZLtx20RIOLLSwNYw4AEoNtS9MRGOuRWf4SDZOR7sURTy8P5CDMB8INyJQFY7NZ4o4xq11_eKkVy8fvHR5ES5L_phccDOweIt66mqLaaoJr5cSuRxJFpjbgHFy7IfrkiXdtQCpeOUR5aDkGdzVOMDeh_KtgkZyzMOg_DoJLdxRF6mN9-Aq_ZEyIXZVrQ8RgbwG8ziRGIdxTzb-IjvmthKQoVyN0oP2jnoorAOOtV3k4ZaYc19BhU-A_ow_5v7AehUkSic-pXE124");'></div>
<button class="absolute bottom-2 right-2 size-10 rounded-full bg-white dark:bg-slate-800 flex items-center justify-center text-primary shadow-lg">
<span class="material-symbols-outlined text-xl">add_shopping_cart</span>
</button>
</div>
<div>
<p class="text-slate-900 dark:text-slate-100 font-bold">Magnet: 'People Make Glasgow'</p>
<p class="text-primary font-medium">£5.00</p>
</div>
</div>
<div class="flex flex-col gap-3 group">
<div class="aspect-[4/3] w-full overflow-hidden rounded-xl bg-primary/5 relative">
<div class="h-full w-full bg-center bg-cover transition-transform duration-500 group-hover:scale-105" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuAIAE8vL_7gXg_sDfZfRF0JsARYDzBV47vNghpZ9_qNLF5tqfdqJfeV_-yhTQ57hetDTjs9vmv-8abxKWkzPv5Obq2vUaq-lE-m3hyvk4EkbzQadzI23uuJ8Hyc6eS9ABXIil8DI2N6izGEnczcJrIoff-TCeMkF22BAn3bsHaHiPFg8Tc1lNzSV-2ZnxzRPjv3eszLdQbLQXHtePq31_qtO5DgE3VpuAyjRosyD7lgR7kP-i-C0Ce28j8xrk4VVd3UmgdiusADvcw");'></div>
<button class="absolute bottom-2 right-2 size-10 rounded-full bg-white dark:bg-slate-800 flex items-center justify-center text-primary shadow-lg">
<span class="material-symbols-outlined text-xl">add_shopping_cart</span>
</button>
</div>
<div>
<p class="text-slate-900 dark:text-slate-100 font-bold">Magnet: 'Did Ye Aye?'</p>
<p class="text-primary font-medium">£5.00</p>
</div>
</div>
</div>
</section>
</main>
<!-- Bottom Navigation Bar -->
<footer class="fixed bottom-0 left-0 right-0 z-50">
<div class="flex gap-2 border-t border-primary/10 bg-background-light dark:bg-background-dark/95 backdrop-blur-md px-4 pb-6 pt-2">
<a class="flex flex-1 flex-col items-center justify-center gap-1 text-slate-500 dark:text-slate-400" href="/">
<div class="flex h-8 items-center justify-center"><span class="material-symbols-outlined">home</span></div>
<p class="text-[10px] font-medium leading-normal uppercase tracking-wider">Home</p>
</a>
<a class="flex flex-1 flex-col items-center justify-center gap-1 text-primary" href="/merch.php">
<div class="flex h-8 items-center justify-center"><span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1">storefront</span></div>
<p class="text-[10px] font-bold leading-normal uppercase tracking-wider">Shop</p>
</a>
<a class="flex flex-1 flex-col items-center justify-center gap-1 text-slate-500 dark:text-slate-400" href="/live.php">
<div class="flex h-8 items-center justify-center"><span class="material-symbols-outlined">confirmation_number</span></div>
<p class="text-[10px] font-medium leading-normal uppercase tracking-wider">Tours</p>
</a>
<a class="flex flex-1 flex-col items-center justify-center gap-1 text-slate-500 dark:text-slate-400" href="/bookings.php">
<div class="flex h-8 items-center justify-center"><span class="material-symbols-outlined">mail</span></div>
<p class="text-[10px] font-medium leading-normal uppercase tracking-wider">Book</p>
</a>
</div>
</footer>
</div>
</body>
</html>
