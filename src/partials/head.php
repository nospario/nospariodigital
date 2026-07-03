<?php
/**
 * <head> block + opening <html>/<body>. Driven by the $page array:
 *   $page = [
 *     'title'       => 'Page title',         // required
 *     'description' => 'Unique description',  // required
 *     'path'        => '/',                    // site-relative path (for canonical + active nav)
 *     'og_type'     => 'website',             // optional, defaults to 'website'
 *     'jsonld'      => [ ... ],                // optional array of structured-data blocks
 *   ];
 */

declare(strict_types=1);

require_once __DIR__ . '/../config.php';

$page        = $page ?? [];
$pageTitle   = $page['title'] ?? SITE_NAME;
$pageDesc    = $page['description'] ?? SITE_TAGLINE;
$pagePath    = $page['path'] ?? '/';
$ogType      = $page['og_type'] ?? 'website';
$canonical   = url(ltrim($pagePath, '/'));
$fullTitle   = $pagePath === '/'
    ? $pageTitle . ' | ' . SITE_NAME
    : $pageTitle . ' | ' . SITE_NAME;
$ogImage     = url('assets/img/og-image.jpg');
$jsonldBlocks = $page['jsonld'] ?? [];
?>
<!doctype html>
<html lang="en-GB">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title><?= e($fullTitle) ?></title>
  <meta name="description" content="<?= e($pageDesc) ?>">
  <meta name="robots" content="index,follow">
  <link rel="canonical" href="<?= e($canonical) ?>">

  <!-- Open Graph -->
  <meta property="og:type" content="<?= e($ogType) ?>">
  <meta property="og:title" content="<?= e($fullTitle) ?>">
  <meta property="og:description" content="<?= e($pageDesc) ?>">
  <meta property="og:url" content="<?= e($canonical) ?>">
  <meta property="og:image" content="<?= e($ogImage) ?>">
  <meta property="og:site_name" content="<?= e(SITE_NAME) ?>">
  <meta property="og:locale" content="en_GB">

  <!-- Twitter -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="<?= e($fullTitle) ?>">
  <meta name="twitter:description" content="<?= e($pageDesc) ?>">
  <meta name="twitter:image" content="<?= e($ogImage) ?>">

  <!-- Favicons / PWA -->
  <link rel="icon" href="/favicon.ico" sizes="any">
  <link rel="icon" href="/favicon.svg" type="image/svg+xml">
  <link rel="apple-touch-icon" href="/apple-touch-icon.png">
  <link rel="manifest" href="/site.webmanifest">
  <meta name="theme-color" content="#FCFBFA">

  <!-- Fonts: Hanken Grotesk. Self-host under /assets/fonts for best performance;
       this Google Fonts link is the documented fallback. font-display:swap is set. -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="<?= e(asset('css/styles.css')) ?>">

<?php foreach ($jsonldBlocks as $block): ?>
  <script type="application/ld+json"><?= json_encode($block, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
<?php endforeach; ?>
</head>
<body>
