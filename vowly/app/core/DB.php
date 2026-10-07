<?php
class DB {
    private static ?PDO $pdo = null;
    public static function pdo(): PDO {
        if (!self::$pdo) {
            global $config; $c = $config['db'];
            self::$pdo = new PDO("mysql:host={$c['host']};dbname={$c['name']};charset={$c['charset']}", $c['user'], $c['pass'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        }
        return self::$pdo;
    }
    public static function q(string $sql, array $a = []): PDOStatement { $s = self::pdo()->prepare($sql); $s->execute($a); return $s; }
    public static function one(string $sql, array $a = []): ?array { return self::q($sql, $a)->fetch() ?: null; }
    public static function all(string $sql, array $a = []): array { return self::q($sql, $a)->fetchAll(); }
    public static function id(): int { return (int)self::pdo()->lastInsertId(); }
}
