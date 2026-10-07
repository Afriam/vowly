# Vowly: wedding website builder (PHP 8 + MySQL, MVC)

## Setup
1. Import `database/schema.sql` (phpMyAdmin or `mysql -u root < database/schema.sql`).
2. Edit `config/config.php` with your MySQL login.
3. Point Apache's document root at `public/` (needs `mod_rewrite` and `AllowOverride All`).
   Or for a quick test: `php -S localhost:8000 -t public public/index.php`
4. Make `public/uploads/` writable by the web server.
5. For videos, raise `upload_max_filesize` and `post_max_size` to 64M in php.ini.
6. Open `/register`, create an account, then your site.

## Structure
- `public/index.php` front controller; `config/routes.php` all routes
- `app/core` Router, View, DB (PDO), Auth, Upload, Controller (CSRF check on every POST)
- `app/models` User, Wedding, Media, Entourage, Rsvp
- `app/controllers` Auth, Dashboard, Editor (details, entourage, media, design, publish, RSVPs), Site (public page + RSVP)
- `app/views` builder pages; `app/views/site/show.php` is the guest-facing wedding page at `/w/{slug}`

## Security notes
Prepared statements everywhere, password_hash, CSRF tokens, uploads checked by real MIME type and renamed, ownership checks on every edit, RSVP honeypot.
Ideas to add next: email verification, password reset, custom domains, more themes, RSVP CSV export, music.
