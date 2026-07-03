<?php
/**
 * Services grid. Expects $services (from data/services.php).
 */

declare(strict_types=1);

/** @var array $services */
$services = $services ?? load_data('services');

// Inline SVG paths keyed by service icon.
$icons = [
    'web'       => '<rect x="3" y="4" width="18" height="16" rx="2"/><path d="M3 9h18"/><path d="M6 6.5h.01M8.5 6.5h.01"/>',
    'hosting'   => '<rect x="3" y="4" width="18" height="6" rx="1.5"/><rect x="3" y="14" width="18" height="6" rx="1.5"/><path d="M7 7h.01M7 17h.01"/>',
    'domains'   => '<circle cx="12" cy="12" r="9"/><path d="M3 12h18"/><path d="M12 3a15 15 0 0 1 0 18 15 15 0 0 1 0-18Z"/>',
    'email'     => '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/>',
    'software'  => '<polyline points="8 7 4 12 8 17"/><polyline points="16 7 20 12 16 17"/>',
    'webapp'    => '<rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/>',
    'fullstack' => '<path d="m12 3 9 5-9 5-9-5 9-5Z"/><path d="m3 12 9 5 9-5"/><path d="m3 16 9 5 9-5"/>',
    'support'   => '<circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="3.5"/><path d="m4.9 4.9 4.3 4.3M14.8 14.8l4.3 4.3M14.8 9.2l4.3-4.3M9.2 14.8l-4.3 4.3"/>',
];
?>
<section id="services" class="section section--services">
  <div class="container">
    <span class="eyebrow">What we do</span>
    <h2 class="section__title">Everything to get you online — and keep you there.</h2>
    <p class="section__lead">From the first wireframe to the email that lands in your inbox, it's all handled by one person.</p>

    <div class="card-grid card-grid--services">
      <?php foreach ($services as $svc): ?>
        <?php $featured = !empty($svc['featured']); ?>
        <article class="card service-card<?= $featured ? ' service-card--featured' : '' ?>">
          <?php if ($featured): ?>
            <span class="service-card__badge">Most requested</span>
          <?php endif; ?>
          <div class="service-card__icon">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><?= $icons[$svc['icon']] ?? '' ?></svg>
          </div>
          <h3 class="service-card__title" id="<?= e($svc['id']) ?>"><?= e($svc['title']) ?></h3>
          <p class="service-card__desc"><?= e($svc['desc']) ?></p>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
