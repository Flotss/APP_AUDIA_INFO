<?php

namespace App\Router;

class Route
{

    private $path;
    private $callable;
    private $matches = [];
    private $params = [];

    /**
     * Route constructor.
     *
     * @param string $path The route path
     * @param mixed $callable The callable to be executed when the route is matched
     */
    public function __construct($path, $callable)
    {
        $this->path = trim($path, '/'); // On retire les / inutils
        $this->callable = $callable;
    }

    /**
     * Matches the given URL against the route path and captures the parameters.
     *
     * @param string $url The URL to match against
     * @return bool True if the URL matches the route, false otherwise
     */
    public function match($url)
    {
        $url = trim($url, '/');
        $path = preg_replace('#:([\w]+)#', '([^/]+)', $this->path);
        $regex = "#^$path$#i";
        if (!preg_match($regex, $url, $matches)) {
            return false;
        }
        array_shift($matches);
        $this->matches = $matches; // Save the parameters for later use
        return true;
    }

    /**
     * Calls the callable associated with the route.
     *
     * @return mixed The result of the callable
     */
    public function call()
    {
        if (is_string($this->callable)) {
            $params = explode('#', $this->callable);
            $controller = "App\\Controller\\" . $params[0] . "Controller";
            $controller = new $controller();
            return call_user_func_array([$controller, $params[1]], $this->matches);
        } else {
            return call_user_func_array($this->callable, $this->matches);
        }
    }
}