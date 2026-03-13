<?php
$currentPage = 'bookings';
$pageTitle = 'Bookings & Contact';
$metaDescription = 'Book Darren Connell for your event. Commercial enquiries, corporate gigs and comedy club bookings.';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && verify_csrf()) {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '') ?: null;
    $company = trim($_POST['company'] ?? '') ?: null;
    $budget = trim($_POST['budget'] ?? '') ?: null;
    $event_type = trim($_POST['event_type'] ?? '') ?: null;
    $message = trim($_POST['message'] ?? '');
    $event_id = !empty($_POST['event_id']) ? (int)$_POST['event_id'] : null;

    $errors = [];
    if (strlen($name) < 2) $errors[] = 'Please enter your name.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Please enter a valid email.';
    if (strlen($message) < 10) $errors[] = 'Please provide more detail about your enquiry.';

    if (empty($errors)) {
        $stmt = $pdo->prepare("INSERT INTO bookings (event_id, name, email, phone, company, budget, event_type, message) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$event_id, $name, $email, $phone, $company, $budget, $event_type, $message]);
        $_SESSION['old'] = [];
        flash('success', 'Thanks! Your enquiry has been sent. We\'ll get back to you soon.');
        redirect('/bookings.php');
    }
    $_SESSION['old'] = $_POST;
    flash('error', implode(' ', $errors));
}

$stmt = $pdo->query("SELECT id, title, venue, event_date FROM events WHERE event_date >= CURDATE() ORDER BY event_date ASC");
$events = $stmt->fetchAll();

$micImageUrl = 'https://lh3.googleusercontent.com/aida-public/AB6AXuDAFQnnBKOQ24M8TTw-OP-iBYnbZDMPQHtdafWlEhhQTtm_j3O4g9NwIP2s1ENI2RaoRodL3eJ8tOJM6oNI0KyqIANNbA0gU9LpTHN0mjzmRNX9VysB-Q5yMS5M9ddYFm338DHSUf6UVMvWTZkJk6pFEa0yxDU3tIn00UBnma5T27qMLr4Nx-XKf8FaFMzwvkPKi-CkQz5Z8b-7HWkiVPYzc3ske4Xc7Df5EYAo5HTh1pI68RvRDyz8-o1IYNQe2E2IjsUSY81enAg';
?>
<!DOCTYPE html>
<html class="dark" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<?php require __DIR__ . '/../includes/meta-stitch.php'; ?>
<title><?= e($pageTitle) ?> | Darren Connell</title>
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
                fontFamily: { "display": ["Space Grotesk", "sans-serif"] },
                borderRadius: {"DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px"},
            },
        },
    }
</script>
<style>
    body { font-family: 'Space Grotesk', sans-serif; min-height: max(884px, 100dvh); }
    .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; font-family: 'Material Symbols Outlined'; font-weight: normal; font-style: normal; display: inline-block; line-height: 1; }
</style>
</head>
<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 min-h-screen">
<?php require __DIR__ . '/../includes/navbar-stitch.php'; ?>
<div class="relative flex flex-col min-h-screen">
<main id="main-content" class="max-w-7xl mx-auto w-full px-4">

<?php if ($flash = flash('success')): ?>
<div class="mx-4 mt-4 p-4 bg-green-500/20 border border-green-500/40 rounded-lg text-green-200 text-sm"><?= e($flash) ?></div>
<?php endif; ?>
<?php if ($flash = flash('error')): ?>
<div class="mx-4 mt-4 p-4 bg-red-500/20 border border-red-500/40 rounded-lg text-red-200 text-sm"><?= e($flash) ?></div>
<?php endif; ?>

<!-- Hero Section -->
<div class="px-4 py-4">
<div class="bg-cover bg-center flex flex-col justify-end overflow-hidden rounded-xl min-h-[220px] relative" style="background-image: linear-gradient(0deg, rgba(34, 22, 16, 0.9) 0%, rgba(34, 22, 16, 0.2) 100%), url('<?= e($micImageUrl) ?>');">
<div class="flex p-6 flex-col">
<span class="text-primary font-bold text-sm uppercase tracking-widest mb-1">Available for Bookings</span>
<p class="text-white text-3xl font-bold leading-tight font-display">Get in Touch</p>
</div>
</div>
</div>

