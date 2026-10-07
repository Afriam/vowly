<?php
class Entourage {
    public static function all(int $wid): array { return DB::all('SELECT * FROM entourage WHERE wedding_id=? ORDER BY id', [$wid]); }
    public static function grouped(int $wid): array {
        $g = [];
        foreach (Wedding::ROLES as $r) $g[$r] = [];
        foreach (self::all($wid) as $p) $g[$p['role']][] = $p['name'];
        return array_filter($g);
    }
    public static function add(int $wid, string $role, string $name): void { DB::q('INSERT INTO entourage(wedding_id,role,name) VALUES(?,?,?)', [$wid, $role, $name]); }
    public static function delete(int $id, int $wid): void { DB::q('DELETE FROM entourage WHERE id=? AND wedding_id=?', [$id, $wid]); }
}
