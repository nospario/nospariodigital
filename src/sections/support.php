<?php
/**
 * Support section: live system status, raise-a-ticket form, support FAQs.
 * Status renders a static "all operational" fallback; status.js enhances it live.
 * Expects $supportFaqs (the 'support' group from data/faqs.php).
 */

declare(strict_types=1);

/** @var array $supportFaqs */
$supportFaqs = $supportFaqs ?? (load_data('faqs')['support'] ?? []);

$ticketCategories = ['Website issue', 'Hosting / downtime', 'Email problem', 'Website update request', 'Billing / account', 'General / other'];

// Static status fallback (rendered instantly; replaced by status.js when live data loads).
$statusFallback = [
    ['name' => 'Website Hosting', 'uptime' => '99.99%'],
    ['name' => 'Email Hosting',   'uptime' => '99.98%'],
    ['name' => 'Domains & DNS',   'uptime' => '100.00%'],
    ['name' => 'Client Portal',   'uptime' => '99.97%'],
    ['name' => 'Support Desk',    'uptime' => '99.99%'],
];

$ticketSent = (($_GET['sent'] ?? '') === 'ticket');
$ticketErr  = (($_GET['error'] ?? '') === 'ticket');
?>
<section id="support" class="section">
  <div class="container container--support">
    <span class="eyebrow eyebrow--accent">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2Z"/></svg>
      Support
    </span>
    <h2 class="section__title">Support &amp; system status.</h2>
    <p class="section__lead">Already a client? Check live system status, raise a ticket, or browse common support questions.</p>

    <!-- System status -->
    <div id="status" class="status-block">
      <h3 class="support__h3">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--acc)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 12h4l3 8 4-16 3 8h4"/></svg>
        Current system status
      </h3>

      <div class="status-banner" data-status-banner>
        <span class="status-dot status-dot--lg status-dot--pulse" data-status-dot></span>
        <div>
          <div class="status-banner__title" data-status-text>All systems operational</div>
          <div class="status-banner__sub" data-status-sub>Live status</div>
        </div>
      </div>

      <div class="status-list" data-status-list>
        <?php foreach ($statusFallback as $s): ?>
          <div class="status-row">
            <div class="status-row__main">
              <span class="status-dot status-dot--ok"></span>
              <div>
                <div class="status-row__name"><?= e($s['name']) ?></div>
                <div class="status-row__meta"><?= e($s['uptime']) ?> uptime · 90 days</div>
              </div>
            </div>
            <span class="status-row__label status-row__label--ok">Operational</span>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Raise a ticket -->
    <div class="support__block">
      <h3 class="support__h3">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--acc)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 7a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v3a2 2 0 0 0 0 4v3a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-3a2 2 0 0 0 0-4Z"/><path d="M13 5v14"/></svg>
        Raise a ticket
      </h3>

      <div class="form-success form-success--green<?= $ticketSent ? '' : ' is-hidden' ?>" data-form-success>
        <div class="form-success__icon form-success__icon--green">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
        </div>
        <h3 class="form-success__title form-success__title--green">Ticket received</h3>
        <p class="form-success__text">Thanks — we've logged your ticket and will be in touch by email shortly.</p>
        <button type="button" class="btn btn--ghost-sm btn--ghost-sm-green" data-form-reset>Raise another ticket</button>
      </div>

      <form class="form<?= $ticketSent ? ' is-hidden' : '' ?>" action="/ticket.php" method="post" data-form="ticket" novalidate>
        <?php if ($ticketErr): ?>
          <p class="form__error" role="alert">Sorry — something went wrong submitting your ticket. Please try again or email us directly.</p>
        <?php endif; ?>
        <div class="field">
          <label for="t-name">Name</label>
          <input type="text" id="t-name" name="name" required placeholder="Your name" autocomplete="name">
        </div>
        <div class="field">
          <label for="t-email">Email</label>
          <input type="email" id="t-email" name="email" required placeholder="you@business.co.uk" autocomplete="email">
        </div>
        <div class="field">
          <label for="t-phone">Phone</label>
          <input type="tel" id="t-phone" name="phone" placeholder="Optional" autocomplete="tel">
        </div>
        <div class="field">
          <label for="t-category">Category</label>
          <select id="t-category" name="category" required>
            <option value="" disabled selected>Select a category…</option>
            <?php foreach ($ticketCategories as $cat): ?>
              <option value="<?= e($cat) ?>"><?= e($cat) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="field field--full">
          <label for="t-description">Description</label>
          <textarea id="t-description" name="description" required rows="5" placeholder="What's happening? Include any links or error messages."></textarea>
        </div>

        <div class="hp" aria-hidden="true">
          <label for="t-website">Leave this field empty</label>
          <input type="text" id="t-website" name="website" tabindex="-1" autocomplete="off">
        </div>
        <input type="hidden" name="ts" value="<?= e((string) time()) ?>">

        <div class="field--full">
          <button type="submit" class="btn btn--primary">Submit ticket</button>
        </div>
      </form>
    </div>

    <!-- Support FAQs -->
    <div class="support__block">
      <h3 class="support__h3">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--acc)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M9.5 9a2.5 2.5 0 0 1 4.5 1.5c0 1.5-2 2-2 3"/><path d="M12 17h.01"/></svg>
        Support FAQs
      </h3>
      <div class="accordion">
        <?php foreach ($supportFaqs as $f): ?>
          <details class="accordion__item accordion__item--sm">
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
  </div>
</section>
