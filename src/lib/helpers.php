<?php
/**
 * Small view helpers used across templates.
 */

declare(strict_types=1);

if (!function_exists('e')) {
    /** HTML-escape a value for safe output. */
    function e(?string $value): string
    {
        return htmlspecialchars($value ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}

if (!function_exists('asset')) {
    /** Build a root-relative URL to a file under /assets. */
    function asset(string $path): string
    {
        return '/assets/' . ltrim($path, '/');
    }
}

if (!function_exists('url')) {
    /** Build an absolute URL from a site-relative path. */
    function url(string $path = '/'): string
    {
        return SITE_URL . '/' . ltrim($path, '/');
    }
}

if (!function_exists('render_partial')) {
    /**
     * Render a file from /src with an extracted data array, returning the markup.
     * Paths are relative to the src/ directory, e.g. render_partial('sections/hero.php').
     */
    function render_partial(string $relPath, array $data = []): string
    {
        $full = dirname(__DIR__) . '/' . ltrim($relPath, '/');
        if (!is_file($full)) {
            return '';
        }
        extract($data, EXTR_SKIP);
        ob_start();
        require $full;
        return (string) ob_get_clean();
    }
}

if (!function_exists('load_data')) {
    /** Require a data file from /src/data and return its array. */
    function load_data(string $name): array
    {
        $full = dirname(__DIR__) . '/data/' . $name . '.php';
        return is_file($full) ? (array) require $full : [];
    }
}

if (!function_exists('fmt')) {
    /**
     * Escape text, then turn **bold** into <strong>, `code` into <code>
     * and [text](url) into a link.
     * Used for content strings in data files (e.g. data/email-guide.php).
     */
    function fmt(string $text, string $codeClass = 'gcode'): string
    {
        $html = e($text);
        $html = preg_replace('/\*\*(.+?)\*\*/', '<strong>$1</strong>', $html);
        $html = preg_replace('/`(.+?)`/', '<code class="' . e($codeClass) . '">$1</code>', $html);
        // [text](/path) or [text](https://…) → link (text and URL already escaped above).
        return preg_replace('#\[([^\]]+)\]\((/[^)\s]*|https?://[^)\s]+)\)#', '<a href="$2">$1</a>', $html);
    }
}
