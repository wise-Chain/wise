<?php

namespace Wise\Core;

use Exception;

class Router
{
    public Request $request;
    public Response $response;
    protected array $routes = [];

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }
    public function get(string $route, $callback): void
    {
        $this->routes['get'][$route] = $callback;
    }

    /**
     * @throws Exception
     */
    public function resolve()
    {
        $path       = $this->request->path();
        $method     = $this->request->method();
        $callback   = $this->routes[$method][$path] ?? false;
        if (!$callback){
            throw new Exception("Page Not Found", 404);
        }
        if (is_array($callback)){
            $controller = new $callback[0]();
            Application::$app->controller = $controller;
            $controller->action = $callback[1];
            $callback[0] = $controller;
        }
        return call_user_func($callback, $this->request, $this->response);
    }
}