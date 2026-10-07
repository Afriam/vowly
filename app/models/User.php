<?php
class User {
    public static function find(int $id): ?array { return DB::one('SELECT id,name,email FROM users WHERE id=?', [$id]); }
    public static function byEmail(string $e): ?array { return DB::one('SELECT * FROM users WHERE email=?', [strtolower($e)]); }
    public static function create(string $name, string $email, string $pass): int {
        DB::q('INSERT INTO users(name,email,password_hash) VALUES(?,?,?)', [$name, strtolower($email), password_hash($pass, PASSWORD_DEFAULT)]);
        return DB::id();
    }
}
