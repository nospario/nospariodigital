# Nospario Digital

Server-rendered PHP marketing site for Nospario Digital — a one-page site
(hero, services, about, pricing, testimonials, FAQ, contact, support/status)
plus a Privacy & Cookie Policy page.

Plain PHP 8.1+, no build step. Drops onto standard LAMP / shared hosting.

## Project layout

```
public/            ← document root (the ONLY web-accessible directory)
  index.php          home page
  privacy.php        privacy & cookie policy
  contact.php        form endpoint shim → handlers/contact.php
  ticket.php         form endpoint shim → handlers/ticket.php
  .htaccess          pretty URLs, HTTPS, caching, security headers
  robots.txt, sitemap.xml, site.webmanifest, favicons
  assets/            css / js / img / logos / fonts
src/               ← PHP logic + templates (NOT web-accessible)
  config.php         constants, nav, .env loader
  partials/          head.php, header.php, footer.php
  sections/          home-page sections
  data/              services, faqs, testimonials, policy content
  lib/               helpers.php, forms.php, mailer.php
handlers/          ← form processors (contact, ticket)
.env.example       SMTP creds + recipient (copy to .env)
```

## Run locally

```bash
cp .env.example .env        # then edit as needed
php -S localhost:8000 -t public
```

Open <http://localhost:8000>. The built-in server runs `index.php` for `/`.

> Note: the PHP built-in server does not process `.htaccess`, so the pretty URL
> `/privacy` resolves via the rewrite only on Apache. Locally, use
> `/privacy.php`. Forms post to `/contact.php` and `/ticket.php`, which work in
> both environments.

## Run with Docker

The image uses Apache + PHP 8.3, so the `public/.htaccess` rules (pretty URLs,
caching, security headers, gzip) all apply — unlike the PHP built-in server.

```bash
cp .env.example .env        # optional, but needed for SMTP
docker compose up --build
```

Then open <http://localhost:8088>. Pretty URLs work here (`/privacy`), and the
container is `healthy` once Apache responds.

- **Document root** is `/var/www/html/public`; `src/` and `handlers/` sit
  outside it and are not web-accessible.
- **PHPMailer** is installed at build time (stage 1) so the contact/ticket
  forms can send over SMTP — set `SMTP_*` in `.env`. Without an MTA or SMTP,
  submissions validate but report a send failure (by design).
- `.env`, the prototype files (`*.dc.html`, `image-slot.js`, `support.js`,
  `uploads/`) and `vendor/` are excluded from the image via `.dockerignore`.
- Change the published port by editing `ports` in `docker-compose.yml`
  (e.g. `"8080:80"`), or run directly:
  `docker build -t nospario-web . && docker run -p 8080:80 --env-file .env nospario-web`.

For live-editing during development, uncomment the `volumes:` block in
`docker-compose.yml`.

## Email / forms

- Forms POST to `handlers/contact.php` and `handlers/ticket.php` (via the
  `public/*.php` shims), with server-side validation, a honeypot, and a
  minimum-time spam check.
- Mail is sent to `MAIL_TO`. If `SMTP_HOST` is set **and** PHPMailer is
  installed (`composer require phpmailer/phpmailer`), it sends over SMTP;
  otherwise it falls back to PHP's `mail()`.
- JS progressively enhances the forms (inline success panel); without JS they
  do a normal POST + redirect (`/?sent=contact#contact`).

## Live status

`assets/js/status.js` fetches the Heart Internet status feed
(`https://www.heartstatus.uk/index.json`) client-side, refreshes every 120s,
and updates the status banner/rows. The server renders an "all operational"
fallback first, and the script fails silently if the feed is unreachable.

## Colour palettes

Five palettes (Blush, Peach, Rose Grey, Mauve, Slate Blue) are defined as CSS
custom properties in `assets/css/styles.css`. **Blush** is the default. To
switch, set `data-palette="Peach"` (etc.) on the `<html>` element — no UI
switcher ships on the live site.

## Fonts

Hanken Grotesk loads from Google Fonts (`font-display:swap`). For best
performance/privacy, drop the woff2 files into `assets/fonts/` and swap the
`<link>` in `src/partials/head.php` for a self-hosted `@font-face` block.

## Deploy (Heart Internet / shared hosting)

1. Upload everything **except** the prototype files (`*.dc.html`, `image-slot.js`,
   `support.js`, `uploads/`) and your real `.env`.
2. Point the domain's document root at `public/`.
3. If the doc root cannot be moved, the bundled `src/.htaccess` and
   `handlers/.htaccess` (`Require all denied`) keep that logic private; adjust
   include paths only if you restructure.
4. Create `.env` from `.env.example` and set SMTP + recipient.
5. Confirm HTTPS, then optionally enable HSTS in `public/.htaccess`.

## Replace the placeholder assets

- `public/assets/img/richard.jpg` — founder photo (4:5). Until added, the About
  card shows a styled "Richard" placeholder.
- `public/assets/img/og-image.jpg` — generated 1200×630 social card; replace
  with a designed version if preferred.
- Favicons (`favicon.svg`, `favicon.ico`, `apple-touch-icon.png`) are generated
  from the brand mark; swap for final artwork when ready.
```
