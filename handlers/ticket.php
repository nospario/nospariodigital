<?php
/**
 * Support ticket form handler.
 * Reached via the public shim /ticket.php (which requires this file).
 */

declare(strict_types=1);

require_once __DIR__ . '/../src/config.php';
require_once __DIR__ . '/../src/lib/forms.php';
require_once __DIR__ . '/../src/lib/mailer.php';

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    header('Location: /#support', true, 303);
    exit;
}

if (form_is_spam($_POST)) {
    form_respond(true, 'ticket', 'support');
}

$validCategories = ['Website issue', 'Hosting / downtime', 'Email problem', 'Website update request', 'Billing / account', 'General / other'];

$name        = clean('name', 200);
$email       = clean('email', 254);
$phone       = clean('phone', 50);
$category    = clean('category', 100);
$description = clean('description', 5000, true);

if ($name === '' || $description === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || !in_array($category, $validCategories, true)) {
    form_respond(false, 'ticket', 'support');
}

$body = "New support ticket\n"
    . "==================\n\n"
    . "Name:     {$name}\n"
    . "Email:    {$email}\n"
    . "Phone:    " . ($phone !== '' ? $phone : '—') . "\n"
    . "Category: {$category}\n\n"
    . "Description:\n{$description}\n";

$ok = send_mail('Support ticket: ' . $category . ' — ' . $name, $body, $email, $name);

form_respond($ok, 'ticket', 'support');
