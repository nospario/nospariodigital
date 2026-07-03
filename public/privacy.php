<?php
/**
 * Privacy & Cookie Policy page.
 */

declare(strict_types=1);

require __DIR__ . '/../src/config.php';

$policy   = load_data('policy');
$sections = $policy['sections'] ?? [];
$cookies  = $policy['cookies'] ?? [];
$updated  = $policy['last_updated'] ?? '';

$page = [
    'title'       => 'Privacy & Cookie Policy',
    'description' => 'How Nospario Digital collects, uses and protects your information, and how we use cookies on this website.',
    'path'        => '/privacy',
    'og_type'     => 'article',
    'jsonld'      => [
        [
            '@context' => 'https://schema.org',
            '@type'    => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => SITE_URL],
                ['@type' => 'ListItem', 'position' => 2, 'name' => 'Privacy & Cookie Policy', 'item' => url('privacy')],
            ],
        ],
    ],
];

require __DIR__ . '/../src/partials/head.php';
require __DIR__ . '/../src/partials/header.php';
?>
<section class="legal-hero">
  <div class="container container--narrow">
    <span class="eyebrow">Legal</span>
    <h1 class="legal-hero__title">Privacy &amp; Cookie Policy</h1>
    <p class="section__lead">How Nospario Digital collects, uses and protects your information, and how we use cookies on this website.</p>
    <p class="legal-hero__updated">Last updated: <?= e($updated) ?></p>
  </div>
</section>

<section class="section">
  <div class="container container--narrow legal-body">
    <div>
      <p class="legal-intro">Nospario Digital (&ldquo;we&rdquo;, &ldquo;us&rdquo;, &ldquo;our&rdquo;) is committed to protecting your privacy. This policy explains what personal information we collect, why we collect it, how we use it, and the choices you have. It applies to this website and to the services we provide to our clients.</p>
      <p class="legal-intro">By using this website or our services, you agree to the practices described in this policy. We comply with the UK GDPR and the Data Protection Act 2018.</p>
    </div>

    <?php foreach ($sections as $sec): ?>
      <div id="<?= e($sec['id']) ?>" class="legal-section">
        <h2 class="legal-section__heading"><?= e($sec['heading']) ?></h2>
        <?php foreach ($sec['paras'] as $para): ?>
          <p class="legal-section__para"><?= e($para) ?></p>
        <?php endforeach; ?>
        <?php if (!empty($sec['items'])): ?>
          <ul class="legal-list">
            <?php foreach ($sec['items'] as $item): ?>
              <li class="legal-list__item">
                <span class="legal-list__dot" aria-hidden="true"></span>
                <span><strong><?= e($item['label']) ?></strong><?= e($item['text']) ?></span>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
      </div>
    <?php endforeach; ?>

    <!-- Cookie table -->
    <div id="cookie-types" class="legal-section">
      <h2 class="legal-section__heading">Types of cookies we use</h2>
      <p class="legal-section__para">Cookies are small text files placed on your device. We use the following categories:</p>
      <div class="cookie-table">
        <?php foreach ($cookies as $c): ?>
          <div class="cookie-row">
            <div class="cookie-row__name">
              <div class="cookie-row__title"><?= e($c['name']) ?></div>
              <span class="pill <?= e($c['tag_class']) ?>"><?= e($c['tag']) ?></span>
            </div>
            <div class="cookie-row__desc"><?= e($c['desc']) ?></div>
          </div>
        <?php endforeach; ?>
      </div>
      <p class="legal-note">You can control or delete cookies through your browser settings. Blocking essential cookies may affect how parts of this website function.</p>
    </div>

    <!-- Contact -->
    <div id="contact-dpo" class="legal-contact">
      <h2 class="legal-contact__heading">How to contact us</h2>
      <p class="legal-section__para">If you have any questions about this policy, or want to access, correct or delete the personal information we hold about you, please get in touch.</p>
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
      <p class="legal-note legal-note--contact">You also have the right to lodge a complaint with the Information Commissioner's Office (ICO) at ico.org.uk if you believe your data has been handled improperly.</p>
    </div>
  </div>
</section>

<?php require __DIR__ . '/../src/partials/footer.php'; ?>
