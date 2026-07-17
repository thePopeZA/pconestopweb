# Asset Manifest — every image found in the scrape

> Sandbox can't reach pconestop.co.za directly (network allowlist), but YOU have server
> access — these files already sit in the current public_html/wp-content. Grab them from
> there (or run the fetch-assets script below from your own machine) before the old site
> is wiped. Shop assets live on the server too under the shop's docroot.

## Priority assets (brand-critical)

| Asset | URL |
|---|---|
| Logo (wide, transparent) | https://pconestop.co.za/wp-content/uploads/2021/02/Logoalone-1024x271.png |
| Logo w/ tagline (redraw) | https://pconestop.co.za/wp-content/uploads/elementor/thumbs/Logo-redraw-rj52ysh0i2epb9ua4rpn06hnfhvpamtdcx05phn9x0.png |
| Favicon / tile 512 | https://pconestop.co.za/wp-content/uploads/2021/03/cropped-android-chrome-512x512-1-270x270.png |
| Robot w/ CD (home) | https://pconestop.co.za/wp-content/uploads/2021/02/Robot_CDno-bg-1024x640.png |
| Robot presenting (about) | https://pconestop.co.za/wp-content/uploads/2021/03/robot_presenting-no-bg-e1614635122849.png |
| Shop logo (current) | https://shop.pconestop.co.za/assets/img/logo.png |
| Shop robot (current) | https://shop.pconestop.co.za/assets/img/robot.png |
| Shop ZA flag | https://shop.pconestop.co.za/assets/img/flag-za.svg |

## Brand logos (24) — base: https://pconestop.co.za/wp-content/uploads/

2021/02/Microsoft_logo-300x64.png · 2021/02/Microsoft_Office_icons_Logo-300x128.png · 2021/02/Microsoft_Office365_icons_Logo-300x109.png · 2021/02/SanDisk_logo-1-300x58.png · 2021/02/Seagate_logo-300x100.png · 2021/02/samsung_logo-300x47.png · 2021/02/Hikvision_logo-300x42.png · 2021/02/Western_Digital_logo-300x107.png · 2021/02/Transcend_logo-300x59.png · 2021/02/AMD_logo-300x123.png · 2021/02/Lenovo_logo-300x63.png · 2021/02/ASUS_logo-300x60.png · 2021/02/Acer_logo-300x72.png · 2021/02/Dell_Logo-1-300x91.png · 2021/02/Toshiba_logo-300x46.png · 2021/02/Mecer_logo-300x88.png · 2021/02/Msi_Logo-300x94.png · 2021/02/logitech_logo2-300x77.png · 2021/02/Canon_logo-300x63.png · 2021/02/brother_logo-300x68.png · 2021/03/intel_logo-300x123.png · 2021/03/HP_logo-300x123.png · 2021/03/Compaq_logo-300x123.png · 2021/03/nvidia_logo-300x123.png

(768px versions exist at same paths with -768x… suffix; Mecer full-size at 2021/02/Mecer_logo.png)

## Old product shots (2021 specials — only needed if kept)

2021/02/sandisk_cruzer_blade_photo5_1.jpg · 2021/02/m185_color.jpg · 2021/02/b50760a9c3.jpg · 2021/02/ARIESE1-1024x539.jpg

## Fetch script (run on YOUR machine / server, not sandbox)

```bash
mkdir -p assets/brands && cd assets
base="https://pconestop.co.za/wp-content/uploads"
curl -O "$base/2021/02/Logoalone-1024x271.png"
curl -O "$base/2021/02/Robot_CDno-bg-1024x640.png"
curl -O "$base/2021/03/robot_presenting-no-bg-e1614635122849.png"
curl -O "https://shop.pconestop.co.za/assets/img/logo.png"
curl -O "https://shop.pconestop.co.za/assets/img/robot.png"
cd brands
for f in 2021/02/Microsoft_logo-300x64.png 2021/02/SanDisk_logo-1-300x58.png \
  2021/02/Seagate_logo-300x100.png 2021/02/samsung_logo-300x47.png \
  2021/02/Hikvision_logo-300x42.png 2021/02/Western_Digital_logo-300x107.png \
  2021/02/Transcend_logo-300x59.png 2021/02/AMD_logo-300x123.png \
  2021/02/Lenovo_logo-300x63.png 2021/02/ASUS_logo-300x60.png \
  2021/02/Acer_logo-300x72.png 2021/02/Dell_Logo-1-300x91.png \
  2021/02/Toshiba_logo-300x46.png 2021/02/Mecer_logo-300x88.png \
  2021/02/Msi_Logo-300x94.png 2021/02/logitech_logo2-300x77.png \
  2021/02/Canon_logo-300x63.png 2021/02/brother_logo-300x68.png \
  2021/03/intel_logo-300x123.png 2021/03/HP_logo-300x123.png \
  2021/03/Compaq_logo-300x123.png 2021/03/nvidia_logo-300x123.png \
  2021/02/Microsoft_Office_icons_Logo-300x128.png 2021/02/Microsoft_Office365_icons_Logo-300x109.png; do
  curl -O "$base/$f"
done
```
