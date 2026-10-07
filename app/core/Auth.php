<?php
class Auth {
    public static function check(): bool { return isset($_SESSION['uid']); }
    public static function id(): ?int { return $_SESSION['uid'] ?? null; }
    public static function login(int $id): void { session_regenerate_id(true); $_SESSION['uid'] = $id; }
    public static function logout(): void { $_SESSION = []; session_destroy(); }
    public static function user(): ?array { return self::check() ? User::find(self::id()) : null; }
}
