<?php
class Wedding {
    // key => [label, background, text, accent, soft]
    const THEMES = [
        'garden'   => ['Garden', '#f6f8f3', '#27332b', '#5f7f63', '#e4ebdf'],
        'blush'    => ['Blush', '#fff7f7', '#3a2a30', '#c0687c', '#f8e4e8'],
        'midnight' => ['Midnight', '#141b2d', '#eef0f6', '#d4b36a', '#222c47'],
        'ivory'    => ['Ivory & Gold', '#fbf8f1', '#2d2a24', '#a8843c', '#efe8d6'],
    ];
    const HEADING_FONTS = ['Playfair Display', 'Cormorant Garamond', 'Great Vibes', 'Dancing Script', 'Lora', 'Bodoni Moda'];
    const BODY_FONTS = ['Montserrat', 'Lato', 'Nunito', 'Libre Baskerville', 'Jost'];
    const ROLES = [
        'Principal Sponsor', 'Secondary Sponsor', 'Best Man', 'Maid of Honor', 'Groomsman', 'Bridesmaid',
        'Ring Bearer', 'Coin Bearer', 'Bible Bearer', 'Flower Girl', 'Other',
    ];

    public static function byUser(int $uid): ?array { return DB::one('SELECT * FROM weddings WHERE user_id=?', [$uid]); }
    public static function bySlug(string $s): ?array { return DB::one('SELECT * FROM weddings WHERE slug=?', [$s]); }
    public static function slugTaken(string $s): bool { return (bool)DB::one('SELECT id FROM weddings WHERE slug=?', [$s]); }
    public static function create(int $uid, string $slug, string $groom, string $bride): int {
        DB::q('INSERT INTO weddings(user_id,slug,groom_name,bride_name) VALUES(?,?,?,?)', [$uid, $slug, $groom, $bride]);
        return DB::id();
    }
    /** Updates only whitelisted columns, so column names are never user-controlled. */
    public static function save(int $id, array $data, array $allowed): void {
        $data = array_intersect_key($data, array_flip($allowed));
        if (!$data) return;
        $set = implode(',', array_map(fn($k) => "`$k`=?", array_keys($data)));
        DB::q("UPDATE weddings SET $set WHERE id=?", [...array_values($data), $id]);
    }
}
