<?php
/**
 * Minimal mail sender. Uses PHPMailer over SMTP when it is installed and
 * SMTP credentials are configured; otherwise falls back to PHP's mail().
 *
 * SMTP settings come from .env (see .env.example):
 *   SMTP_HOST, SMTP_PORT, SMTP_USER, SMTP_PASS, SMTP_SECURE, MAIL_FROM, MAIL_TO
 */

declare(strict_types=1);

if (!function_exists('send_mail')) {
    /**
     * @param string $subject  Email subject.
     * @param string $body     Plain-text body.
     * @param string $replyTo  Submitter's email (for Reply-To).
     * @param string $replyName Submitter's name.
     * @return bool  True on success.
     */
    function send_mail(string $subject, string $body, string $replyTo = '', string $replyName = ''): bool
    {
        $to      = MAIL_TO;
        $from    = getenv('MAIL_FROM') ?: ('no-reply@' . (parse_url(SITE_URL, PHP_URL_HOST) ?: 'localhost'));
        $smtpHost = getenv('SMTP_HOST') ?: '';

        // Subjects are a header: never allow CR/LF through (mail() does not
        // strip them itself, so a newline here would inject extra headers).
        $subject = trim(preg_replace('/[\r\n]+/', ' ', $subject) ?? '');

        // --- Preferred path: PHPMailer over SMTP ---
        if ($smtpHost !== '' && class_exists(\PHPMailer\PHPMailer\PHPMailer::class)) {
            try {
                $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
                $mail->isSMTP();
                $mail->Host       = $smtpHost;
                $mail->Port       = (int) (getenv('SMTP_PORT') ?: 587);
                $user             = getenv('SMTP_USER') ?: '';
                $pass             = getenv('SMTP_PASS') ?: '';
                // Only authenticate when a username is configured (local
                // mail-catchers like Mailpit accept unauthenticated mail).
                $mail->SMTPAuth   = $user !== '';
                $mail->Username   = $user;
                $mail->Password   = $pass;
                $secure           = strtolower(getenv('SMTP_SECURE') ?: 'tls');
                if ($secure === 'ssl') {
                    $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
                } elseif ($secure === '' || $secure === 'none') {
                    // Plaintext (e.g. Mailpit on :1025) — no encryption.
                    $mail->SMTPSecure  = '';
                    $mail->SMTPAutoTLS = false;
                } else {
                    $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
                }

                $mail->setFrom($from, SITE_NAME);
                $mail->addAddress($to);
                if ($replyTo !== '' && filter_var($replyTo, FILTER_VALIDATE_EMAIL)) {
                    $mail->addReplyTo($replyTo, $replyName !== '' ? $replyName : $replyTo);
                }
                $mail->Subject = $subject;
                $mail->Body    = $body;
                $mail->isHTML(false);
                return $mail->send();
            } catch (\Throwable $e) {
                error_log('[nospario] PHPMailer send failed: ' . $e->getMessage());
                // fall through to mail()
            }
        }

        // --- Fallback: PHP mail() ---
        $headers = [];
        $headers[] = 'From: ' . SITE_NAME . ' <' . $from . '>';
        if ($replyTo !== '' && filter_var($replyTo, FILTER_VALIDATE_EMAIL)) {
            $headers[] = 'Reply-To: ' . $replyTo;
        }
        $headers[] = 'Content-Type: text/plain; charset=UTF-8';
        $headers[] = 'X-Mailer: PHP/' . PHP_VERSION;

        return @mail($to, $subject, $body, implode("\r\n", $headers));
    }
}
