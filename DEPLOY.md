# Deploying pconestop.co.za

## 0. Requirements
- PHP 8.0+ on the hosting (form + live products endpoints use it; shop already runs PHP so you're fine)
- Apache with `.htaccess` enabled (standard on cPanel hosting)

## 1. Grab the images (BEFORE wiping the old public_html)
The old WordPress `wp-content/uploads` still holds every brand logo. Either:
- **On the server:** copy the files listed in `scrape/assets-manifest.md` into `site/assets/img/brands/` (keep the same filenames), or
- **From your PC:** run the curl script at the bottom of `scrape/assets-manifest.md`.

Also drop in:
- `site/assets/img/favicon.png` ← copy of `wp-content/uploads/2021/03/cropped-android-chrome-512x512-1-270x270.png`

Logo + robot are referenced live from `shop.pconestop.co.za/assets/img/` — nothing to copy, works day one. (Optional later: localize them too and update the 4 `<img src>` references for one fewer DNS lookup.)

## 2. Upload
Upload the **contents of `site/`** into `public_html/` (including the hidden `.htaccess`).
Old WordPress files can be deleted or moved to a `_old/` folder outside the web root.

## 3. Configure
- `site/api/contact.php` — top of file: confirm `MAIL_TO` (currently info@pconestop.co.za) and that `no-reply@pconestop.co.za` exists as a mailbox/sender on your hosting (create it in cPanel → Email if not; improves deliverability massively).
- Nothing to configure in `featured.php` — it reads the live shop and caches for 15 min.

## 4. GitHub
Create an empty repo on github.com (e.g. `pcosweb`), then from this project folder:

```bash
git remote add origin git@github.com:YOUR_USER/pcosweb.git   # or the https URL
git push -u origin main
```

Day-to-day: edit → `git add -A && git commit -m "..." && git push` → upload changed files
(or set up cPanel Git™ Version Control to pull from the repo automatically).

## 5. Post-launch checks
- [ ] https://pconestop.co.za/ loads, hero robot + logo visible
- [ ] "Live from the shop" section shows products (visit /api/featured.php directly — should return JSON)
- [ ] Contact form sends (check inbox AND spam the first time)
- [ ] /about/ and /contact-us/ load — shop footer "Contact Us" link works
- [ ] /home/ redirects to /
- [ ] Brand logos visible (if not: step 1 wasn't done)
