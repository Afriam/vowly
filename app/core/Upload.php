<?php
class Upload {
    const IMG = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp', 'image/gif' => 'gif'];
    const VID = ['video/mp4' => 'mp4', 'video/webm' => 'webm'];

    /** Validates by real MIME type and returns [type, relativePath]. */
    public static function save(array $f, int $weddingId): array {
        if (($f['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            $big = in_array($f['error'] ?? 0, [UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE], true);
            throw new RuntimeException($big ? 'The file is over the server upload limit. Raise upload_max_filesize and post_max_size in php.ini.' : 'Choose a file to upload.');
        }
        $mime = (new finfo(FILEINFO_MIME_TYPE))->file($f['tmp_name']);
        if (isset(self::IMG[$mime])) { $type = 'image'; $ext = self::IMG[$mime]; $max = 8; }
        elseif (isset(self::VID[$mime])) { $type = 'video'; $ext = self::VID[$mime]; $max = 60; }
        else throw new RuntimeException('Use JPG, PNG, WebP, GIF, MP4 or WebM files.');
        if ($f['size'] > $max * 1048576) throw new RuntimeException("{$type}s can be up to {$max} MB.");
        $dir = ROOT . "/public/uploads/$weddingId";
        if (!is_dir($dir)) mkdir($dir, 0755, true);
        $name = bin2hex(random_bytes(10)) . ".$ext";
        if (!move_uploaded_file($f['tmp_name'], "$dir/$name")) throw new RuntimeException('Could not save the file on the server.');
        return [$type, "uploads/$weddingId/$name"];
    }
    public static function remove(string $path): void {
        $f = ROOT . '/public/' . $path;
        if (is_file($f)) unlink($f);
    }
}
