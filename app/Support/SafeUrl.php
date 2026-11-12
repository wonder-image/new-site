<?php

namespace App\Support;

final class SafeUrl
{
    /**
     * Restituisce l'URL solo se è assoluto con schema http/https e host,
     * altrimenti il fallback (blocca `javascript:`, `data:`, `//host`, ...).
     * Rifiuta anche le credenziali nell'host (`user@`, `user:pass@`).
     */
    public static function http(mixed $url, string $fallback = '#'): string
    {
        if (!is_string($url)) {
            return $fallback;
        }

        $url = trim($url);
        $parts = $url === '' ? false : parse_url($url);

        if (!is_array($parts) || empty($parts['host']) || isset($parts['user']) || isset($parts['pass'])) {
            return $fallback;
        }

        $scheme = strtolower((string) ($parts['scheme'] ?? ''));

        return in_array($scheme, ['http', 'https'], true) ? $url : $fallback;
    }
}
