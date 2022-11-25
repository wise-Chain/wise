<?php

namespace Wise\Core;

abstract class Controller
{
    public string $layout = 'main';

    public function render($view, $params = []): bool|array|string
    {
        return Application::$app->view->renderView($view, $params);
    }
}