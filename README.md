# PCOSWEB — PC One Stop Marketing Website

Fast, static replacement for the old WordPress/Elementor site at **pconestop.co.za**,
designed to hand off cleanly to the live shop at **shop.pconestop.co.za**.

## Structure
- `scrape/` — full archive of the old site + shop structure (content inventory, asset manifest, raw page dumps)
- `site/` — the new website (deploys to `public_html`)

## URLs that must keep working
- `/` `/about/` `/contact-us/` — the shop footer links to `/contact-us/`.

## Workflow
Edit → commit → push → deploy `site/` contents to `public_html`.
