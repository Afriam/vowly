<?php
class Router {
    private array $routes = [];
    public function add(string $method, string $pattern, array $handler): void {
        $re = '#^' . preg_replace('#\{(\w+)\}#', '(?P<$1>[^/]+)', $pattern) . '$#';
        $this->routes[] = [$method, $re, $handler];
    }
    public function dispatch(string $method, string $path): void {
        foreach ($this->routes as [$m, $re, $h]) {
            if ($m === $method && preg_match($re, $path, $mt)) {
                $args = array_values(array_filter($mt, 'is_string', ARRAY_FILTER_USE_KEY));
                [$class, $action] = $h;
                (new $class())->$action(...$args);
                return;
            }
        }
        http_response_code(404);
        View::render('errors/404');
    }
}
