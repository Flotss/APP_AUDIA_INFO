<?php

namespace App\Router;

use App\Exceptions\RouterException;

/**
 * The Router class handles routing and URL generation for the application.
 */
class Router
{

    /**
     * The current URL being accessed.
     *
     * @var string
     */
    public $url;

    /**
     * The registered routes.
     *
     * @var array
     */
    private $routes = [];

    /**
     * The named routes.
     *
     * @var array
     */
    private $namedRoutes = [];

    /**
     * Create a new Router instance.
     *
     * @param string $url The current URL being accessed.
     */
    public function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * Register a GET route.
     *
     * @param string $path The route path.
     * @param mixed $callable The callback function or controller action.
     * @param string|null $name The name of the route.
     * @return Route The created Route instance.
     */
    public function get($path, $callable, $name = null)
    {
        return $this->add($path, $callable, $name, 'GET');
    }

    /**
     * Register a POST route.
     *
     * @param string $path The route path.
     * @param mixed $callable The callback function or controller action.
     * @param string|null $name The name of the route.
     * @return Route The created Route instance.
     */
    public function post($path, $callable, $name = null)
    {
        return $this->add($path, $callable, $name, 'POST');
    }

    /**
     * Add a route to the registered routes.
     *
     * @param string $path The route path.
     * @param mixed $callable The callback function or controller action.
     * @param string|null $name The name of the route.
     * @param string $method The HTTP method.
     * @return Route The created Route instance.
     */
    private function add($path, $callable, $name, $method)
    {
        $route = new Route($path, $callable);
        $this->routes[$method][] = $route;
        if (is_string($callable) && $name === null) {
            $name = $callable;
        }
        if ($name) {
            $this->namedRoutes[$name] = $route;
        }
        return $route;
    }

    /**
     * Run the router and execute the matching route.
     *
     * @throws RouterException If no matching routes are found.
     * @return mixed The result of the matched route's callback function or controller action.
     */
    public function run()
    {
        if (!isset($this->routes[$_SERVER['REQUEST_METHOD']])) {
            throw new RouterException('REQUEST_METHOD does not exist');
        }
        foreach ($this->routes[$_SERVER['REQUEST_METHOD']] as $route) {
            if ($route->match($this->url)) {
                return $route->call();
            }
        }
        throw new RouterException('No matching routes');
    }

    /**
     * Generate the URL for a named route.
     *
     * @param string $name The name of the route.
     * @param array $params The route parameters.
     * @throws RouterException If no route matches the given name.
     * @return string The generated URL.
     */
    public function url($name, $params = [])
    {
        if (!isset($this->namedRoutes[$name])) {
            throw new RouterException('No route matches this name');
        }
        return $this->namedRoutes[$name]->getUrl($params);
    }
}