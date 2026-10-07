<?php
class EditorController extends Controller {
    private array $w;
    public function __construct() {
        parent::__construct();
        $this->requireAuth();
        $w = Wedding::byUser(Auth::id());
        if (!$w) { flash('error', 'Create your wedding site first.'); redirect('dashboard'); }
        $this->w = $w;
    }
    private function page(string $v, string $tab, array $d = []): void {
        $this->view("editor/$v", $d + ['w' => $this->w, 'tab' => $tab]);
    }

    /* ---- Details ---- */
    public function details(): void { $this->page('details', 'details'); }
    public function saveDetails(): void {
        $f = ['groom_name', 'bride_name', 'groom_father', 'groom_mother', 'bride_father', 'bride_mother',
              'ceremony_venue', 'ceremony_address', 'ceremony_time', 'reception_venue', 'reception_address',
              'reception_time', 'dress_code', 'story'];
        $d = [];
        foreach ($f as $k) $d[$k] = post($k);
        if ($d['groom_name'] === '' || $d['bride_name'] === '') { flash('error', 'Both names are required.'); redirect('editor/details'); }
        $date = post('wedding_date');
        $d['wedding_date'] = ($date !== '' && strtotime($date)) ? date('Y-m-d', strtotime($date)) : null;
        Wedding::save($this->w['id'], $d, [...$f, 'wedding_date']);
        flash('ok', 'Details saved.');
        redirect('editor/details');
    }

    /* ---- Entourage ---- */
    public function entourage(): void { $this->page('entourage', 'entourage', ['people' => Entourage::all($this->w['id'])]); }
    public function addEntourage(): void {
        $role = post('role');
        if (!in_array($role, Wedding::ROLES, true)) { flash('error', 'Choose a role.'); redirect('editor/entourage'); }
        $n = 0;
        foreach (preg_split('/\R/', (string)($_POST['names'] ?? '')) as $line) {
            $line = trim($line);
            if ($line !== '') { Entourage::add($this->w['id'], $role, mb_substr($line, 0, 120)); $n++; }
        }
        flash($n ? 'ok' : 'error', $n ? "$n added." : 'Enter at least one name.');
        redirect('editor/entourage');
    }
    public function deleteEntourage(string $id): void { Entourage::delete((int)$id, $this->w['id']); redirect('editor/entourage'); }

    /* ---- Gallery and videos ---- */
    public function media(): void { $this->page('media', 'media', ['items' => Media::all($this->w['id'])]); }
    public function upload(): void {
        try {
            [$type, $path] = Upload::save($_FILES['file'] ?? [], $this->w['id']);
            Media::add($this->w['id'], $type, $path, mb_substr(post('caption'), 0, 255));
            flash('ok', ucfirst($type) . ' uploaded.');
        } catch (RuntimeException $e) { flash('error', $e->getMessage()); }
        redirect('editor/media');
    }
    public function caption(string $id): void {
        Media::caption((int)$id, $this->w['id'], mb_substr(post('caption'), 0, 255));
        flash('ok', 'Description saved.');
        redirect('editor/media');
    }
    public function setHero(string $id): void {
        if (Media::find((int)$id, $this->w['id'])) { Wedding::save($this->w['id'], ['hero_media_id' => (int)$id], ['hero_media_id']); flash('ok', 'Hero background updated.'); }
        redirect('editor/media');
    }
    public function clearHero(): void { Wedding::save($this->w['id'], ['hero_media_id' => null], ['hero_media_id']); redirect('editor/media'); }
    public function deleteMedia(string $id): void {
        $m = Media::find((int)$id, $this->w['id']);
        if ($m) {
            Upload::remove($m['path']);
            Media::delete((int)$id, $this->w['id']);
            if ((int)$this->w['hero_media_id'] === (int)$id) Wedding::save($this->w['id'], ['hero_media_id' => null], ['hero_media_id']);
            flash('ok', 'File deleted.');
        }
        redirect('editor/media');
    }

    /* ---- Design ---- */
    public function design(): void { $this->page('design', 'design'); }
    public function saveDesign(): void {
        $theme = post('theme'); $h = post('font_heading'); $b = post('font_body');
        $accent = (post('use_accent') === '1' && preg_match('/^#[0-9a-fA-F]{6}$/', post('accent'))) ? post('accent') : null;
        if (!isset(Wedding::THEMES[$theme]) || !in_array($h, Wedding::HEADING_FONTS, true) || !in_array($b, Wedding::BODY_FONTS, true)) {
            flash('error', 'Pick a theme and fonts from the lists.'); redirect('editor/design');
        }
        Wedding::save($this->w['id'], ['theme' => $theme, 'font_heading' => $h, 'font_body' => $b, 'accent' => $accent], ['theme', 'font_heading', 'font_body', 'accent']);
        flash('ok', 'Design saved.');
        redirect('editor/design');
    }

    /* ---- Publish and RSVPs ---- */
    public function publish(): void { $this->page('publish', 'publish'); }
    public function togglePublish(): void {
        Wedding::save($this->w['id'], ['is_published' => $this->w['is_published'] ? 0 : 1], ['is_published']);
        flash('ok', $this->w['is_published'] ? 'Your site is now hidden.' : 'Your site is published.');
        redirect('editor/publish');
    }
    public function rsvps(): void { $this->page('rsvps', 'rsvps', ['rows' => Rsvp::all($this->w['id'])]); }
}
