<?php
/**
 * featured.php — live products for the marketing homepage.
 * Server-side fetches the shop homepage, parses product cards, caches 15 min.
 * Zero changes required on the shop. If parsing ever fails, returns {"products":[]}
 * and the homepage section quietly hides itself.
 *
 * Upgrade path (optional, later): add a tiny read-only endpoint on the shop that
 * queries its own DB and returns JSON, then point SHOP_URL at that instead.
 */

declare(strict_types=1);

const SHOP_URL   = 'https://shop.pconestop.co.za/';
const SHOP_BASE  = 'https://shop.pconestop.co.za/';
const CACHE_FILE = __DIR__ . '/.featured-cache.json';
const CACHE_TTL  = 900;   // 15 minutes
const MAX_ITEMS  = 8;

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: public, max-age=300');

/* serve fresh cache */
if (is_file(CACHE_FILE) && (time() - (int) filemtime(CACHE_FILE)) < CACHE_TTL) {
    readfile(CACHE_FILE);
    exit;
}

function fetch_html(string $url): ?string
{
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_MAXREDIRS      => 3,
        CURLOPT_CONNECTTIMEOUT => 5,
        CURLOPT_TIMEOUT        => 8,
        CURLOPT_USERAGENT      => 'PCOS-Marketing/1.0 (+https://pconestop.co.za)',
    ]);
    $html = curl_exec($ch);
    $code = (int) curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
    curl_close($ch);
    return (is_string($html) && $code === 200 && $html !== '') ? $html : null;
}

function parse_products(string $html): array
{
    $products = [];
    $seen = [];

    $doc = new DOMDocument();
    libxml_use_internal_errors(true);
    $doc->loadHTML('<?xml encoding="utf-8"?>' . $html, LIBXML_NOWARNING | LIBXML_NOERROR);
    libxml_clear_errors();
    $xp = new DOMXPath($doc);

    /* every heading link that points at a product page = one product card */
    foreach ($xp->query('//a[contains(@href,"product.php?slug=")]') as $a) {
        $name = trim(preg_replace('/\s+/', ' ', $a->textContent));
        if ($name === '' || mb_strlen($name) < 4) {
            continue; /* image-only anchors — the heading anchor will follow */
        }
        $href = $a->getAttribute('href');
        $url  = str_starts_with($href, 'http') ? $href : SHOP_BASE . ltrim($href, '/');
        if (isset($seen[$url])) {
            continue;
        }

        /* climb to the card container, then read its pieces */
        $card = $a;
        for ($i = 0; $i < 5 && $card->parentNode instanceof DOMElement; $i++) {
            $card = $card->parentNode;
            $txt  = $card->textContent;
            if (preg_match('/R\s?[\d\s\x{00A0}]+[.,]\d{2}/u', $txt)) {
                break;
            }
        }
        $cardTxt = preg_replace('/\s+/u', ' ', $card->textContent);
        /* the SAVE badge amount is not a price */
        $cardTxt = preg_replace('/SAVE\s*R[\d\s\x{00A0}.,]+/iu', ' ', $cardTxt);

        /* prices: first = current, second = old (strikethrough) */
        preg_match_all('/R\s?[\d\s\x{00A0}]{1,12}[.,]\d{2}/u', $cardTxt, $m);
        $prices = array_map(
            static fn($p) => 'R ' . trim(preg_replace('/[^\d.,]/u', ' ', preg_replace('/\x{00A0}/u', ' ', $p))),
            $m[0] ?? []
        );
        if (!$prices) {
            continue;
        }

        /* the thumbnail lives in a sibling .thumb anchor, so the price container
           alone often has no <img>; widen the search to its parent as a fallback */
        $img    = '';
        $scopes = [$card];
        if ($card->parentNode instanceof DOMElement) {
            $scopes[] = $card->parentNode;
        }
        foreach ($scopes as $scope) {
            foreach ($xp->query('.//img', $scope) as $imgNode) {
                $src = $imgNode->getAttribute('src') ?: $imgNode->getAttribute('data-src');
                if ($src && !str_contains($src, 'logo') && !str_contains($src, 'flag')
                    && !str_contains($src, 'placeholder')) {
                    $img = $src;
                    break 2;
                }
            }
        }

        $stock = '';
        if (preg_match('/(Low stock|In stock|Out of stock)/i', $cardTxt, $s)) {
            $stock = $s[1];
        }

        /* brand: short standalone line right before the heading, if present */
        $brand = '';
        $prev  = $a->parentNode?->previousSibling;
        while ($prev && trim($prev->textContent) === '') {
            $prev = $prev->previousSibling;
        }
        if ($prev) {
            $b = trim($prev->textContent);
            if ($b !== '' && mb_strlen($b) <= 24 && stripos($name, $b) !== false) {
                $brand = $b;
            } elseif ($b !== '' && mb_strlen($b) <= 24 && !preg_match('/R\s?\d/', $b)) {
                $brand = $b;
            }
        }

        $seen[$url] = true;
        $products[] = [
            'name'  => $name,
            'url'   => $url,
            'image' => $img,
            'brand' => $brand,
            'price' => $prices[0],
            'was'   => $prices[1] ?? null,
            'stock' => $stock,
        ];
        if (count($products) >= MAX_ITEMS) {
            break;
        }
    }

    return $products;
}

$html = fetch_html(SHOP_URL);
$out  = ['products' => $html ? parse_products($html) : [], 'ts' => time()];

/* keep serving the previous cache if this refresh came back empty */
if (!$out['products'] && is_file(CACHE_FILE)) {
    touch(CACHE_FILE);
    readfile(CACHE_FILE);
    exit;
}

$json = json_encode($out, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
@file_put_contents(CACHE_FILE, $json, LOCK_EX);
echo $json;
