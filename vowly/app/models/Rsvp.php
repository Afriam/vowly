<?php
class Rsvp {
    public static function add(int $wid, string $name, string $email, int $attending, int $guests, string $msg): void {
        DB::q('INSERT INTO rsvps(wedding_id,name,email,attending,guests,message) VALUES(?,?,?,?,?,?)', [$wid, $name, $email, $attending, $guests, $msg]);
    }
    public static function all(int $wid): array { return DB::all('SELECT * FROM rsvps WHERE wedding_id=? ORDER BY id DESC', [$wid]); }
}
