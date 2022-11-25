<?php

namespace Wise;

use Wise\Core\Application;
use Wise\Controller\SiteController;

require_once 'init.php';

$app = new Application(APP_PATH);
$app->router->get('/',[SiteController::class, 'Home']);
$app->router->get('/'.'about', [SiteController::class, 'About']);
$app->router->get('/'.'language', [SiteController::class, 'Language']);
$app->run();