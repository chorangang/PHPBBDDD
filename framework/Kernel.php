<?php

namespace Framework;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

class Kernel
{
    public function handle(Request $request): Response
    {
        $dispatcher = simpleDispatcher(function (RouteCollector $routeCollector) {
            $routes = include BASE_PATH . "/routes/api.php";
            foreach ($routes as $route) {
                $routeCollector->addRoute(...$route);
            }
        });

        $routeInfo = $dispatcher->dispatch(
            $request->getMethod(),
            $request->getPathInfo()
        );

        [$status, [$controller, $method], $vars] = $routeInfo;

        switch ($status) {
            case Dispatcher::NOT_FOUND:
                return new Response('404 Not Found', 404);
                break;
            case Dispatcher::METHOD_NOT_ALLOWED:
                return new Response('405 Method Not Allowed', 405);
                break;
            case Dispatcher::FOUND:
                $response = call_user_func_array([new $controller, $method], [$request, ...$vars]);
                return $response;
                break;
            default:
                return new Response('500 Internal Server Error', 500);
        }
    }
}