<!-- Intro Text -->
<div class="px-4 py-4">
<h1 class="text-slate-900 dark:text-slate-100 text-xl font-bold font-display mb-2">Booking &amp; Inquiries</h1>
<p class="text-slate-600 dark:text-slate-400 text-base leading-relaxed">
    Whether it's a corporate gig, press request, or just a friendly fan message, I'd love to hear from you. My team usually responds within 48 hours.
</p>
<p class="text-slate-500 dark:text-slate-500 text-sm mt-2"><strong>Note:</strong> This site does not handle personal requests for autographs or video messages. For professional bookings only.</p>
</div>

<!-- Contact Form -->
<form method="post" action="" class="px-4 space-y-4 pb-8">
<?= csrf_field() ?>
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
<div class="space-y-2">
<label for="name" class="text-sm font-medium text-slate-700 dark:text-slate-300 ml-1">Your Name *</label>
<input id="name" name="name" class="w-full bg-white dark:bg-primary/5 border border-slate-200 dark:border-primary/20 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all dark:text-white" placeholder="John Doe" type="text" value="<?= e(old('name')) ?>" required/>
</div>
<div class="space-y-2">
<label for="email" class="text-sm font-medium text-slate-700 dark:text-slate-300 ml-1">Email Address *</label>
<input id="email" name="email" class="w-full bg-white dark:bg-primary/5 border border-slate-200 dark:border-primary/20 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all dark:text-white" placeholder="john@example.com" type="email" value="<?= e(old('email')) ?>" required/>
</div>
<div class="space-y-2">
<label for="phone" class="text-sm font-medium text-slate-700 dark:text-slate-300 ml-1">Phone</label>
<input id="phone" name="phone" class="w-full bg-white dark:bg-primary/5 border border-slate-200 dark:border-primary/20 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all dark:text-white" placeholder="Optional" type="tel" value="<?= e(old('phone')) ?>"/>
</div>
<div class="space-y-2">
<label for="event_type" class="text-sm font-medium text-slate-700 dark:text-slate-300 ml-1">Inquiry Type</label>
<select id="event_type" name="event_type" class="w-full bg-white dark:bg-primary/10 border border-slate-200 dark:border-primary/20 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all dark:text-white appearance-none">
<option value="Live Show Booking" <?= old('event_type') === 'Live Show Booking' ? 'selected' : '' ?>>Live Show Booking</option>
<option value="Press & Media" <?= old('event_type') === 'Press & Media' ? 'selected' : '' ?>>Press &amp; Media</option>
<option value="Podcast Appearance" <?= old('event_type') === 'Podcast Appearance' ? 'selected' : '' ?>>Podcast Appearance</option>
<option value="Fan Message" <?= old('event_type') === 'Fan Message' ? 'selected' : '' ?>>Fan Message</option>
<option value="Other" <?= old('event_type') === 'Other' ? 'selected' : '' ?>>Other</option>
</select>
</div>
</div>
<?php if (!empty($events)): ?>
<div class="space-y-2">
<label for="event_id" class="text-sm font-medium text-slate-700 dark:text-slate-300 ml-1">Specific Event (optional)</label>
<select id="event_id" name="event_id" class="w-full bg-white dark:bg-primary/10 border border-slate-200 dark:border-primary/20 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all dark:text-white appearance-none">
<option value="">— Select —</option>
<?php foreach ($events as $e): ?>
<option value="<?= $e['id'] ?>" <?= old('event_id') == $e['id'] ? 'selected' : '' ?>><?= e($e['title']) ?> — <?= format_date($e['event_date']) ?></option>
<?php endforeach; ?>
</select>
</div>
<?php endif; ?>
<div class="space-y-2">
<label for="message" class="text-sm font-medium text-slate-700 dark:text-slate-300 ml-1">Message *</label>
<textarea id="message" name="message" class="w-full bg-white dark:bg-primary/5 border border-slate-200 dark:border-primary/20 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all dark:text-white" placeholder="Tell me about your event or project..." rows="4" required><?= e(old('message')) ?></textarea>
</div>
<button type="submit" class="w-full bg-primary hover:bg-primary/90 text-white font-bold py-4 rounded-xl shadow-lg shadow-primary/20 transition-all flex items-center justify-center gap-2">
<span>Send Message</span>
<span class="material-symbols-outlined text-sm">send</span>
</button>
</form>

