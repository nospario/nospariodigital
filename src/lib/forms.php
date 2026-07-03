<?php
/**
 * Shared form-submission helpers: spam checks + response handling.
 */

declare(strict_types=1);

if (!function_exists('form_is_spam')) {
    /**
     * Honeypot + minimum-time check.
     * Bots tend to fill the hidden "website" field and submit instantly.
     */
    function form_is_spam(array $data, int $minSeconds = 3): bool
    {
        if (!empty($data['website'])) {
            return true; // honeypot tripped
        }
        $ts = isset($data['ts']) ? (int) $data['ts'] : 0;
        if ($ts > 0 && (time() - $ts) < $minSeconds) {
            return true; // submitted too fast
        }
        return false;
    }
}

if (!function_exists('wants_json')) {
    /** Did the request come from our fetch() enhancement? */
    function wants_json(): bool
    {
        $xhr = strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'xmlhttprequest';
        $accept = str_contains($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json');
        return $xhr || $accept;
    }
}

if (!function_exists('form_respond')) {
    /**
     * Send the appropriate response: JSON for fetch(), redirect for plain POST.
     *
     * @param bool   $ok     Whether the submission succeeded.
     * @param string $kind   'contact' | 'ticket'
     * @param string $anchor Section anchor to return to.
     */
    function form_respond(bool $ok, string $kind, string $anchor): void
    {
        if (wants_json()) {
            header('Content-Type: application/json');
            echo json_encode($ok ? ['ok' => true] : ['ok' => false, 'error' => 'Could not send your message. Please try again.']);
            exit;
        }
        $flag = $ok ? ('sent=' . $kind) : ('error=' . $kind);
        header('Location: /?' . $flag . '#' . $anchor, true, 303);
        exit;
    }
}

if (!function_exists('clean')) {
    /**
     * Trim + collapse a posted scalar to a safe string value.
     * Single-line by default: CR/LF are collapsed to spaces so values can
     * never inject mail headers. Pass $multiline = true only for free-text
     * fields (message/description), where newlines stay in the body only.
     */
    function clean(string $key, int $maxLen = 5000, bool $multiline = false): string
    {
        $v = (string) ($_POST[$key] ?? '');
        // Strip control chars except newlines/tabs.
        $v = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F]/u', '', $v) ?? '';
        if (!$multiline) {
            $v = preg_replace('/[\r\n\t]+/', ' ', $v) ?? '';
        }
        return mb_substr(trim($v), 0, $maxLen);
    }
}
