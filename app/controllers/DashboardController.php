<?php
class DashboardController extends Controller {
    public function index(): void {
        $this->requireAuth();
        $w = Wedding::byUser(Auth::id());
        $stats = $w ? [
            'photos' => count(array_filter(Media::all($w['id']), fn($m) => $m['type'] === 'image')),
            'videos' => count(array_filter(Media::all($w['id']), fn($m) => $m['type'] === 'video')),
            'people' => count(Entourage::all($w['id'])),
            'rsvps'  => count(Rsvp::all($w['id'])),
        ] : [];
        $this->view('dashboard/index', ['w' => $w, 'stats' => $stats, 'user' => Auth::user()]);
    }
    public function create(): void {
        $this->requireAuth();
        if (Wedding::byUser(Auth::id())) redirect('dashboard');
        $groom = post('groom_name'); $bride = post('bride_name');
        $slug = strtolower(post('slug'));
        $err = null;
        if ($groom === '' || $bride === '') $err = 'Enter both names.';
        elseif (!preg_match('/^[a-z0-9]+(-[a-z0-9]+)*$/', $slug) || strlen($slug) < 3 || strlen($slug) > 40) $err = 'The web address needs 3 to 40 letters, numbers or hyphens.';
        elseif (Wedding::slugTaken($slug)) $err = 'That web address is taken. Try another.';
        if ($err) { flash('error', $err); redirect('dashboard'); }
        Wedding::create(Auth::id(), $slug, $groom, $bride);
        flash('ok', 'Your site is created. Fill in the details next.');
        redirect('editor/details');
    }
}