<!-- Social Media Section -->
<div class="px-4 py-6 border-t border-primary/10 bg-primary/5">
<h3 class="text-center text-sm font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-6">Connect on Socials</h3>
<div class="flex justify-around items-center flex-wrap gap-4">
<a class="flex flex-col items-center gap-2 group" href="https://www.instagram.com/darrenconnellcomedian/?hl=en" target="_blank" rel="noopener">
<div class="size-12 rounded-full bg-white dark:bg-background-dark border border-primary/20 flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-all">
<span class="material-symbols-outlined">camera_enhance</span>
</div>
<span class="text-xs font-medium">Instagram</span>
</a>
<a class="flex flex-col items-center gap-2 group" href="https://www.tiktok.com/@darrenconnellcomedian" target="_blank" rel="noopener">
<div class="size-12 rounded-full bg-white dark:bg-background-dark border border-primary/20 flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-all">
<span class="material-symbols-outlined">video_library</span>
</div>
<span class="text-xs font-medium">TikTok</span>
</a>
<a class="flex flex-col items-center gap-2 group" href="https://www.threads.net/@darrenconnellcomedian" target="_blank" rel="noopener">
<div class="size-12 rounded-full bg-white dark:bg-background-dark border border-primary/20 flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-all">
<span class="material-symbols-outlined">alternate_email</span>
</div>
<span class="text-xs font-medium">Threads</span>
</a>
<a class="flex flex-col items-center gap-2 group" href="https://open.spotify.com/show/0hjOxRAlk3A9CVt1KFlmpI" target="_blank" rel="noopener">
<div class="size-12 rounded-full bg-white dark:bg-background-dark border border-primary/20 flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-all">
<span class="material-symbols-outlined">podcasts</span>
</div>
<span class="text-xs font-medium">Spotify</span>
</a>
</div>
</div>

<div class="h-20"></div>
</main>
</div>
</div>

<!-- Bottom Navigation -->
<nav class="fixed bottom-0 left-0 right-0 z-20 border-t border-primary/10 bg-background-light/90 dark:bg-background-dark/90 backdrop-blur-md px-4 pb-3 pt-2">
<div class="flex gap-2">
<a class="flex flex-1 flex-col items-center justify-end gap-1 text-slate-400 dark:text-slate-500 hover:text-primary transition-colors" href="/">
<div class="flex h-8 items-center justify-center"><span class="material-symbols-outlined">home</span></div>
<p class="text-[10px] font-medium leading-normal tracking-wide">Home</p>
</a>
<a class="flex flex-1 flex-col items-center justify-end gap-1 text-slate-400 dark:text-slate-500 hover:text-primary transition-colors" href="/live.php">
<div class="flex h-8 items-center justify-center"><span class="material-symbols-outlined">confirmation_number</span></div>
<p class="text-[10px] font-medium leading-normal tracking-wide">Shows</p>
</a>
<a class="flex flex-1 flex-col items-center justify-end gap-1 text-primary" href="/bookings.php">
<div class="flex h-8 items-center justify-center"><span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1">mail</span></div>
<p class="text-[10px] font-bold leading-normal tracking-wide">Contact</p>
</a>
<a class="flex flex-1 flex-col items-center justify-end gap-1 text-slate-400 dark:text-slate-500 hover:text-primary transition-colors" href="/media.php">
<div class="flex h-8 items-center justify-center"><span class="material-symbols-outlined">play_circle</span></div>
<p class="text-[10px] font-medium leading-normal tracking-wide">Media</p>
</a>
</div>
</nav>
</body>
</html>
