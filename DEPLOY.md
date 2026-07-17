# Deploying pconestop.co.za

## 0. Requirements
- PHP 8.0+ on the hosting (form + live products endpoints use it; shop already runs PHP so you're fine)
- Apache with `.htaccess` enabled (standard on cPanel hosting)

## 1. Images — already done ✓
All 24 brand logos and the favicon are already committed in `site/assets/img/` —
they were pulled from the old WordPress `wp-content/uploads` and archived
(originals also kept in `scrape/original-art/`). Nothing to grab before wiping
the old `public_html`; they'll come along with the upload in step 2.

Logo + robot mascot are referenced live from `shop.pconestop.co.za/assets/img/` —
nothing to copy, works day one. (Optional later: localize them too and update
the 4 `<img src>` references for one fewer DNS lookup.)

## 2. Upload
Upload the **contents of `site/`** into `public_html/` (including the hidden `.htaccess`).
Old WordPress files can be deleted or moved to a `_old/` folder outside the web root.

## 3. Configure
- `site/api/contact.php` — top of file: confirm `MAIL_TO` (currently info@pconestop.co.za) and that `no-reply@pconestop.co.za` exists as a mailbox/sender on your hosting (create it in cPanel → Email if not; improves deliverability massively).
- Nothing to configure in `featured.php` — it reads the live shop and caches for 15 min.

## 4. GitHub — already set up ✓
Repo is live at `git@github.com:thePopeZA/pconestopweb.git` (private), pushed and current.

Day-to-day: edit → `git add -A && git commit -m "..." && git push` → upload changed files
(or set up cPanel Git™ Version Control on the host to pull from the repo automatically —
see `pconestopshop/DEPLOY.md` §1 for the exact cPanel steps, same process here).

## 5. Post-launch checks
- [ ] https://pconestop.co.za/ loads, hero robot + logo visible
- [ ] "Live from the shop" section shows products (visit /api/featured.php directly — should return JSON)
- [ ] Contact form sends (check inbox AND spam the first time)
- [ ] /about/ and /contact-us/ load — shop footer "Contact Us" link works
- [ ] /home/ redirects to /
- [ ] Brand logos visible on home + about (if not: `site/assets/img/brands/` didn't upload)
