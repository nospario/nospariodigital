<?php
/**
 * Site header + mobile slide-out drawer. Shared component.
 * Expects the global $NAV (from config.php) and the page's $page array.
 */

declare(strict_types=1);

require_once __DIR__ . '/../config.php';

/** @var array $NAV */
$nav         = $NAV ?? [];
$currentPath = $page['path'] ?? '/';

/** A nav link is "current" only when it targets a full page (no #fragment) that matches. */
$isCurrent = static function (string $href) use ($currentPath): bool {
    if (str_contains($href, '#')) {
        return false;
    }
    return rtrim($href, '/') === rtrim($currentPath, '/');
};
?>
<header class="site-header">
  <div class="site-header__inner">
    <a href="/" class="site-header__logo" aria-label="<?= e(SITE_NAME) ?>">
      <img src="<?= e(asset('logos/nospario-dark.svg')) ?>" alt="<?= e(SITE_NAME) ?>" width="180" height="64">
    </a>

    <nav class="nav nav--desktop" aria-label="Primary">
      <?php foreach ($nav as $link): ?>
        <a href="<?= e($link['href']) ?>" class="nav__link"<?= $isCurrent($link['href']) ? ' aria-current="page"' : '' ?>><?= e($link['label']) ?></a>
      <?php endforeach; ?>
      <a href="/#contact" class="btn btn--primary nav__cta">Get a quote</a>
    </nav>

    <button type="button" class="nav-toggle" aria-label="Menu" aria-expanded="false" aria-controls="mobile-menu" data-menu-open>
      <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><line x1="3" y1="7" x2="21" y2="7"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="17" x2="21" y2="17"/></svg>
    </button>
  </div>
</header>

<!-- Mobile slide-out menu -->
<div class="menu-overlay" data-menu-close hidden></div>
<aside id="mobile-menu" class="mobile-menu" aria-hidden="true" aria-label="Mobile navigation">
  <div class="mobile-menu__head">
    <img src="<?= e(asset('logos/nospario-dark.svg')) ?>" alt="<?= e(SITE_NAME) ?>" width="135" height="48">
    <button type="button" class="nav-toggle" aria-label="Close menu" data-menu-close>
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><line x1="6" y1="6" x2="18" y2="18"/><line x1="18" y1="6" x2="6" y2="18"/></svg>
    </button>
  </div>
  <nav class="mobile-menu__nav" aria-label="Primary mobile">
    <?php foreach ($nav as $link): ?>
      <a href="<?= e($link['href']) ?>" class="mobile-menu__link" data-menu-close><?= e($link['label']) ?></a>
    <?php endforeach; ?>
    <a href="/#contact" class="btn btn--primary mobile-menu__cta" data-menu-close>Get a quote</a>
  </nav>
</aside>

<main id="main">
