<?php
$currentPage = 'home';
$pageTitle = 'Darren Connell';
$fullTitle = 'Darren Connell | Official Site';
$metaDescription = 'Darren Connell - Scottish comedian, actor and BAFTA-nominated star of Scot Squad. Book tickets and watch live.';

$stmt = $pdo->query("SELECT * FROM events WHERE event_date >= CURDATE() ORDER BY event_date ASC LIMIT 6");
$events = $stmt->fetchAll();
// Deduplicate by title+venue+date
$seen = [];
$events = array_values(array_filter($events, function($e) use (&$seen) {
    $key = ($e['title'] ?? '') . '|' . ($e['venue'] ?? '') . '|' . ($e['event_date'] ?? '');
    if (isset($seen[$key])) return false;
    $seen[$key] = true;
    return true;
}));
$featuredEvent = $events[0] ?? null;
$listEvents = array_slice($events, 0, 5); // Show all events in list (matches live page)

$stmt = $pdo->query("SELECT quote, author, role FROM testimonials WHERE is_featured = 1 ORDER BY sort_order");
$testimonials = $stmt->fetchAll();
$testimonialRotate = count($testimonials) > 3;
?>
<!DOCTYPE html>
<html class="dark" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<?php require __DIR__ . '/../includes/meta-stitch.php'; ?>
<title>Darren Connell | Official Site</title>
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
    .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        font-family: 'Material Symbols Outlined';
        font-weight: normal;
        font-style: normal;
        display: inline-block;
        line-height: 1;
        text-transform: none;
        letter-spacing: normal;
        word-wrap: normal;
        white-space: nowrap;
        direction: ltr;
    }
</style>
</head>
<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 antialiased">
<?php require __DIR__ . '/../includes/navbar-stitch.php'; ?>
<main id="main-content">
<?php if ($flash = flash('success')): ?>
<div class="max-w-7xl mx-auto px-4 py-4">
<div class="bg-green-500/20 border border-green-500/40 rounded-lg px-4 py-2 text-green-200"><?= e($flash) ?></div>
</div>
<?php endif; ?>
<?php if ($featuredEvent): ?>
<!-- Top Banner -->
<div class="bg-primary py-3 px-4 text-white font-bold tracking-tight">
<div class="max-w-7xl mx-auto flex flex-wrap items-center justify-center gap-2 text-sm md:text-base">
<span class="material-symbols-outlined fill-1">star</span>
<span><?= e($featuredEvent['title']) ?> — <?= format_date($featuredEvent['event_date'], 'F jS Y') ?></span>
<?php if ($featuredEvent['ticket_url']): ?>
<a class="ml-2 px-3 py-1 bg-white text-primary rounded font-bold hover:bg-white/90 transition-colors" href="<?= e($featuredEvent['ticket_url']) ?>" target="_blank" rel="noopener">BOOK TICKETS</a>
<?php else: ?>
<a class="ml-2 px-3 py-1 bg-white text-primary rounded font-bold hover:bg-white/90 transition-colors" href="/bookings.php">BOOK TICKETS</a>
<?php endif; ?>
<span class="material-symbols-outlined fill-1">star</span>
</div>
</div>
<?php endif; ?>
<!-- Hero Section -->
<section class="relative overflow-hidden pt-12 pb-20 md:pt-24 md:pb-32">
<div class="max-w-7xl mx-auto px-4">
<div class="flex flex-col sm:flex-row items-center gap-12">
<div class="flex-1 text-center sm:text-left z-10">
<span class="inline-block py-1 px-3 rounded-full bg-primary/20 text-primary text-sm font-bold mb-6 tracking-wider uppercase">Live & On Demand</span>
<h1 class="text-5xl md:text-7xl font-black leading-none mb-6 tracking-tighter">
    Truthful.<br/>Clever.<br/><span class="text-primary">Very Funny.</span>
</h1>
<p class="text-lg md:text-xl text-slate-600 dark:text-slate-400 mb-8 max-w-xl mx-auto sm:mx-0 font-medium">
    Experience the raw, high energy comedy of Glasgow's own comedy powerhouse. From Scot Squad to the main stage.
