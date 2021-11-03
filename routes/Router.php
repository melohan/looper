<?php

namespace Router;

use Exception;

class Router
{

    public $url;
    public $routes = [];

    /**
     * Constructor
     * @param $url
     */
    public function __construct($url)
    {
        $this->url = trim($url, '/');
    }

    /**
     * Instancie route
     * @param string $path
     * @param string $action
     */
      public function get(string $path, string $action)
    {
        $this->routes['GET'][] = new Route($path, $action);
    }

    /**
     * Instancie route
     * @param string $path
     * @param string $action
     */
    public function post(string $path, string $action)
    {
        $this->routes['POST'][] = new Route($path, $action);
    }

    /**
     * Browse the different routes previously registered and check if the route corresponds to the URL passed to the constructor
     * @return mixed
     * @throws Exception
     */
    public function run()
    {
        foreach ($this->routes[$_SERVER['REQUEST_METHOD']] as $route) {
            if ($route->matches($this->url)) {
                return $route->execute();
            }
        }

        throw new Exception("Page not found");
    }
}
