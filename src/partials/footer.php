<?php
/**
 * Dark site footer. Shared component.
 */

declare(strict_types=1);

require_once __DIR__ . '/../config.php';
?>
</main>

<footer class="site-footer">
  <div class="site-footer__inner">
    <div class="site-footer__top">
      <div class="site-footer__brand">
        <img src="<?= e(asset('logos/nospario-white.svg')) ?>" alt="<?= e(SITE_NAME) ?>" width="200" height="68">
        <p class="site-footer__tagline">Websites, software &amp; hosting for small businesses and start-ups.</p>
      </div>

      <div class="site-footer__col">
        <div class="site-footer__heading">Explore</div>
        <div class="site-footer__links">
          <a href="/#services">Services</a>
          <a href="/#pricing">Pricing</a>
          <a href="/#about">About</a>
          <a href="/#contact">Contact</a>
          <a href="/#support">Support &amp; status</a>
        </div>
      </div>

      <div class="site-footer__col">
        <div class="site-footer__heading">Get in touch</div>
        <div class="site-footer__links">
          <a href="mailto:<?= e(CONTACT_EMAIL) ?>"><?= e(CONTACT_EMAIL) ?></a>
          <a href="tel:<?= e(CONTACT_PHONE_TEL) ?>"><?= e(CONTACT_PHONE_DISPLAY) ?></a>
          <a href="/#status" class="site-footer__status" data-status-footer>
            <span class="status-dot" data-status-dot></span>
            <span data-status-text>All systems operational</span>
          </a>
        </div>
      </div>
    </div>

    <div class="site-footer__bottom">
      <span>&copy; <?= date('Y') ?> <?= e(SITE_NAME) ?>. All rights reserved.</span>
      <span class="site-footer__legal">
        <a href="/privacy">Privacy &amp; Cookie Policy</a>
        <span>Designed &amp; built in-house.</span>
      </span>
    </div>
  </div>
</footer>

<script src="<?= e(asset('js/main.js')) ?>" defer></script>
<script src="<?= e(asset('js/status.js')) ?>" defer></script>
</body>
</html>