</p>
<div class="flex flex-col items-center justify-center sm:items-start gap-3">
<a href="/live.php" class="w-full sm:w-auto px-8 py-4 bg-primary text-white font-bold rounded-lg shadow-lg shadow-primary/30 hover:scale-105 transition-transform text-center">BOOK YOUR DATES</a>
<a href="/media.php" class="text-primary font-bold hover:underline">VIEW SPECIALS</a>
</div>
</div>
<div class="flex-1 relative">
<div class="absolute -top-10 -right-10 w-64 h-64 bg-primary/20 rounded-full blur-3xl"></div>
<div class="absolute -bottom-10 -left-10 w-64 h-64 bg-primary/10 rounded-full blur-3xl"></div>
<div class="relative rounded-2xl overflow-hidden border-4 border-primary/20 shadow-2xl">
<img alt="Darren Connell" class="w-full aspect-[4/5] object-cover" src="<?= BASE_PATH ?>/assets/images/darren.png"/>
<div class="absolute bottom-0 left-0 right-0 p-6 bg-gradient-to-t from-background-dark to-transparent">
<p class="text-white font-bold text-lg"><?= $featuredEvent ? e($featuredEvent['venue']) : 'Live at The King\'s Theatre' ?></p>
<p class="text-primary font-medium text-sm"><?= $featuredEvent ? format_date($featuredEvent['event_date'], 'F jS') . ($featuredEvent['event_time'] ? ', ' . format_time($featuredEvent['event_time']) : '') : 'May 29th, 8PM & 9PM' ?></p>
</div>
</div>
</div>
</div>
</div>
</section>
<?php if (!empty($testimonials)): ?>
<!-- Testimonials -->
<section class="py-12 border-y border-primary/10 bg-white/5">
<div class="max-w-5xl mx-auto px-4">
<?php if ($testimonialRotate): ?>
<div class="overflow-hidden">
<?php 
$tCount = count($testimonials);
$trackSlides = array_merge($testimonials, $testimonials);
$trackCount = count($trackSlides);
?>
<div id="testimonial-track" class="flex transition-transform duration-500 ease-out" style="width: <?= $trackCount * 100 / 3 ?>%;">
<?php foreach ($trackSlides as $t): ?>
<blockquote class="testimonial-slide flex-shrink-0 flex flex-col items-center justify-center text-center px-4" style="flex: 0 0 <?= 100 / $trackCount ?>%;">
<p class="text-xl md:text-2xl font-medium text-slate-200 italic mb-2">&ldquo;<?= e($t['quote']) ?>&rdquo;</p>
<cite class="text-primary font-bold not-italic"><?= e($t['author']) ?></cite><?= !empty($t['role']) ? ' <span class="text-slate-500">— ' . e($t['role']) . '</span>' : '' ?>
</blockquote>
<?php endforeach; ?>
</div>
</div>
<?php else: ?>
<div class="flex flex-col md:flex-row gap-8 items-center justify-center">
<?php foreach ($testimonials as $t): ?>
<blockquote class="text-center md:text-left">
<p class="text-xl md:text-2xl font-medium text-slate-200 italic mb-2">&ldquo;<?= e($t['quote']) ?>&rdquo;</p>
<cite class="text-primary font-bold not-italic"><?= e($t['author']) ?></cite><?= !empty($t['role']) ? ' <span class="text-slate-500">— ' . e($t['role']) . '</span>' : '' ?>
</blockquote>
<?php endforeach; ?>
</div>
<?php endif; ?>
</div>
</section>
<?php if ($testimonialRotate): ?>
<script>
(function(){
  var track = document.getElementById('testimonial-track');
  var slides = document.querySelectorAll('.testimonial-slide');
  var n = slides.length / 2;
  var current = 0;
  var interval = 5000;
  function update() {
    track.style.transform = 'translateX(-' + (current / (n * 2) * 100) + '%)';
  }
  function goNext() {
    current++;
    update();
    if (current >= n) {
      track.addEventListener('transitionend', function reset() {
        track.removeEventListener('transitionend', reset);
        track.style.transition = 'none';
        current = 0;
        update();
        track.offsetHeight;
        track.style.transition = '';
      }, { once: true });
    }
  }
  var t = setInterval(goNext, interval);
})();
</script>
<?php endif; ?>
<?php endif; ?>
<!-- About Teaser -->
<section class="py-20 bg-primary/5 dark:bg-white/5">
<div class="max-w-7xl mx-auto px-4">
<div class="grid md:grid-cols-2 gap-16 items-center">
<div class="order-2 md:order-1">
<div class="grid grid-cols-2 gap-4">
<div class="space-y-4">
<div class="h-48 rounded-xl overflow-hidden">
<img alt="Glasgow city scene" class="w-full h-full object-cover grayscale hover:grayscale-0 transition-all duration-500" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCY5GtkbZScMknfmsV2QFKjK-HNB3tmKBYT5sj_vS0GHDmf_DpEEf__frMGzjC6ewy6NTTPdlo79vNGF4Rwki3HD8rlznEokvTt_6bGkVFuSK5al5sXBEScDkZ5TeBCMjNj8-EB0oH5UEq0zXL5Z50o-iMolqgfeZbzOVFQpdQ_D_Bp-87iC1Bb1zq5AxmaHts0a36yg7KViq6XkGy_rC-V0ML7Mkt_uZBQxpw6f_OUUXnzfjSeX60RjEBn69ROYkDZilmnZXit8PM"/>
</div>
<div class="bg-primary p-6 rounded-xl text-white">
<h3 class="text-3xl font-bold">10+</h3>
<p class="text-sm font-medium opacity-80">Years of Career</p>
</div>
</div>
<div class="space-y-4 pt-8">
<div class="bg-background-dark p-6 rounded-xl border border-primary/20">
<span class="material-symbols-outlined text-primary text-4xl mb-2">play_circle</span>
<p class="text-sm font-bold text-white uppercase tracking-widest">All Audio and Video</p>
</div>
<div class="h-48 rounded-xl overflow-hidden">
<img alt="Live stage crowd" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCLzme35OR-EykJ_FTbYPpVw2Jt6WltbxkwLJVGBjSmqKmeN7HaVLk19vg_NwcEhiVcvORwKVKVwdGkmotE1Q2WvT5aumZLaIDXJaHHhnlh1eyuivF0QkBDjyyn0Qx5MaCW0w3A1gwxnT01G2-4IeQ1r0ysuloDG12gFQOo6bcjYzf_7sQzZNvNv89tflslXlsnWslGCTJyNgSTVvF0MhENWEmE7DLas1Zofi5yJiFXN3cZR-PhqIVkPXS88geFq1HQPLEmASJHQ9o"/>
</div>
</div>
</div>
</div>
<div class="order-1 md:order-2">
<h2 class="text-4xl font-bold mb-6 tracking-tight">The Glasgow Powerhouse</h2>
<div class="space-y-4 text-slate-600 dark:text-slate-400 text-lg">
<p>From the streets of Glasgow to the biggest stages in comedy, Darren Connell brings a raw, honest, and high-octane style that leaves audiences breathless.</p>
<p>Best known for his breakout role as Bobby in the hit BBC comedy <span class="text-primary font-bold">'Scot Squad'</span>, Darren has transitioned from a beloved TV character to one of the most uncompromising and sought-after stand-up acts in the UK.</p>
<p>His storytelling is personal, his timing is impeccable, and his energy is infectious. This is comedy without the safety net.</p>
</div>
<div class="mt-8">
<a class="inline-flex items-center gap-2 text-primary font-bold hover:gap-4 transition-all" href="/about.php">
    READ THE FULL STORY
    <span class="material-symbols-outlined">arrow_right_alt</span>
