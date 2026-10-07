<?php
class View {
    public static function render(string $view, array $data = [], ?string $layout = 'layouts/main'): void {
        extract($data);
        ob_start();
        require APP . "/views/$view.php";
        $content = ob_get_clean();
        if ($layout) { require APP . "/views/$layout.php"; } else { echo $content; }
    }
}
