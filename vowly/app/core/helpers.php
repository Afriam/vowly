<?php
function e($s): string { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
function url(string $p = ''): string { return BASE_URL . '/' . ltrim($p, '/'); }
function redirect(string $p): void { header('Location: ' . url($p)); exit; }
function csrf(): string { return $_SESSION['csrf'] ??= bin2hex(random_bytes(16)); }
function csrf_field(): string { return '<input type="hidden" name="_csrf" value="' . csrf() . '">'; }
function flash(string $k, ?string $v = null): ?string {
    if ($v !== null) { $_SESSION['flash'][$k] = $v; return null; }
    $x = $_SESSION['flash'][$k] ?? null; unset($_SESSION['flash'][$k]); return $x;
}
function post(string $k, string $d = ''): string { return trim((string)($_POST[$k] ?? $d)); }
