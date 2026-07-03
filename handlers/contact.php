<?php
/**
 * Contact / quote form handler.
 * Reached via the public shim /contact.php (which requires this file).
 */

declare(strict_types=1);

require_once __DIR__ . '/../src/config.php';
require_once __DIR__ . '/../src/lib/forms.php';
require_once __DIR__ . '/../src/lib/mailer.php';

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    header('Location: /#contact', true, 303);
    exit;
}

// Spam: silently treat as success so bots get no signal.
if (form_is_spam($_POST)) {
    form_respond(true, 'contact', 'contact');
}

$name    = clean('name', 200);
$email   = clean('email', 254);
$phone   = clean('phone', 50);
$company = clean('company', 200);
$message = clean('message', 5000, true);

// Required fields.
if ($name === '' || $message === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    form_respond(false, 'contact', 'contact');
}

$body = "New website enquiry\n"
    . "====================\n\n"
    . "Name:    {$name}\n"
    . "Email:   {$email}\n"
    . "Phone:   " . ($phone !== '' ? $phone : '—') . "\n"
    . "Business:" . ($company !== '' ? ' ' . $company : ' —') . "\n\n"
    . "Message:\n{$message}\n";

$ok = send_mail('Website enquiry from ' . $name, $body, $email, $name);

form_respond($ok, 'contact', 'contact');
