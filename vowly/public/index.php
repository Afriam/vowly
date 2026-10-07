<?php
declare(strict_types=1);
session_start();
define('ROOT', dirname(__DIR__));
define('APP', ROOT . '/app');
define('BASE_URL', rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/'));
$config = require ROOT . '/config/config.php';
require APP . '/core/helpers.php';
spl_autoload_register(function (string $c) {
    foreach (['core', 'controllers', 'models'] as $d) {
        $f = APP . "/$d/$c.php";
        if (is_file($f)) { require $f; return; }
    }
});
$router = new Router();
require ROOT . '/config/routes.php';
$path = '/' . trim(substr(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), strlen(BASE_URL)), '/');
$router->dispatch($_SERVER['REQUEST_METHOD'], $path);
