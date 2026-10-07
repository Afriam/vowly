<?php
abstract class Controller {
    public function __construct() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !hash_equals(csrf(), $_POST['_csrf'] ?? '')) {
            http_response_code(419);
            exit('Your session expired. Go back, refresh the page and try again.');
        }
    }
    protected function view(string $v, array $d = [], ?string $layout = 'layouts/main'): void { View::render($v, $d, $layout); }
    protected function requireAuth(): void {
        if (!Auth::check()) { flash('error', 'Log in to continue.'); redirect('login'); }
    }
}
