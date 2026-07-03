<?php
/**
 * Testimonials. Expects $testimonials (from data/testimonials.php).
 */

declare(strict_types=1);

/** @var array $testimonials */
$testimonials = $testimonials ?? load_data('testimonials');
if (!$testimonials) {
    return;
}
?>
<section class="section section--alt">
  <div class="container">
    <span class="eyebrow">Clients</span>
    <h2 class="section__title">Trusted by small businesses and start-ups.</h2>

    <div class="card-grid card-grid--testimonials">
      <?php foreach ($testimonials as $t): ?>
        <figure class="card testimonial">
          <svg class="testimonial__quote" width="26" height="26" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M10 7H6a3 3 0 0 0-3 3v7h7v-7H6c0-1 1-2 2-2V7Zm11 0h-4a3 3 0 0 0-3 3v7h7v-7h-4c0-1 1-2 2-2V7Z"/></svg>
          <blockquote class="testimonial__quote-text">&ldquo;<?= e($t['quote']) ?>&rdquo;</blockquote>
          <figcaption class="testimonial__cite"><strong><?= e($t['name']) ?></strong> · <?= e($t['role']) ?></figcaption>
        </figure>
      <?php endforeach; ?>
    </div>
  </div>
</section>
