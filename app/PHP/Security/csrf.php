<?php
// PHP session_start() must be called before using these helpers.
function recoConCsrfToken(): string {
    if (empty($_SESSION['recocon_csrf_token'])) {
        $_SESSION['recocon_csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['recocon_csrf_token'];
}
function recoConCsrfValid($submitted): bool {
    return is_string($submitted)
        && isset($_SESSION['recocon_csrf_token'])
        && hash_equals($_SESSION['recocon_csrf_token'], $submitted);
}
