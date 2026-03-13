<?php $currentPage = $currentPage ?? 'home'; ?>
<header class="sticky top-0 z-50 bg-background-light/80 dark:bg-background-dark/80 backdrop-blur-md border-b border-primary/10">
<div class="max-w-7xl mx-auto px-4 h-16 flex items-center justify-between">
<a href="/" class="flex items-center gap-2">
<span class="material-symbols-outlined text-primary text-3xl">mic_external_on</span>
<h1 class="text-xl font-bold tracking-tight text-slate-900 dark:text-slate-100">DARREN <span class="text-primary">CONNELL</span></h1>
</a>
<nav class="hidden md:flex items-center gap-1">
<a class="text-sm font-medium px-3 py-2 rounded-lg hover:bg-primary/10 hover:text-primary transition-colors <?= $currentPage === 'home' ? 'text-primary' : 'text-slate-600 dark:text-slate-400' ?>" href="/">Home</a>
<a class="text-sm font-medium px-3 py-2 rounded-lg hover:bg-primary/10 hover:text-primary transition-colors <?= $currentPage === 'about' ? 'text-primary' : 'text-slate-600 dark:text-slate-400' ?>" href="/about.php">About</a>
<a class="text-sm font-medium px-3 py-2 rounded-lg hover:bg-primary/10 hover:text-primary transition-colors <?= $currentPage === 'live' ? 'text-primary' : 'text-slate-600 dark:text-slate-400' ?>" href="/live.php">Tour Dates</a>
<a class="text-sm font-medium px-3 py-2 rounded-lg hover:bg-primary/10 hover:text-primary transition-colors <?= $currentPage === 'media' ? 'text-primary' : 'text-slate-600 dark:text-slate-400' ?>" href="/media.php">Media</a>
<a class="text-sm font-medium px-3 py-2 rounded-lg hover:bg-primary/10 hover:text-primary transition-colors <?= $currentPage === 'merch' ? 'text-primary' : 'text-slate-600 dark:text-slate-400' ?>" href="/merch.php">Store</a>
<a class="text-sm font-medium px-3 py-2 rounded-lg hover:bg-primary/10 hover:text-primary transition-colors <?= $currentPage === 'podcast' ? 'text-primary' : 'text-slate-600 dark:text-slate-400' ?>" href="/podcast.php">Podcast</a>
<a class="text-sm font-medium px-3 py-2 rounded-lg hover:bg-primary/10 hover:text-primary transition-colors <?= $currentPage === 'bookings' ? 'text-primary' : 'text-slate-600 dark:text-slate-400' ?>" href="/bookings.php">Bookings</a>
</nav>
<div class="flex items-center gap-2 relative">
<button class="p-2 rounded-full hover:bg-primary/10 text-slate-600 dark:text-slate-400 hover:text-primary transition-colors md:hidden" aria-label="Menu" id="nav-toggle"><span class="material-symbols-outlined">menu</span></button>
<button class="p-2 rounded-full hover:bg-primary/10 text-slate-600 dark:text-slate-400 hover:text-primary transition-colors hidden md:flex" aria-label="Search" id="search-toggle" aria-expanded="false"><span class="material-symbols-outlined">search</span></button>
<div id="search-bar" class="hidden absolute right-0 top-full mt-1 z-10">
<form action="/search.php" method="get" class="flex items-center gap-2 bg-white dark:bg-slate-800 rounded-full pl-4 pr-2 py-1.5 shadow-lg border border-slate-200 dark:border-slate-700">
<input type="search" name="q" placeholder="Search events, content..." class="bg-transparent outline-none w-56 text-slate-900 dark:text-slate-100 placeholder-slate-500" autocomplete="off">
<button type="submit" class="p-2 rounded-full hover:bg-primary/10 text-primary" aria-label="Submit search"><span class="material-symbols-outlined text-xl">search</span></button>
</form>
</div>
<a href="/bookings.php" class="p-2 rounded-full hover:bg-primary/10 text-slate-600 dark:text-slate-400 hover:text-primary transition-colors" aria-label="Bookings / Contact"><span class="material-symbols-outlined">mail</span></a>
</div>
</div>
<nav id="mobile-nav" class="md:hidden hidden border-t border-primary/10 bg-background-light/95 dark:bg-background-dark/95 backdrop-blur-md py-4 px-4">
<div class="flex flex-col gap-1">
<a class="text-sm font-medium px-3 py-2 rounded-lg transition-colors text-slate-400 hover:text-primary hover:bg-primary/10" href="/search.php"><span class="material-symbols-outlined align-middle text-lg mr-2">search</span> Search</a>
<a class="text-sm font-medium px-3 py-2 rounded-lg transition-colors <?= $currentPage === 'home' ? 'text-primary bg-primary/10' : 'text-slate-400 hover:text-primary hover:bg-primary/10' ?>" href="/">Home</a>
<a class="text-sm font-medium px-3 py-2 rounded-lg transition-colors <?= $currentPage === 'about' ? 'text-primary bg-primary/10' : 'text-slate-400 hover:text-primary hover:bg-primary/10' ?>" href="/about.php">About</a>
<a class="text-sm font-medium px-3 py-2 rounded-lg transition-colors <?= $currentPage === 'live' ? 'text-primary bg-primary/10' : 'text-slate-400 hover:text-primary hover:bg-primary/10' ?>" href="/live.php">Tour Dates</a>
<a class="text-sm font-medium px-3 py-2 rounded-lg transition-colors <?= $currentPage === 'media' ? 'text-primary bg-primary/10' : 'text-slate-400 hover:text-primary hover:bg-primary/10' ?>" href="/media.php">Media</a>
<a class="text-sm font-medium px-3 py-2 rounded-lg transition-colors <?= $currentPage === 'merch' ? 'text-primary bg-primary/10' : 'text-slate-400 hover:text-primary hover:bg-primary/10' ?>" href="/merch.php">Store</a>
<a class="text-sm font-medium px-3 py-2 rounded-lg transition-colors <?= $currentPage === 'podcast' ? 'text-primary bg-primary/10' : 'text-slate-400 hover:text-primary hover:bg-primary/10' ?>" href="/podcast.php">Podcast</a>
<a class="text-sm font-medium px-3 py-2 rounded-lg transition-colors <?= $currentPage === 'bookings' ? 'text-primary bg-primary/10' : 'text-slate-400 hover:text-primary hover:bg-primary/10' ?>" href="/bookings.php">Bookings</a>
</div>
</nav>
</header>
<script>
(function(){
  var t=document.getElementById('nav-toggle'),n=document.getElementById('mobile-nav');
  if(t&&n)t.addEventListener('click',function(){n.classList.toggle('hidden');var i=t.querySelector('.material-symbols-outlined');if(i)i.textContent=n.classList.contains('hidden')?'menu':'close';});
  var s=document.getElementById('search-toggle'),b=document.getElementById('search-bar');
  if(s&&b){s.addEventListener('click',function(){var open=!b.classList.contains('hidden');b.classList.toggle('hidden',open);b.classList.toggle('flex',!open);s.setAttribute('aria-expanded',!open);if(!open){var inp=b.querySelector('input');if(inp){inp.focus();inp.value='';}}});
  document.addEventListener('click',function(e){if(!b.classList.contains('hidden')&&!b.contains(e.target)&&!s.contains(e.target)){b.classList.add('hidden');b.classList.remove('flex');s.setAttribute('aria-expanded','false');}});}
})();
</script>
