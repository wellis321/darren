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

## Hostinger Deployment (fixing 403)

1. **Document root must point to the `public` folder.** In hPanel → Domains → your domain → Document Root, set it to `public_html/your-project/public` (or wherever your `public` folder lives). The web server must serve from `public/`, not the project root.

2. **Folder structure** — Upload the full project. The `public` folder should contain: `index.php`, `admin/`, `api/`, `assets/`, `.htaccess`, `robots.txt`, `sitemap.xml.php`, etc.

3. **Permissions** — Set 755 for directories, 644 for files (via File Manager).

4. **`.htaccess`** — The `public/.htaccess` sets `DirectoryIndex index.php` and routes clean URLs. If you still get 403, temporarily rename `.htaccess` to test; some Hostinger configs may conflict.

5. **`.env`** — Create `.env` in the project root (parent of `public`) with `APP_ENV=production`, `APP_URL=https://your-domain.com`, and your DB credentials.

## Tech Stack

- **PHP** — Vanilla PHP, PDO for database
- **SQL** — MySQL schema with events, bookings, content, media, etc.
- **Frontend** — Tailwind CSS, Space Grotesk, Stitch design system
- **Design** — Dark theme, primary #f46a25, mobile-first
