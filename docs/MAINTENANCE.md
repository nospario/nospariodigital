# Maintenance & troubleshooting

Practical notes for editing and running the site. For *how to run / deploy*,
see the top-level `README.md`; this doc covers *where things live* and the
gotchas worth knowing.

---

## Where the content lives

Almost all copy is data, separated from the templates. To change wording you
edit a PHP array — not the HTML.

| To change…                         | Edit                                   |
| ---------------------------------- | -------------------------------------- |
| Services (title, blurb, featured)  | `src/data/services.php`                |
| Main FAQ                           | `src/data/faqs.php` → `main`           |
| Support FAQ                        | `src/data/faqs.php` → `support`        |
| Testimonials                       | `src/data/testimonials.php`            |
| Privacy policy text + cookie table | `src/data/policy.php`                  |
| Email / phone                      | `src/config.php` (`CONTACT_*`)         |
| Nav links                          | `src/config.php` (`$NAV`)              |
| Canonical site URL                 | `.env` (`SITE_URL`) — see launch notes |
| Hero headline / lead / about prose | `src/sections/hero.php`, `about.php`   |
| Page `<title>` / meta description  | `public/index.php`, `public/privacy.php` (the `$page` array) |

Section *structure* lives in `src/sections/*.php`; the shared chrome is
`src/partials/{head,header,footer}.php`. Styling is one file:
`public/assets/css/styles.css`.

---

## Common edits

**Add or remove a service.** Edit `src/data/services.php`. ⚠️ The hero orbital
graphic does **not** read this file — it has its own hand-tuned list of 8 nodes
in `src/sections/hero.php` (`$orbitNodes`), because each node's orbit
ring/speed/angle is positioned by hand. If you add a 9th service, the grid
updates automatically but the orbit will not; add a matching node (and rebalance
the angles) in `hero.php` if you want it represented there.

**Change the colour palette.** Five palettes are defined in `styles.css`
(`:root` = Blush default, plus `[data-palette="…"]` blocks). To switch the live
site, set the attribute on the `<html>` tag in `src/partials/head.php`, e.g.
`<html lang="en-GB" data-palette="Slate Blue">`. No JS/UI switcher ships.

**Add the founder photo.** Drop a 4:5 image at
`public/assets/img/richard.jpg`. Until it exists, the About card shows a styled
"Richard" placeholder (handled by the `onerror` fallback in `about.php`).

**Self-host the font.** Put the Hanken Grotesk `.woff2` files in
`public/assets/fonts/` and replace the Google Fonts `<link>` in
`head.php` with an `@font-face` block (keeps `font-display:swap`).

---

## Gotchas

These bit me during the build; they're fixed in code but worth knowing.

- **`php -S` ignores `.htaccess`.** The built-in dev server does *not* apply
  pretty URLs, redirects, headers or caching. Locally use `/privacy.php` (not
  `/privacy`). For full fidelity, run the **Docker** image (Apache) instead.
- **Forms must keep their `.php` action.** They POST to `/contact.php` and
  `/ticket.php`. The `.htaccess` "strip `.php`" rule explicitly skips `POST`
  (`RewriteCond %{REQUEST_METHOD} !=POST`) so the body isn't lost to a 301. Don't
  remove that condition.
- **HTTPS redirect skips localhost.** `.htaccess` forces HTTPS in production but
  excludes `localhost`/`127.0.0.1` so local + Docker testing over http works.
- **Mail needs SMTP.** With no MTA/SMTP configured, forms validate but report a
  send failure (you'll see `?error=contact`). Set `SMTP_*` in `.env`; PHPMailer
  (installed in the Docker image) then delivers. On the bare PHP built-in server
  `mail()` may "succeed" only if the host has a sendmail path.
- **The site URL is hardcoded in two static files.** `public/robots.txt` and
  `public/sitemap.xml` contain the production URL literally (they're served as
  static files, so no PHP runs). If the domain changes, update them by hand in
  addition to `SITE_URL` in `.env`.

---

## Pre-launch checklist

- [ ] `.env` created: `SITE_URL`, `MAIL_TO`, `MAIL_FROM`, and `SMTP_*` set.
- [ ] Sent a real test through both the contact and ticket forms.
- [ ] `robots.txt` + `sitemap.xml` URLs match the live domain.
- [ ] Founder photo added at `assets/img/richard.jpg`.
- [ ] Replaced the generated `og-image.jpg` / favicons if final artwork exists.
- [ ] Document root points at `/public` on the host.
- [ ] HTTPS confirmed working, then enable HSTS in `public/.htaccess`
      (the line is present but commented).
- [ ] Ran Lighthouse (target 95+ across the board).

---

## Container quick reference

From the project root:

```bash
docker compose up -d --build   # build + start (http://localhost:8088)
docker compose ps              # status / health
docker compose logs -f web     # tail Apache logs
docker compose stop            # stop, keep container (stays in Docker Desktop)
docker compose start           # start it again
docker compose down            # remove container + network
```

Change the host port by editing `ports` in `docker-compose.yml`
(currently `8088:80`; 8080 was already in use on the build machine).
