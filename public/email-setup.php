<?php
/**
 * Email setup guide for hosting clients (Heart Internet mailboxes).
 * Not in the main nav — linked from the Support FAQ on the home page.
 *
 * Layout follows docs/email-page/Email Setup Guide.dc.html. All content is
 * server-rendered; assets/js/email-guide.js progressively enhances it into
 * device tabs, variant tabs, an IMAP/POP switch and copy buttons.
 */

declare(strict_types=1);

require __DIR__ . '/../src/config.php';

$guide    = load_data('email-guide');
$settings = $guide['settings'];
$devices  = $guide['devices'];
$trouble  = $guide['trouble'];
$webmail  = $guide['webmail'];

$tones = [
    'important' => 'gnote--important',
    'tip'       => 'gnote--tip',
    'test'      => 'gnote--test',
    'warn'      => 'gnote--warn',
];

$page = [
    'title'       => 'Setting Up Your Email',
    'description' => 'Step-by-step instructions for adding your Nospario-hosted business email to an iPhone, iPad, Android phone, Outlook on Windows or Apple Mail on a Mac.',
    'path'        => '/email-setup',
    'og_type'     => 'article',
    'jsonld'      => [
        [
            '@context' => 'https://schema.org',
            '@type'    => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => SITE_URL],
                ['@type' => 'ListItem', 'position' => 2, 'name' => 'Email setup guide', 'item' => url('email-setup')],
            ],
        ],
    ],
];

/** IMAP/POP switch (hidden until JS enhances the page). */
$protoSwitch = static function (string $size = ''): string {
    $cls = 'gswitch' . ($size !== '' ? ' gswitch--' . $size : '');
    return '<div class="' . $cls . '" role="group" aria-label="Account type" data-proto-switch hidden>'
        . '<button type="button" class="gswitch__btn" data-proto-btn="imap" aria-pressed="true">IMAP (recommended)</button>'
        . '<button type="button" class="gswitch__btn" data-proto-btn="pop" aria-pressed="false">POP</button>'
        . '</div>';
};

/** A field value: one value, or IMAP + POP alternatives. */
$fieldValue = static function (array $f): string {
    if (!isset($f[2])) {
        return fmt($f[1], 'gcode gcode--acc');
    }
    return '<span class="pv pv--imap">' . fmt($f[1], 'gcode gcode--acc') . '</span>'
         . '<span class="pv pv--pop">' . fmt($f[2], 'gcode gcode--acc') . '</span>';
};

/** A coloured note box. $paras may be a string or list of strings. */
$note = static function (string $tone, string $title, string|array $paras, string $extra = '') use ($tones): string {
    $html = '<div class="gnote ' . $tones[$tone] . ($extra !== '' ? ' ' . $extra : '') . '">'
          . '<div class="gnote__title">' . e($title) . '</div>';
    foreach ((array) $paras as $p) {
        $html .= '<p>' . fmt($p) . '</p>';
    }
    return $html . '</div>';
};

$icon = [
    'chev'   => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>',
    'out'    => '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17 17 7"/><polyline points="8 7 17 7 17 16"/></svg>',
];

require __DIR__ . '/../src/partials/head.php';
require __DIR__ . '/../src/partials/header.php';
?>
<section class="ghero">
  <div class="container container--support">
    <span class="eyebrow">Support guide</span>
    <h1 class="ghero__title">Setting up your email</h1>
    <p class="ghero__lead">This guide walks you through adding your business email address to your phone, tablet or computer. Find the section for your device, follow the steps in order, and copy the settings exactly as shown.</p>
    <div class="ghero__chips">
      <span class="gchip">Heart Internet mailboxes</span>
      <span class="gchip">About 5 minutes</span>
    </div>
    <nav class="ghero__toc" aria-label="On this page">
      <a href="#before">Before you start</a>
      <a href="#imap-pop">IMAP or POP</a>
      <a href="#settings">Settings</a>
      <a href="#devices">Device guides</a>
      <a href="#troubleshooting">Troubleshooting</a>
      <a href="#help">Webmail</a>
    </nav>
  </div>
