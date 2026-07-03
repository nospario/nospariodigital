<?php
/**
 * Pricing — three-step "how a quote works" cards.
 */

declare(strict_types=1);

$steps = [
    ['n' => '1', 'title' => 'Tell us what you need', 'desc' => 'A quick chat or message about your business, goals and rough timescales.'],
    ['n' => '2', 'title' => 'Get a detailed quote', 'desc' => 'A clear, itemised proposal with scope, timeline and a fixed price — no surprises.'],
    ['n' => '3', 'title' => 'Decide, no obligation', 'desc' => "Happy? We get started. Not for you? No pressure, no cost — that's it."],
];
?>
<section id="pricing" class="section">
  <div class="container">
    <span class="eyebrow">Pricing</span>
    <h2 class="section__title">No packages. Just a fair, tailored quote.</h2>
    <p class="section__lead">Every project is different, so every price is too. We learn what you need, scope it properly, and send a detailed quote — with no obligation to go ahead.</p>

    <div class="card-grid card-grid--steps">
      <?php foreach ($steps as $step): ?>
        <div class="card step-card">
          <div class="step-card__num"><?= e($step['n']) ?></div>
          <h3 class="step-card__title"><?= e($step['title']) ?></h3>
          <p class="step-card__desc"><?= e($step['desc']) ?></p>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="pricing__cta">
      <a href="#contact" class="btn btn--primary btn--lg">Request a quote
        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
      </a>
    </div>
  </div>
</section>
