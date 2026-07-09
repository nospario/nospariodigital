<?php
/**
 * About section + founder card.
 */

declare(strict_types=1);

$tags  = ['Design & build', 'Full-stack engineering', 'Hosting & email', 'Support & updates'];
$stack = ['WordPress', 'Svelte', 'Laravel', 'JavaScript', 'PHP', 'HTML', 'CSS', 'Perl', 'Shell'];

$check = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--acc)" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>';
?>
<section id="about" class="section section--alt">
  <div class="container">
    <span class="eyebrow">About</span>
    <h2 class="section__title">One person, from first sketch to ongoing support.</h2>

    <div class="about__intro">
      <p>Nospario Digital is a small, hands-on studio. I design and build websites, web apps and bespoke software for small businesses and start-ups — then host, maintain and support them, so you're not juggling five different suppliers.</p>
      <p class="muted">No account managers, no jargon. Just clear advice, careful work, and someone who picks up the phone.</p>
    </div>

    <div class="about__tags">
      <?php foreach ($tags as $tag): ?>
        <span class="tag"><?= $check ?><?= e($tag) ?></span>
      <?php endforeach; ?>
    </div>

    <div class="founder">
      <div class="founder__aside">
        <?php if (is_file(dirname(__DIR__, 2) . '/public/assets/img/richard-website.jpg')): ?>
          <img class="founder__photo" src="<?= e(asset('img/richard-website.jpg')) ?>" alt="Richard, founder of Nospario Digital" width="200" height="250" loading="lazy">
        <?php else: ?>
          <div class="founder__photo founder__photo--placeholder" aria-hidden="true">Richard</div>
        <?php endif; ?>
        <div>
          <div class="founder__name">Richard</div>
          <div class="founder__role">Founder &amp; developer</div>
        </div>
      </div>
      <div class="founder__body">
        <span class="eyebrow">The person behind it</span>
        <p>I'm Richard — and for over 20 years I've been designing and building websites and web applications. I've worked across the energy and education sectors and with a huge range of clients, from sole traders to multi-million-pound companies.</p>
        <p class="muted">That's meant projects for artists, designers, kitchen designers and fitters, printers, e-commerce shops, personal trainers, padel and yoga instructors, packaging manufacturers, signage companies and accountants — so whatever your trade, chances are I've built for something like it before.</p>
        <div class="founder__stack-label">Built with</div>
        <div class="founder__stack">
          <?php foreach ($stack as $tech): ?>
            <span class="badge-mono"><?= e($tech) ?></span>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</section>
