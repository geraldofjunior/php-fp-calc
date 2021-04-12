<?php
namespace Point_Calc_Php\Core\Services\Router;

class Router {
    private array $routes = [];

    public function on(string $method, string $path, mixed $callback) : Router {
        $method = strtolower($method);
        if (!isset($this->routes[$method])) {
            $this->routes[$method] = [];
        }

        $url = substr($path, 0, 1) !== "/" ? '/' . $path : $path;
        $pattern = str_replace('/', '\/', $url);
        $route = '/^' . $pattern . '$/';
        $this->routes[$method][$route] = $callback;

        return $this;
    }

    public function run(string $method, string $uri) {
        $method = strtolower($method);
        if ( !isset( $this->routes[$method] ) ) {
            return null;
        }

        foreach ( $this->routes[$method] as $route => $callback) {
            if (preg_match($route, $uri, $parameters)) {
                array_shift($parameters);
                return call_user_func_array($callback, $parameters);
            }
        }

        return null;
    }

    public function getMethod() : string {
        return isset($_SERVER['REQUEST_METHOD']) ? strtolower($_SERVER['REQUEST_METHOD']) : 'cli';
    }

    public function getUri() : string {
        $self = isset($_SERVER['PHP_SELF']) ? str_replace('index.php/', '', $_SERVER['PHP_SELF']) : '';
        $uri = isset($_SERVER['QUERY_STRING']) ?? '';

        if ($uri !== $self) {
            $pieces = explode('/', $self);
            array_pop($pieces);
            $start = implode('/', $pieces);
            $search = '/' . preg_quote($start, '/') . '/';
            $uri = preg_replace($search, '', $uri, 1);
        }

        return $uri;
    }

    public function __construct() {
    }
}