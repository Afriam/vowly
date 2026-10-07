<?php
class Media {
    public static function all(int $wid): array { return DB::all('SELECT * FROM media WHERE wedding_id=? ORDER BY id', [$wid]); }
    public static function find(int $id, int $wid): ?array { return DB::one('SELECT * FROM media WHERE id=? AND wedding_id=?', [$id, $wid]); }
    public static function add(int $wid, string $type, string $path, string $caption): int {
        DB::q('INSERT INTO media(wedding_id,type,path,caption) VALUES(?,?,?,?)', [$wid, $type, $path, $caption]);
        return DB::id();
    }
    public static function caption(int $id, int $wid, string $c): void { DB::q('UPDATE media SET caption=? WHERE id=? AND wedding_id=?', [$c, $id, $wid]); }
    public static function delete(int $id, int $wid): void { DB::q('DELETE FROM media WHERE id=? AND wedding_id=?', [$id, $wid]); }
}