</a>
</div>
</div>
</div>
</div>
</section>
<!-- Upcoming Shows / Work in Progress -->
<section class="py-20 border-y border-white/5">
<div class="max-w-7xl mx-auto px-4">
<div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-4">
<div>
<span class="text-primary font-bold uppercase tracking-widest text-sm mb-2 block">See me live</span>
<h2 class="text-4xl font-black tracking-tighter">WORK IN PROGRESS</h2>
</div>
<p class="max-w-md text-slate-400 font-medium">
    Be the first to hear the new material. These intimate, raw, and unpredictable shows are where the magic (and the chaos) starts.
</p>
</div>
<div class="grid gap-6">
<?php if (!empty($listEvents)): ?>
<?php foreach ($listEvents as $event): ?>
<?php $cardHref = $event['ticket_url'] ? e($event['ticket_url']) : '/bookings.php'; ?>
<a href="<?= $cardHref ?>" target="<?= $event['ticket_url'] ? '_blank' : '_self' ?>" rel="<?= $event['ticket_url'] ? 'noopener' : '' ?>" class="group flex flex-col md:flex-row justify-between items-center gap-6 p-6 rounded-xl border border-white/10 bg-white/5 hover:border-primary/50 transition-colors">
<div class="flex items-center gap-6 w-full md:w-auto">
<div class="bg-primary/20 text-primary p-4 rounded-lg text-center min-w-[80px] shrink-0">
<span class="block text-2xl font-bold"><?= strtoupper(format_date($event['event_date'], 'M')) ?></span>
<span class="block text-sm font-black"><?= format_date($event['event_date'], 'j') ?></span>
</div>
<div>
<h3 class="text-xl font-bold group-hover:text-primary transition-colors"><?= e($event['title']) ?></h3>
<p class="text-slate-400"><?= e($event['venue']) ?><?= $event['venue_city'] ? ' • ' . e($event['venue_city']) : '' ?></p>
</div>
</div>
<span class="w-full md:w-auto px-8 py-3 bg-white/10 group-hover:bg-primary text-white font-bold rounded-lg transition-all text-center">RESERVE A SEAT</span>
</a>
<?php endforeach; ?>
<?php elseif (empty($events)): ?>
<div class="bg-white/5 p-6 rounded-xl border border-white/10 text-center py-12">
<p class="text-slate-400 mb-4">No upcoming dates announced yet. Check back soon.</p>
<a href="/bookings.php" class="inline-block px-8 py-3 bg-primary text-white font-bold rounded-lg">ENQUIRE ABOUT BOOKING</a>
</div>
<?php endif; ?>
</div>
<a href="/live.php" class="inline-block mt-8 text-primary font-bold hover:underline">View all tour dates →</a>
</div>
</section>
<!-- Newsletter / CTA -->
<section class="py-20">
<div class="max-w-5xl mx-auto px-4">
<div class="bg-primary rounded-2xl p-8 md:p-12 text-center relative overflow-hidden">
<div class="absolute inset-0 opacity-10 pointer-events-none" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 24px 24px;"></div>
<h2 class="text-3xl md:text-5xl font-black text-white mb-6 relative z-10">Don't miss the madness.</h2>
<p class="text-white/90 text-lg mb-8 max-w-2xl mx-auto relative z-10">
    Join the inner circle for early access to new tickets, exclusive merchandise drops, and the first to hear the updates.
