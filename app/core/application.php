<?php

namespace Wise\Core;

use Exception;

class Application
{
    public static string $ROOT_DIR;
    public static Application $app;
    public string $layout = 'main';
    public Request $request;
    public Response $response;
    public Router $router;
    public ?Controller $controller = null;
    public View $view;
    public Language $language;

    public function __construct($rootPath)
    {
        self::$ROOT_DIR     = $rootPath;
        self::$app          = $this;
        $this->request      = new Request();
        $this->response     = new Response();
        $this->router       = new Router($this->request, $this->response);
        $this->language     = new Language();
        $this->view         = new View();
    }

    public function run(): void
    {
        try {
            echo $this->router->resolve();
        }catch (Exception $e){
            $this->response->setStatusCode($e->getCode());
            echo $this->view->renderView('_error', [
                'exception' => $e
            ]);
        }
    }
}