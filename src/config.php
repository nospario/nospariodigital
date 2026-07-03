<?php
/**
 * Site-wide configuration & constants.
 * Included by every page (via head.php) before anything is rendered.
 */

declare(strict_types=1);

// ---------------------------------------------------------------------------
// Composer autoloader — optional. When present (e.g. PHPMailer installed),
// this lets the mailer use SMTP; otherwise the app runs fine without it.
// ---------------------------------------------------------------------------
$autoload = dirname(__DIR__) . '/vendor/autoload.php';
if (is_file($autoload)) {
    require_once $autoload;
}

// ---------------------------------------------------------------------------
// Environment (.env) — load lightweight key=value pairs if a .env file exists.
// Secrets (SMTP, recipient) live here, never in source. See .env.example.
// ---------------------------------------------------------------------------
(function (): void {
    $envPath = dirname(__DIR__) . '/.env';
    if (!is_file($envPath)) {
        return;
    }
    foreach (file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);
        if ($line === '' || $line[0] === '#' || !str_contains($line, '=')) {
            continue;
        }
        [$key, $value] = explode('=', $line, 2);
        $key = trim($key);
        $value = trim($value);
        // Strip optional surrounding quotes.
        if (strlen($value) >= 2 && ($value[0] === '"' || $value[0] === "'")) {
            $value = substr($value, 1, -1);
        }
        if ($key !== '' && getenv($key) === false) {
            putenv("$key=$value");
            $_ENV[$key] = $value;
        }
    }
})();

// ---------------------------------------------------------------------------
// Identity
// ---------------------------------------------------------------------------
define('SITE_NAME', 'Nospario Digital');
define('SITE_URL', rtrim(getenv('SITE_URL') ?: 'https://www.nospariodigital.co.uk', '/'));
define('SITE_TAGLINE', 'Websites, software & hosting for small businesses and start-ups.');

// Contact details (real data — carried over from the prototype)
define('CONTACT_EMAIL', 'theteam@nospariodigital.co.uk');
define('CONTACT_PHONE_DISPLAY', '07899 955432');
define('CONTACT_PHONE_TEL', '07899955432');
define('CONTACT_PHONE_INTL', '+44 7899 955432');

// Where form submissions are delivered (override in .env).
define('MAIL_TO', getenv('MAIL_TO') ?: CONTACT_EMAIL);

// Live status feed (Heart Internet) consumed client-side by status.js.
define('STATUS_FEED_URL', 'https://www.heartstatus.uk/index.json');

// ---------------------------------------------------------------------------
// Primary navigation (shared by header + mobile drawer)
// ---------------------------------------------------------------------------
$NAV = [
    ['label' => 'Services', 'href' => '/#services'],
    ['label' => 'About',    'href' => '/#about'],
    ['label' => 'Pricing',  'href' => '/#pricing'],
    ['label' => 'Contact',  'href' => '/#contact'],
    ['label' => 'Support',  'href' => '/#support'],
];

require_once __DIR__ . '/lib/helpers.php';
