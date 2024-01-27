<?php

namespace MMOPANE\Router;

class Router
{
    /**
     * @var RouteCollection
     */
    protected RouteCollection $routes;

    /**
     * @param RouteCollection $routes
     */
    public function __construct(RouteCollection $routes)
    {
        $this->routes = $routes;
    }

    /**
     * @param string $name
     * @param string $path
     * @param callable|array $handler
     * @return Route
     */
    public function add(string $name, string $path, callable|array $handler): Route
    {
        return $this->routes->add($name, new Route($name, $path, $handler));
    }

    /**
     * @param string $name
     * @param string $path
     * @param callable|array $handler
     * @return Route
     */
    public function get(string $name, string $path, callable|array $handler): Route
    {
        return $this->add($name, $path, $handler)->setMethods('GET');
    }

    /**
     * @param string $name
     * @param string $path
     * @param callable|array $handler
     * @return Route
     */
    public function post(string $name, string $path, callable|array $handler): Route
    {
        return $this->add($name, $path, $handler)->setMethods('POST');
    }

    /**
     * @return RouteCollection
     */
    public function getRoutes(): RouteCollection
    {
        return $this->routes;
    }
}