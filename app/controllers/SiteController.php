<?php
class SiteController extends Controller {
    private function load(string $slug): ?array {
        $w = Wedding::bySlug($slug);
        if (!$w) return null;
        $owner = Auth::check() && Auth::id() === (int)$w['user_id'];
        return ($w['is_published'] || $owner) ? $w + ['_owner' => $owner] : null;
    }
    public function show(string $slug): void {
        $w = $this->load($slug);
        if (!$w) { http_response_code(404); $this->view('errors/404'); return; }
        $media = Media::all($w['id']);
        $hero = null;
        foreach ($media as $m) if ((int)$m['id'] === (int)$w['hero_media_id']) $hero = $m;
        $this->view('site/show', [
            'w' => $w, 'hero' => $hero, 'people' => Entourage::grouped($w['id']),
            'photos' => array_values(array_filter($media, fn($m) => $m['type'] === 'image')),
            'videos' => array_values(array_filter($media, fn($m) => $m['type'] === 'video')),
            'sent' => flash('rsvp'),
        ], null);
    }
    public function rsvp(string $slug): void {
        $w = $this->load($slug);
        if (!$w) { http_response_code(404); exit; }
        $name = post('name');
        if (post('website') === '' && $name !== '') {   // 'website' is a honeypot field
            Rsvp::add($w['id'], mb_substr($name, 0, 120), mb_substr(post('email'), 0, 190),
                post('attending') === '1' ? 1 : 0, max(1, min(10, (int)post('guests', '1'))), mb_substr(post('message'), 0, 1000));
            flash('rsvp', 'Thank you! Your reply has been sent.');
        }
        redirect("w/$slug#rsvp");
    }
}
