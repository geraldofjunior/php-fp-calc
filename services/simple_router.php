<?php
namespace Point_Calc_Php\Services;

class SimpleRouter {
    private $routes;
    private static $instance;

    /*  It is a singleton because we want to have only one router
        And we want only 1 router because everyone will want to
        have access to every route. */

    private function __construct() {
        $this->routes = [];
    }
    private function __clone() {}
    public function __wakeup() {
        throw new \Exception("Cannot unserialize a singleton.");
    }
    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function route(string $path) {
        if (isset($this->routes[$path])) {
            include $this->routes[$path];
        }
    }

    public function addRoute(string $alias, string $path) {
        $this->routes[$alias] = $path;
    }
}
?>