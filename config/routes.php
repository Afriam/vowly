<?php
/** @var Router $router */
$router->add('GET',  '/', [HomeController::class, 'index']);

$router->add('GET',  '/login', [AuthController::class, 'loginForm']);
$router->add('POST', '/login', [AuthController::class, 'login']);
$router->add('GET',  '/register', [AuthController::class, 'registerForm']);
$router->add('POST', '/register', [AuthController::class, 'register']);
$router->add('POST', '/logout', [AuthController::class, 'logout']);

$router->add('GET',  '/dashboard', [DashboardController::class, 'index']);
$router->add('POST', '/dashboard/create', [DashboardController::class, 'create']);

$router->add('GET',  '/editor/details', [EditorController::class, 'details']);
$router->add('POST', '/editor/details', [EditorController::class, 'saveDetails']);
$router->add('GET',  '/editor/entourage', [EditorController::class, 'entourage']);
$router->add('POST', '/editor/entourage', [EditorController::class, 'addEntourage']);
$router->add('POST', '/editor/entourage/delete/{id}', [EditorController::class, 'deleteEntourage']);
$router->add('GET',  '/editor/media', [EditorController::class, 'media']);
$router->add('POST', '/editor/media/upload', [EditorController::class, 'upload']);
$router->add('POST', '/editor/media/caption/{id}', [EditorController::class, 'caption']);
$router->add('POST', '/editor/media/hero/{id}', [EditorController::class, 'setHero']);
$router->add('POST', '/editor/media/clear-hero', [EditorController::class, 'clearHero']);
$router->add('POST', '/editor/media/delete/{id}', [EditorController::class, 'deleteMedia']);
$router->add('GET',  '/editor/design', [EditorController::class, 'design']);
$router->add('POST', '/editor/design', [EditorController::class, 'saveDesign']);
$router->add('GET',  '/editor/publish', [EditorController::class, 'publish']);
$router->add('POST', '/editor/publish', [EditorController::class, 'togglePublish']);
$router->add('GET',  '/editor/rsvps', [EditorController::class, 'rsvps']);

$router->add('GET',  '/w/{slug}', [SiteController::class, 'show']);
$router->add('POST', '/w/{slug}/rsvp', [SiteController::class, 'rsvp']);
