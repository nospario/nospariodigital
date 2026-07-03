<?php
/**
 * Hero section, including the orbital "services orbiting the studio" graphic.
 * Per-node animation duration/delay/position stay inline (one-off); repeated
 * dot/label styling is promoted to CSS classes (.orbit-*).
 */

declare(strict_types=1);

// Orbit nodes: ring duration + per-node delay are unique, so they remain inline.
$orbitNodes = [
    // Inner ring (20s)
    ['href' => '#svc-web',       'label' => 'Web design',             'style' => 'solid',   'dur' => '20s', 'delay' => '0s',       'top' => '32.5%',
        'icon' => '<rect x="3" y="4" width="18" height="16" rx="2"/><path d="M3 9h18"/><path d="M6 6.5h.01M8.5 6.5h.01"/>'],
    ['href' => '#svc-hosting',   'label' => 'Hosting',                'style' => 'solid',   'dur' => '20s', 'delay' => '-10s',     'top' => '32.5%',
        'icon' => '<rect x="3" y="4" width="18" height="6" rx="1.5"/><rect x="3" y="14" width="18" height="6" rx="1.5"/><path d="M7 7h.01M7 17h.01"/>'],
    // Mid ring (30s)
    ['href' => '#svc-software',  'label' => 'Software development',   'style' => 'outline', 'dur' => '30s', 'delay' => '-3.33s',   'top' => '18.5%',
        'icon' => '<polyline points="8 7 4 12 8 17"/><polyline points="16 7 20 12 16 17"/>'],
    ['href' => '#svc-webapp',    'label' => 'Web applications',       'style' => 'outline', 'dur' => '30s', 'delay' => '-13.33s',  'top' => '18.5%',
        'icon' => '<rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/>'],
    ['href' => '#svc-fullstack', 'label' => 'Full-stack engineering', 'style' => 'outline', 'dur' => '30s', 'delay' => '-23.33s',  'top' => '18.5%',
        'icon' => '<path d="m12 3 9 5-9 5-9-5 9-5Z"/><path d="m3 12 9 5 9-5"/><path d="m3 16 9 5 9-5"/>'],
    // Outer ring (44s)
    ['href' => '#svc-domains',   'label' => 'Domain registration',    'style' => 'solid',   'dur' => '44s', 'delay' => '-2.44s',   'top' => '4%',
        'icon' => '<circle cx="12" cy="12" r="9"/><path d="M3 12h18"/><path d="M12 3a15 15 0 0 1 0 18 15 15 0 0 1 0-18Z"/>'],
    ['href' => '#svc-email',     'label' => 'Email hosting',          'style' => 'solid',   'dur' => '44s', 'delay' => '-17.11s',  'top' => '4%',
        'icon' => '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/>'],
    ['href' => '#svc-support',   'label' => 'Support & updates',      'style' => 'outline', 'dur' => '44s', 'delay' => '-31.78s',  'top' => '4%',
        'icon' => '<circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="3.5"/><path d="m4.9 4.9 4.3 4.3M14.8 14.8l4.3 4.3M14.8 9.2l4.3-4.3M9.2 14.8l-4.3 4.3"/>'],
];
?>
<section id="top" class="hero">
  <div class="hero__inner container">
    <div class="hero__copy">
      <span class="eyebrow eyebrow--accent">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m13 2-9 12h7l-2 8 9-12h-7l2-8Z"/></svg>
        Web design · Software · Hosting
      </span>
      <h1 class="hero__title">Beautifully simple websites &amp; software for growing businesses.</h1>
      <p class="hero__lead">Nospario Digital is a small studio helping small businesses and start-ups design, build, host and look after their websites and software — all under one roof.</p>
      <div class="hero__actions">
        <a href="#contact" class="btn btn--primary btn--lg">Get a free quote
          <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
        </a>
        <a href="#services" class="btn btn--ghost btn--lg">See services</a>
      </div>
      <a href="#support" class="status-chip" data-status-chip>
        <span class="status-dot status-dot--pulse" data-status-dot></span>
        <span data-status-text>All systems operational</span>
      </a>
    </div>

    <!-- Services graphic: orbital system. Hover pauses; nodes link to their service. -->
    <div class="hero__graphic-wrap">
      <div class="nsp-graphic">
        <div class="orbit-ring orbit-ring--outer"></div>
        <div class="orbit-ring orbit-ring--mid"></div>
        <div class="orbit-ring orbit-ring--inner"></div>

        <div class="orbit-core">
          <svg width="38%" height="38%" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="5" r="2"/><circle cx="5" cy="18" r="2"/><circle cx="19" cy="18" r="2"/><path d="M12 7v4M12 11l-5.5 5M12 11l5.5 5"/></svg>
        </div>

        <?php foreach ($orbitNodes as $n): ?>
        <div class="nsp-orbit" style="animation-duration:<?= e($n['dur']) ?>;animation-delay:<?= e($n['delay']) ?>;">
          <a class="nsp-node" href="<?= e($n['href']) ?>" style="top:<?= e($n['top']) ?>;">
            <span class="nsp-spin" style="animation-duration:<?= e($n['dur']) ?>;animation-delay:<?= e($n['delay']) ?>;">
              <span class="orbit-dot orbit-dot--<?= e($n['style']) ?>">
                <svg width="<?= $n['style'] === 'solid' ? '19' : '18' ?>" height="<?= $n['style'] === 'solid' ? '19' : '18' ?>" viewBox="0 0 24 24" fill="none" stroke="<?= $n['style'] === 'solid' ? '#fff' : 'var(--acc)' ?>" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><?= $n['icon'] ?></svg>
              </span>
              <span class="orbit-label"><?= e($n['label']) ?></span>
            </span>
          </a>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
