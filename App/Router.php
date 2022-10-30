<?php

namespace App;

use App\Contracts\RouterInterface;

/**
 * @author  Joseph Abah
 *
 * Class Router - handle routing
 *
 * @package \App
 */
class Router implements RouterInterface
{
    // create some HTTP method constants here. We are going to store the routes based on each method
    private const HTTP_METHOD_POST = 'POST';
    private const HTTP_METHOD_GET = 'GET';
    private const HTTP_METHOD_PATCH = 'PATCH';
    private const HTTP_METHOD_PUT = 'PUT';
    private const HTTP_METHOD_DELETE = 'DELETE';

    private array $allowedMethods = [
        self::HTTP_METHOD_POST,
        self::HTTP_METHOD_GET,
        self::HTTP_METHOD_PATCH,
        self::HTTP_METHOD_PUT,
        self::HTTP_METHOD_DELETE
    ];

    private string $leftPlaceHolder = '{'; // {username}

    private string $rightPlaceHolder = '}'; // e.g {username}

    private static $instance; // ensure we only have a single instance

    private array $routes;

    private string $currentPath;

    private function __construct()
    {
    }

    public static function getInstance(): self
    {
        if (!static::$instance) {
            static::$instance = new self();
        }
        return static::$instance;
    }

    /**
     * @param $path     - e.g /about-us
     * @param $method   - e.g 'GET'
     * @param $callback - e.g function  function handleAbout($req, $res) {}
     *
     * @return void
     */
    private function addRoute($path, $method, $callback): void
    {
        if (!isset($this->routes[$method])) {
            $this->routes[$method] = [];
        }

        $routeInfo = $this->generateRouteRegex($path);

        if (!isset($this->routes[$method][$routeInfo['regex']])) {
            $this->routes[$method][$routeInfo['regex']] = [
                'path' => $routeInfo['regex'],
                'method' => $method,
                'callback' => $callback,
                'variables' => $routeInfo['variables']
            ];
        }
    }

    /**
     * This little function generates regex from the mapped URLs.
     *
     * @param $str
     *
     * @return array
     */
    private function generateRouteRegex($str): array
    {
        $url = ltrim(rtrim($str, '/'), '/');
        $urlParts = explode('/', $url);
        $routeRegx = [];
        $index = 0;
        foreach ($urlParts as $urlPart) {
            $placeholder = $this->getPlaceHolder($urlPart);
            if ($placeholder) {
                $urlPart = ['regex' => '([\w+-\@]+)', 'placeholder' => $placeholder, 'path' => null, 'index' => $index];
            } else {
                $urlPart = ['regex' => '(' . $urlPart . ')', 'path' => $urlPart, 'placeholder' => null, 'index' => $index];
            }
            $routeRegx[] = $urlPart;
            $index++;
        }

        $fullRegex = [];
        $variables = [];
        foreach ($routeRegx as $r) {
            $fullRegex[] = $r['regex'];
            if ($r['placeholder']) {
                $variables[] = ['variable' => $r['placeholder'], 'index' => $r['index'] + 1];
            }

        }

        return $str === '/' ? ['regex' => '(\/)', 'variables' => []] : ['regex' => implode('\/', $fullRegex), 'variables' => $variables];
    }


    /**
     * Get the current path.
     *
     * @return string
     */
    public function getCurrentPath(): string
    {
        $this->currentPath = isset($_SERVER['PATH_INFO']) ? rtrim($_SERVER['PATH_INFO']) : '/';

        if ($this->currentPath !== '/' && $this->currentPath[strlen($this->currentPath) - 1] === '/') {
            $this->currentPath = substr($this->currentPath, 0, -1);
        }

        return $this->currentPath;
    }

    /**
     * We use this to extract the place holder name from the route config. e.g {name} => name
     *
     * @param string $str
     *
     * @return string|null
     */
    protected function getPlaceHolder(string $str): ?string
    {
        if ($str !== '' && $str[0] === $this->leftPlaceHolder && $str[strlen($str) - 1] === $this->rightPlaceHolder) {
            $str = str_replace(array($this->leftPlaceHolder, $this->rightPlaceHolder), '', $str);
            return trim($str);
        }
        return null;
    }

    public function getMethodRoutes(string $method): array
    {
        return $this->routes[$method] ?? [];
    }

    public function routes(): array
    {
        return $this->routes;
    }

    /**
     * This is the real magic - we call the function based on the route
     *
     * @param $name
     * @param $arguments
     *
     * @return void
     */
    public function __call($name, $arguments)
    {
        $methodName = strtoupper($name);
        if (in_array($methodName, $this->allowedMethods, true) && count($arguments) >= 2) {
            $this->addRoute($arguments[0], $methodName, $arguments[1]);
        }
    }
}
