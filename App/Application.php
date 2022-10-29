<?php

namespace App;

use App\Contracts\RouterInterface;
use App\Exceptions\RouteNotFoundException;
use App\Http\Request;
use App\Http\Response;
use http\Exception\InvalidArgumentException;

/**
 * @author Joseph Abah
 *
 * Class Application
 *
 * Handle core function of the app like routing, request and response
 */
class Application
{

    private static $instance;

    private Request $request;

    private Response $response;


    /**
     * @var \App\Contracts\RouterInterface
     */
    private RouterInterface $router;

    private function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public static function getInstance(RouterInterface $router, Request $request, Response $response): self
    {
        if (!static::$instance) {
            static::$instance = new self($router);
            static::$instance->request = $request;
            static::$instance->response = $response;

        }
        return static::$instance;
    }

    /**
     * Mount is responsible for handling http request
     *
     * @throws \App\Exceptions\RouteNotFoundException
     */
    public function mount(): mixed
    {
        $routes = $this->router->getMethodRoutes($_SERVER['REQUEST_METHOD']);
        $currentRoute = null;
        $routeMatches = null;

        foreach ($routes as $regex => $r) {
            preg_match('@' . $regex . '$@', $this->router->getCurrentPath(), $matches);
            if ($matches) {
                $currentRoute = $r;
                $routeMatches = $matches;
            }
        }

        if (!$currentRoute) {
            throw new RouteNotFoundException('route not found');
        }

        $handler = $currentRoute['callback']; //TODO: add error check
        $nVariables = count($currentRoute['variables']);

        for ($i = 0; $i < $nVariables; $i++) {
            $currentRoute['variables'][$i]['data'] = $routeMatches[$currentRoute['variables'][$i]['index']];
        }

        if ($this->isClosure($handler)) {
            return $this->handleClosure($handler);
        } elseif (is_array($handler)) {
            return $this->handleClassController($handler);
        }

        throw new InvalidArgumentException('InvalidHandlerException ' . $handler);
    }

    public function isClosure($t): bool
    {
        return $t instanceof \Closure;
    }


    private function handleClosure($handler)
    {
        return call_user_func($handler, $this->request, $this->response);
    }

    private function handleClassController($handler)
    {

        $controller = $handler[0];
        $action = isset($handler[1]) ? trim($handler[1]) : 'index';

        $instance = new $controller();

        return call_user_func([$instance, $action], $this->request, $this->response);
    }
}