</section>

<div id="email-guide" class="gw" data-proto="imap">
  <div class="container container--support gw__body">

    <!-- Before you start -->
    <section id="before" class="gsec">
      <h2 class="gsec__title">Before you start</h2>
      <p class="gsec__lead">Have these three things ready:</p>
      <div class="ggrid ggrid--3">
        <div class="gcard">
          <div class="gcard__num">01</div>
          <div class="gcard__title">Your full email address</div>
          <div class="gcard__text">For example jane@yourbusiness.co.uk</div>
        </div>
        <div class="gcard">
          <div class="gcard__num">02</div>
          <div class="gcard__title">Your email password</div>
          <div class="gcard__text">The password for your mailbox, not your Heart Internet account login or your website login. If you don't know it, ask us and we'll reset it for you.</div>
        </div>
        <div class="gcard">
          <div class="gcard__num">03</div>
          <div class="gcard__title">This guide</div>
          <div class="gcard__text">Open on a different screen or printed out, so you can read the settings while you type.</div>
        </div>
      </div>
      <div class="ggolden">
        <div class="ggolden__label">Golden rule</div>
        <p>Whenever a screen asks for a <strong>Username</strong> or <strong>User Name</strong>, type your <strong>full email address</strong>, including everything after the @ sign. Not just your name. This is the number one cause of setup problems.</p>
      </div>
      <p class="gsec__tip">Tip: if you can, add the account while connected to Wi-Fi, not mobile data.</p>
    </section>

    <!-- IMAP or POP -->
    <section id="imap-pop" class="gsec">
      <h2 class="gsec__title">IMAP or POP: which should I choose?</h2>
      <p class="gsec__lead">During setup your device will ask you to choose between IMAP and POP. They are two different ways of collecting your email.</p>
      <div class="ggrid ggrid--2">
        <div class="gcard gcard--choice gcard--rec">
          <div class="gcard__head">
            <h3 class="gcard__big">IMAP</h3>
            <span class="gbadge gbadge--acc">Recommended</span>
          </div>
          <p class="gcard__intro">For almost everyone. Choose IMAP if:</p>
          <ul class="gbullets">
            <li>you read email on more than one device (for example a phone and a laptop)</li>
            <li>you want emails you read, send or delete on one device to show the same on all your others</li>
            <li>you want your email kept safely on the server, so nothing is lost if your phone breaks</li>
          </ul>
        </div>
        <div class="gcard gcard--choice">
          <h3 class="gcard__big">POP</h3>
          <p class="gcard__intro">Choose POP only if:</p>
          <ul class="gbullets gbullets--grey">
            <li>you read email on one computer only, and</li>
            <li>you want messages downloaded to that computer and stored there</li>
          </ul>
        </div>
      </div>
      <div class="ggrid ggrid--2 ggrid--notes">
        <?= $note('warn', 'Warning about POP', 'With POP, emails are downloaded to one device. Unless the "leave a copy on the server" option is switched on, they may disappear from your other devices and from webmail. If you are not sure, choose IMAP.') ?>
        <?= $note('tip', 'Already set up the wrong one?', "You can't switch an account between POP and IMAP. Remove the account from the device and add it again with the other option. With POP, back up any emails stored only on that device first.") ?>
      </div>
    </section>

    <!-- Settings at a glance -->
    <section id="settings" class="gsec">
      <div class="gsec__headrow">
        <div class="gsec__headtext">
          <h2 class="gsec__title">Your settings at a glance</h2>
          <p class="gsec__lead gsec__lead--flush">These settings are the same for every mailbox. Only your email address and password change.</p>
        </div>
        <?= $protoSwitch() ?>
      </div>
      <div class="ggrid ggrid--settings">
        <?php foreach ($settings as $key => $g): ?>
          <div class="gset gset--<?= e($key) ?>">
            <div class="gset__head">
              <h3 class="gset__title"><?= e($g['title']) ?></h3>
              <span class="gbadge"><?= e($g['badge']) ?></span>
            </div>
            <dl class="gset__rows">
              <?php foreach ($g['rows'] as [$label, $value, $copy]): ?>
                <div class="gset__row">
                  <div class="gset__kv">
                    <dt><?= e($label) ?></dt>
                    <dd><?= $copy ? '<code class="gset__code">' . e($value) . '</code>' : e($value) ?></dd>
                  </div>
                  <?php if ($copy): ?>
                    <button type="button" class="gcopy" data-copy="<?= e($value) ?>" aria-label="Copy <?= e($value) ?>" hidden>Copy</button>
                  <?php endif; ?>
                </div>
              <?php endforeach; ?>
            </dl>
          </div>
        <?php endforeach; ?>
      </div>
      <div class="ggrid ggrid--2 ggrid--notes">
        <?= $note('important', 'Watch out for typos', "It's **extendcp**, all one word with no spaces. The incoming server for IMAP starts **imap.**, for POP it starts **pop3.**, and the outgoing server starts **mta.**") ?>
        <?= $note('warn', "Don't use older settings", "Avoid mail.yourdomain.co.uk or port 25 unless we've told you to. They can cause security warnings or stop you sending email. Use the settings in this guide.") ?>
      </div>
    </section>

    <!-- Device guides -->
    <section id="devices" class="gsec">
      <h2 class="gsec__title">Choose your device</h2>
      <p class="gsec__lead">Pick your device and follow the steps in order.</p>
      <div class="gtabs" data-device-tabs aria-label="Device">
        <?php foreach ($devices as $d): ?>
          <a class="gtab" href="#guide-<?= e($d['id']) ?>" data-device-tab="<?= e($d['id']) ?>">
            <span class="gtab__label"><?= e($d['label']) ?></span>
            <span class="gtab__sub"><?= e($d['sub']) ?></span>
          </a>
        <?php endforeach; ?>
      </div>

      <?php foreach ($devices as $d):
          $multi   = count($d['variants']) > 1;
          $heading = $d['heading'] ?? $d['variants'][0]['heading'];
      ?>
        <div class="gpanel" id="guide-<?= e($d['id']) ?>" data-device-panel="<?= e($d['id']) ?>">
          <div class="gpanel__head">
            <h3 class="gpanel__title"><?= e($heading) ?></h3>
            <div class="gpanel__proto" data-proto-switch-wrap hidden>
              <span class="gpanel__proto-label">Show settings for</span>
              <?= $protoSwitch('sm') ?>
            </div>
          </div>

          <?php if (!empty($d['intro'])): ?>
            <p class="gpanel__intro"><?= fmt($d['intro']) ?></p>
          <?php endif; ?>
          <?php foreach ($d['variants'] as $v): if (!empty($v['intro'])): ?>
            <p class="gpanel__intro" data-variant-of="<?= e($d['id']) ?>" data-variant="<?= e($v['id']) ?>"><?= fmt($v['intro']) ?></p>
          <?php endif; endforeach; ?>

          <?php if ($multi): ?>
            <div class="gvtabs" role="group" aria-label="App version" data-variant-tabs hidden>
              <?php foreach ($d['variants'] as $i => $v): ?>
                <button type="button" class="gvtab" data-variant-btn="<?= e($v['id']) ?>" aria-pressed="<?= $i === 0 ? 'true' : 'false' ?>">
                  <span class="gvtab__label"><?= e($v['label']) ?></span>
                  <span class="gvtab__desc"><?= e($v['desc']) ?></span>
                </button>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>

          <?php foreach ($d['variants'] as $v): ?>
            <div class="gvariant" data-variant-of="<?= e($d['id']) ?>" data-variant="<?= e($v['id']) ?>">
              <?php if ($multi): ?>
                <h4 class="gvariant__title"><?= e($v['label']) ?></h4>
              <?php endif; ?>

              <div class="gparts">
                <?php foreach ($v['parts'] as $part): ?>
                  <div class="gpart">
                    <?php if (!empty($part['title'])): ?>
                      <h4 class="gpart__title"><?= e($part['title']) ?></h4>
                    <?php endif; ?>
                    <ol class="gsteps">
                      <?php foreach ($part['steps'] as $st): ?>
                        <li class="gstep">
                          <span class="gstep__num" aria-hidden="true"></span>
                          <div class="gstep__body">
                            <p><?= fmt($st['t']) ?></p>
                            <?php if (!empty($st['f'])): ?>
                              <dl class="gfields">
                                <?php foreach ($st['f'] as $f): ?>
                                  <div class="gfields__row">
                                    <dt><?= e($f[0]) ?></dt>
                                    <dd><?= $fieldValue($f) ?></dd>
                                  </div>
                                <?php endforeach; ?>
                              </dl>
                            <?php endif; ?>
                            <?php if (!empty($st['a'])): ?>
                              <p class="gstep__after"><?= fmt($st['a']) ?></p>
                            <?php endif; ?>
                            <?php if (!empty($st['c'])): ?>
                              <?= $note($st['c'][0], $st['c'][1], $st['c'][2], 'gnote--step') ?>
                            <?php endif; ?>
                          </div>
                        </li>
                      <?php endforeach; ?>
                    </ol>
                  </div>
                <?php endforeach; ?>
              </div>

              <div class="gnotes">
                <?php foreach (($v['notes'] ?? []) as $n): ?>
                  <?= $note($n[0], $n[1], $n[2]) ?>
                <?php endforeach; ?>
                <?php if (!empty($v['test'])): ?>
                  <?= $note('test', 'Test it', $v['test']) ?>
                <?php endif; ?>
                <?php if (!empty($v['pop'])): ?>
                  <?= $note('warn', $v['pop'][0], $v['pop'][1], 'gnote--pop') ?>
                <?php endif; ?>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endforeach; ?>
    </section>

    <!-- Troubleshooting -->
    <section id="troubleshooting" class="gsec">
      <h2 class="gsec__title">Troubleshooting</h2>
      <p class="gsec__lead">Work down this list. Most problems are fixed by the first two checks.</p>
      <div class="gnote gnote--important gstatus">
        <div class="gnote__title">Check the system status first</div>
        <p>If email stops working on all your devices at once, there may be a problem with the email service itself. Check the <a href="/#status">live system status on our home page</a>. If it shows a problem with email, it's already being fixed. There's nothing to change on your device, so wait and try again later.</p>
      </div>
      <div class="gtrouble">
        <?php foreach ($trouble as $i => $t): ?>
          <details class="gtrouble__item" name="trouble"<?= $i === 0 ? ' open' : '' ?>>
            <summary class="gtrouble__q">
              <span><?= e($t['q']) ?></span>
              <span class="gtrouble__chev"><?= $icon['chev'] ?></span>
            </summary>
            <div class="gtrouble__a">
              <?php if (!empty($t['intro'])): ?>
                <p><?= e($t['intro']) ?></p>
              <?php endif; ?>
              <ul class="gbullets">
                <?php foreach ($t['items'] as $item): ?>
                  <li><?= fmt($item, 'gcode') ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
          </details>
        <?php endforeach; ?>
      </div>
    </section>

    <!-- Webmail -->
    <section id="help" class="gsec">
      <div class="ghelp ghelp--webmail">
        <h2 class="ghelp__title">Webmail</h2>
        <p class="ghelp__text">Read and send email in any web browser, from any computer, without setting anything up. It's also the quickest way to check your password is correct.</p>
        <ol class="gmini">
          <li>Go to <strong><?= e(rtrim(preg_replace('#^https?://#', '', $webmail), '/')) ?></strong></li>
          <li>Enter your full email address and your email password.</li>
          <li>Log in. If your password doesn't work, ask us to reset it.</li>
        </ol>
        <a class="btn btn--primary ghelp__btn" href="<?= e($webmail) ?>" target="_blank" rel="noopener">Open webmail <?= $icon['out'] ?></a>
      </div>
    </section>

  </div>
</div>
<?php /* Loaded right after the guide (not deferred) so the tabs are set up before first paint. */ ?>
<script src="<?= e(asset('js/email-guide.js')) ?>"></script>

<?php require __DIR__ . '/../src/partials/footer.php'; ?>
