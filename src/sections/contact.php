<?php
/**
 * Contact / quote section. The form POSTs to /contact.php (handler shim).
 * On success the handler redirects to /?sent=contact#contact and we show the
 * success panel server-side. JS can also enhance this inline.
 */

declare(strict_types=1);

$sent = (($_GET['sent'] ?? '') === 'contact');
$err  = (($_GET['error'] ?? '') === 'contact');
?>
<section id="contact" class="section section--alt">
  <div class="container contact__inner">
    <div class="contact__intro">
      <span class="eyebrow">Contact</span>
      <h2 class="section__title">Start your project.</h2>
      <p class="section__lead">Tell us a little about what you need and we'll come back with a no-obligation quote.</p>
      <div class="contact__details">
        <a class="contact__detail" href="mailto:<?= e(CONTACT_EMAIL) ?>">
          <span class="contact__detail-icon"><svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg></span>
          <span class="contact__detail-text"><?= e(CONTACT_EMAIL) ?></span>
        </a>
        <a class="contact__detail" href="tel:<?= e(CONTACT_PHONE_TEL) ?>">
          <span class="contact__detail-icon"><svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M5 4h4l2 5-2.5 1.5a11 11 0 0 0 5 5L17 13l4 2v4a2 2 0 0 1-2 2A16 16 0 0 1 3 7a2 2 0 0 1 2-3Z"/></svg></span>
          <span class="contact__detail-text"><?= e(CONTACT_PHONE_DISPLAY) ?></span>
        </a>
      </div>
    </div>

    <div class="contact__form-col">
      <div class="form-success<?= $sent ? '' : ' is-hidden' ?>" data-form-success>
        <div class="form-success__icon">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
        </div>
        <h3 class="form-success__title">Thanks — message sent</h3>
        <p class="form-success__text">We'll be in touch shortly with a no-obligation quote.</p>
        <button type="button" class="btn btn--ghost-sm" data-form-reset>Send another</button>
      </div>

      <form class="form<?= $sent ? ' is-hidden' : '' ?>" action="/contact.php" method="post" data-form="contact" novalidate>
        <?php if ($err): ?>
          <p class="form__error" role="alert">Sorry — something went wrong sending your message. Please try again or email us directly.</p>
        <?php endif; ?>
        <div class="field">
          <label for="c-name">Name</label>
          <input type="text" id="c-name" name="name" required placeholder="Your name" autocomplete="name">
        </div>
        <div class="field">
          <label for="c-email">Email</label>
          <input type="email" id="c-email" name="email" required placeholder="you@business.co.uk" autocomplete="email">
        </div>
        <div class="field">
          <label for="c-phone">Phone</label>
          <input type="tel" id="c-phone" name="phone" placeholder="Optional" autocomplete="tel">
        </div>
        <div class="field">
          <label for="c-company">Business</label>
          <input type="text" id="c-company" name="company" placeholder="Optional" autocomplete="organization">
        </div>
        <div class="field field--full">
          <label for="c-message">About your project</label>
          <textarea id="c-message" name="message" required rows="5" placeholder="What are you looking to build? Roughly what's your timeline?"></textarea>
        </div>

        <!-- Spam protection: honeypot (hidden) + render timestamp -->
        <div class="hp" aria-hidden="true">
          <label for="c-website">Leave this field empty</label>
          <input type="text" id="c-website" name="website" tabindex="-1" autocomplete="off">
        </div>
        <input type="hidden" name="ts" value="<?= e((string) time()) ?>">

        <div class="field--full">
          <button type="submit" class="btn btn--primary">Send enquiry</button>
        </div>
      </form>
    </div>
  </div>
</section>