</p>
<form class="flex flex-col sm:flex-row gap-3 max-w-md mx-auto relative z-10" action="/api/newsletter.php" method="post">
<?= csrf_field() ?>
<input class="flex-1 px-4 py-3 rounded-lg border-none focus:ring-2 focus:ring-white bg-white/20 text-white placeholder:text-white/60" placeholder="Enter your email" type="email" name="email" required/>
<button type="submit" class="px-6 py-3 bg-white text-primary font-bold rounded-lg hover:bg-slate-100 transition-colors">SUBSCRIBE</button>
</form>
</div>
</div>
</section>
</main>
<?php require __DIR__ . '/../includes/footer-stitch.php'; ?>
<!-- Bottom Mobile Nav -->
<div class="md:hidden fixed bottom-0 left-0 right-0 z-50 bg-background-dark border-t border-primary/20 px-4 pb-6 pt-2 flex justify-between items-center">
<a class="flex flex-col items-center gap-1 text-primary" href="/"><span class="material-symbols-outlined">home</span><span class="text-[10px] font-bold uppercase tracking-widest">Home</span></a>
<a class="flex flex-col items-center gap-1 text-slate-400" href="/live.php"><span class="material-symbols-outlined">confirmation_number</span><span class="text-[10px] font-bold uppercase tracking-widest">Tours</span></a>
<a class="flex flex-col items-center gap-1 text-slate-400" href="/merch.php"><span class="material-symbols-outlined">shopping_bag</span><span class="text-[10px] font-bold uppercase tracking-widest">Merch</span></a>
<a class="flex flex-col items-center gap-1 text-slate-400" href="/media.php"><span class="material-symbols-outlined">play_circle</span><span class="text-[10px] font-bold uppercase tracking-widest">Shows</span></a>
</div>
</body>
</html>
