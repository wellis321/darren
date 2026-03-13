<?php
/**
 * llms.txt - AI-readable site summary for ChatGPT, Claude, Perplexity, etc.
 * Served at /llms.txt
 * Spec: https://llmstxtdirectory.org
 */
header('Content-Type: text/plain; charset=utf-8');

$baseUrl = rtrim(function_exists('env') ? env('APP_URL', 'http://localhost:8001') : 'http://localhost:8001', '/');

?>
# Darren Connell

> Scottish comedian, actor and BAFTA-nominated star of Scot Squad. Stand-up comedy, podcasts and live performances across the UK. Book tickets, watch clips, and hire for corporate events.

Darren Connell is a Scottish stand-up comedian, podcaster and actor from Glasgow, best known for playing Bobby Muir in the BBC Scotland mockumentary series Scot Squad — a role that earned him a BAFTA Scotland New Talent Award nomination for Best Actor in 2015. He grew up in Springburn and started performing stand-up whilst working full-time until fellow comedian Kevin Bridges convinced him to pursue comedy full-time. His shows include Trolleywood, No Filter, Abandon All Hope (sold out at Glasgow Comedy Festival), and My Name Is Darren Connell and This Is My Self-Tape. He hosts Glaswegians Anonymous podcast with Gary Faulds and co-created Straight White Whale with Paul Shields. High-octane, unfiltered, and unapologetically Glaswegian comedy.

## Core Pages

- [Home](<?= $baseUrl ?>/): Official site with upcoming shows and newsletter
- [About](<?= $baseUrl ?>/about.php): Full biography, career, and comedy style
- [Tour Dates](<?= $baseUrl ?>/live.php): Upcoming comedy shows across the UK
- [Media & Videos](<?= $baseUrl ?>/media.php): Stand-up clips, Scot Squad highlights, photos
- [Podcast](<?= $baseUrl ?>/podcast.php): Glaswegians Anonymous — honest conversations about Glasgow life
- [Bookings](<?= $baseUrl ?>/bookings.php): Commercial enquiries, corporate gigs, press
- [Merchandise](<?= $baseUrl ?>/merch.php): Official tour merch and Glasgow humor magnets

## Bookings & Contact

- [Booking Enquiry Form](<?= $baseUrl ?>/bookings.php): For live show bookings, corporate events, podcast appearances, press & media
- Professional bookings only — responds within 48 hours

## What We Do Not Do

- Personal requests for autographs or video messages. For professional bookings only.

## Social & Podcasts

- [Instagram](https://www.instagram.com/darrenconnellcomedian/)
- [Facebook](https://www.facebook.com/darren.connell.77/)
- [TikTok](https://www.tiktok.com/@darrenconnellcomedian)
- [Threads](https://www.threads.net/@darrenconnellcomedian)
- [Glaswegians Anonymous on Spotify](https://open.spotify.com/show/0hjOxRAlk3A9CVt1KFlmpI)
- [Glaswegians Anonymous on Apple Podcasts](https://podcasts.apple.com/gb/podcast/glaswegians-anonymous/id1834912592)
