# PC One Stop — Full Content Inventory (scraped 2026-07-17)

Source: https://pconestop.co.za (WordPress + Elementor 3.28.4 — the "heavy/bulky" stack being replaced)
Shop: https://shop.pconestop.co.za (new, live, PHP + Yoco checkout)

---

## 1. Brand / Identity

- **Name:** PC One Stop (PC ONE STOP (PTY) Ltd)
- **Tagline:** "Your Trusted IT Solutions" (used on old site AND new shop — keep)
- **Secondary line (old title tag):** "Sales, Support and more"
- **Meta description (old):** "More than just IT - specialists with a trusted reputation that cares for clients. We are at the forefront of client satisfaction."
- **Mascot:** Robot character (appears on old site + new shop `assets/img/robot.png`)
- **Old footer credit:** "Designed by: Fox Creative — Copyright PC One Stop © 2021"

## 2. Contact Information

| Field   | Value |
|---------|-------|
| Email (public) | info@pconestop.co.za |
| Email (mailto target on old contact page) | william@pconestop.co.za |
| Email (shop orders) | orders@pconestop.co.za |
| Phone (landline) | 087 265 9230 → tel:+27872659230 |
| Cell | 076 998 7360 → tel:+27769987360 |
| Address | 58 Mitchell Street, Meyerton, 1961, Gauteng |
| Map embed | maps.google.com q=58 Mitchell Street, Meyerton, 1961 (PC One Stop), z=18 |

## 3. Services (12 — from About page "Service Specialities")

1. **Network Installations, Repairs and Support** — Installing whole new networks, new network points, adding to existing networks. Fault finding, network diagnostics and other network related support.
2. **Software/Hardware Sales and Support** — Sale of all popular software and hardware spanning many brands. Nothing is out of reach when it comes to software and hardware.
3. **CCTV Installations and Support** — Coaxial and IP based camera installations. Maintenance and fault-finding on existing surveillance infrastructure.
4. **Server Installations and Support** — New server installations and setups of Domain Controllers. Complete setup of Active Directory, network shares, Group Policies and more.
5. **Internet Sales and Support** — Partnered with various ISPs; a solution for every internet need, personal or business.
6. **E-mail and Website Services and Support** — Domains, email hosting, website creation/management, plus maintenance plans.
7. **Wireless Solutions and Support** — Home wireless networks through enterprise-level wireless with full RADIUS support for business.
8. **VoIP Sales and Support** — Cloud PABX technology; flexibility and control for business calls.
9. **Access Control and Support** — Biometrics, tags, cards, and other access control and clocking solutions tailored to business needs.
10. **Enterprise Antivirus Sales and Support** — Endpoint protection, server security, threat patching, deployment and management at enterprise level.
11. **Cloud Solutions Sales and Support** — Remote/cloud servers running terminal services; cloud servers for accounting software, accessible anywhere.
12. **Remote Access Setup and Support** — Terminal servers on-site or in the cloud, VPN tunnel setup, DynDNS access, port forwarding.

## 4. Support features (homepage blurbs)

- Quick responses and resolutions ("Unresolved problems can be a thing of the past")
- Remote support — resolve software problems without a site visit
- Support tickets — track logged calls, frequent updates and progress reports
- Broad infrastructure support — VoIP phones, IP cameras, other enterprise solutions

## 5. Brand Portfolio (24 partners — typos on old site FIXED here)

Microsoft · Office (Outright) · Office 365 · SanDisk · Seagate · **Samsung** (was "Samesung") · HikVision · Western Digital · **Transcend** (was "Trancend") · AMD · Lenovo · ASUS · Acer · Dell · Toshiba · Mecer · MSI · Logitech · Canon · Brother · Intel · HP · Compaq · NVIDIA

Homepage strip subset: HikVision, Microsoft, Logitech, AMD, Lenovo, Dell, Canon, SanDisk, Intel.

## 6. Old homepage "Top Specials" (2021 pricing — stale, replace with live shop data)

- SanDisk Cruzer Blade USB 32GB — R 69.00
- Logitech M185 Wireless Optical — R 209.00
- KWG Orion M1 RGB Gaming Mouse — R 229.00
- KWG Aries E1 2-in-1 Keyboard Mouse Combo — R 229.00
(Each had an inline "Quote Request" form: name, email, subject, quantity, message)

## 7. Old site structure & pages

- `/` Home — hero, Top Specials, "Your IT specialist that Cares", 4 support blurbs, brand strip, CTAs to About
- `/about/` — Service Specialities (12), Full Brand Portfolio (24), contact form
- `/contact-us/` — inquiry form (name, email, contact number, subject, message), contact methods, Google Map
- Anchors used: `/about#services`, `/about/#brand-portfolio`, `#map-location`

## 8. NEW SHOP (shop.pconestop.co.za) — what the frontend must link to

**Pages:** `/shop.php` (all + `?cat=` + `?sort=newest`), `/product.php?slug=…`, `/cart.php`, `/track.php`, `/shipping.php`, `/returns.php`

**Categories (with product counts at scrape time):**
| Category | Slug | Count |
|---|---|---|
| Computer peripherals | computer-peripherals | 733 |
| Components | components | 728 |
| Networking & security | networking-security | 161 |
| Lifestyle & home tech | lifestyle-home-tech | 130 |
| Computers | computers | 129 |
| Power | power | 126 |
| Software | software | 58 |
| Mobile | mobile | 11 |
| Cables | cables | — |
| Appliances | appliances | — |
| Bags & luggage | bags-luggage | — |
| TV & audio | tv-audio | — |

**Shop value props (reuse on marketing site):** Live stock levels · Secure Yoco checkout · Free delivery on larger orders · Nationwide courier · Orders processed 24–48h · Delivery 3–7 business days · 30-day returns
**Shop hero copy:** "Everything for your PC build & setup — in one place." / "Thousands of genuine components, peripherals and tech accessories with live stock and fast nationwide delivery."
**Shop footer "Contact Us" currently points at** `https://pconestop.co.za/contact-us/` → new site MUST keep this URL alive (or the shop nav breaks).

## 9. Notes for redesign

- Old stack: WordPress + Elementor + Google Fonts + Site Kit/AdSense platform tags = the bulk. Replacement: static.
- Preserve URLs old site exposed publicly: `/`, `/about/`, `/contact-us/` (shop links here!), ideally `/home/` → redirect to `/`.
- Robot mascot is the one consistent brand asset across old site and new shop — strong candidate for the visual bridge.
- Tone of old copy: friendly, care-driven, "specialist that listens". Some grammar issues in original copy ("will bring will put a smile") — rewrite.
