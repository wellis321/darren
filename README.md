# Darren Connell — Comedian & Actor Website

A professional PHP/SQL website for comedian Darren Connell from Glasgow. Features bio, tour dates, booking system, media gallery, podcast section, and an admin panel for Darren to manage content.

## Requirements

- PHP 8.0+
- MySQL 5.7+ (or MariaDB)
- MySQL running on port 8889 (MAMP-style) or update `.env`

## Setup

### 1. Database

Create the database and run the schema:

```bash
mysql -h 127.0.0.1 -P 8889 -u root -proot < sql/schema.sql
```

Or connect with your client and run `sql/schema.sql`.

### 2. Environment

Copy `.env.example` to `.env` and adjust if needed. For **production** (e.g. Hostinger), set:

```
APP_ENV=production
```

This enables secure session cookies, hides the login dev hint, and suppresses DB error details on 503.

### 3. Start the server

From the project root:

```bash
cd public && php -S localhost:8001 index.php
```

Then open [http://localhost:8001](http://localhost:8001).

## Admin Panel

- **URL:** [http://localhost:8001/admin/](http://localhost:8001/admin/)
- **Default login:** admin@darrenconnell.com / changeme123
- **Forgot password:** Use the link on the login page to request a reset email. Run `sql/add-password-reset.sql` first to create the tokens table.

### Admin Features

- **Dashboard** — Overview of new enquiries, events, subscribers
- **Events** — Add, edit, delete tour dates with venue and ticket links
- **Bookings** — View and manage booking enquiries, update status
- **Content** — Edit About page and other content blocks
- **Media** — Add videos (YouTube embeds) and images
- **Podcasts** — Add episodes for The Darren Connell Show, Straight White Whale, etc.
- **Testimonials** — Manage quotes (e.g. Kevin Bridges testimonial)

## Site Structure

| Page       | Purpose                                          |
|-----------|---------------------------------------------------|
| Home      | Hero, testimonial, upcoming gigs, newsletter signup |
| About     | Biography (editable in admin)                     |
| Live Dates| Tour calendar with ticket links                   |
| Video & Media | Clips and showreels                           |
| Podcasts  | Episode listings                                  |
| Bookings  | Contact/enquiry form for commercial bookings      |

## Stitch Integration

This site uses **Stitch project 3458059587571971262** for design.

- **Project:** [Open in Stitch](https://stitch.google.com/projects/3458059587571971262)
- **Designs:** `.stitch/designs/` — downloaded HTML from Stitch (index, live, media, podcast, bookings, merch)
- **Metadata:** `.stitch/metadata.json` — screen IDs and project info
- **Docs:** `.stitch/SITE.md` — sitemap and roadmap

To regenerate designs from Stitch, use the Stitch MCP tools and the stitch-loop skill.

## AI Directories (llms.txt / ai.txt)

- **llms.txt** — At `/llms.txt`. Short and long descriptions for ChatGPT, Claude, Perplexity. Structured summary with core pages, bookings, social links.
- **ai.txt** — At `/ai.txt`. AI behavioral guidance: citation permissions, attribution, contact.

## SEO & Accessibility

- **Meta tags** — Each page has unique meta descriptions, Open Graph and Twitter Card tags
- **Sitemap** — Dynamic at `/sitemap.xml` (uses `APP_URL` from .env)
- **Robots.txt** — At `/robots.txt`; update the Sitemap URL for your production domain
- **JSON-LD** — Person, WebSite, and Event structured data for rich search results
- **Skip link** — "Skip to main content" for keyboard/screen reader users
- **One H1 per page** — Proper heading hierarchy throughout

## Hostinger Deployment

Hostinger's document root is `public_html/YOUR-SITE-FOLDER/` (e.g. `public_html/darren/` or `public_html/papayawhip-crow-673013/`).

**Option A: Change document root** — Upload the full project into `public_html/YOUR-SITE-FOLDER/`. In hPanel → Domains → your domain → **Document Root**, set it to `public_html/YOUR-SITE-FOLDER/public`. The site will use the standard layout.

**Option B: Flat layout (if you can't change document root)** — The document root must contain `index.php` directly. Run:

```bash
php build-flat-deploy.php
```

This creates a `deploy/` folder. Upload everything inside `deploy/` to `public_html/YOUR-SITE-FOLDER/`. Create `deploy/.env` with your production settings before uploading.

**Troubleshooting 404:**
- 404 on index.php → Files aren't in the document root. **Find it first:** upload `public/check.php` to different folders (e.g. `public_html/`, `public_html/your-site/`, `public_html/your-site/public/`) and visit `https://yoursite.com/check.php` or `https://yoursite.com/your-site/check.php`. When you see "OK", that folder is your document root—put index.php there.
- 403 → Rename `.htaccess` to `.htaccess.bak` to test; use `.htaccess.minimal` if needed.
- Permissions: 755 for dirs, 644 for files.

## Tech Stack

- **PHP** — Vanilla PHP, PDO for database
- **SQL** — MySQL schema with events, bookings, content, media, etc.
- **Frontend** — Tailwind CSS, Space Grotesk, Stitch design system
- **Design** — Dark theme, primary #f46a25, mobile-first
