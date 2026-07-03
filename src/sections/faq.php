<?php
/**
 * Main FAQ accordion. Uses native <details>/<summary> for accessibility.
 * First item open by default (mirrors the prototype's openFaq = 0).
 * Expects $faqs (the 'main' group from data/faqs.php).
 */

declare(strict_types=1);

/** @var array $faqs */
$faqs = $faqs ?? (load_data('faqs')['main'] ?? []);
?>
<section class="section">
  <div class="container container--narrow">
    <span class="eyebrow">FAQ</span>
    <h2 class="section__title section__title--mb">Questions, answered.</h2>

    <div class="accordion">
      <?php foreach ($faqs as $i => $f): ?>
        <details class="accordion__item"<?= $i === 0 ? ' open' : '' ?>>
          <summary class="accordion__summary">
            <span><?= e($f['q']) ?></span>
            <span class="accordion__chevron" aria-hidden="true">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><polyline points="6 9 12 15 18 9"/></svg>
            </span>
          </summary>
          <p class="accordion__panel"><?= e($f['a']) ?></p>
        </details>
      <?php endforeach; ?>
    </div>
  </div>
</section>
