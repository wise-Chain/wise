<?php
namespace Wise\Core;

class View
{
    protected function renderOnlyView($view,$params = []): bool|string
    {
        foreach ($params as $key => $value){
            $$key = $value;
        }
        ob_start();
        extract(
            array_merge(
                Application::$app->language->load('default'),
                Application::$app->language->load($view)
            )
        );
        include_once Application::$ROOT_DIR . 'view' . DS . "$view.php";
        return ob_get_clean();
    }

    protected function layoutContent(): bool|string
    {
        $layout = Application::$app->layout;
        if (Application::$app->controller){
            $layout =  Application::$app->controller->layout;
        }
        ob_start();
        include_once Application::$ROOT_DIR.'view'.DS.'layouts'.DS."$layout.php";
        return ob_get_clean();
    }

    public function renderView($view, $params = []): array|bool|string
    {
        $viewContent    = $this->renderOnlyView($view, $params);
        $layoutContent  = $this->layoutContent();
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }
}