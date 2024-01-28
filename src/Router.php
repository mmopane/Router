<?php

namespace MMOPANE\Router;

use MMOPANE\Collection\Collection;

class Router
{
    /**
     * @var Collection<string, Route>
     */
    protected Collection $routes;

    /**
     * @param Collection|null $routes
     */
    public function __construct(Collection $routes = null)
    {
        $this->routes = $routes ?? new Collection();
    }

    /**
     * @param string $name
     * @param string $path
     * @param callable|array $handler
     * @return Route
     */
    public function add(string $name, string $path, callable|array $handler): Route
    {
        $route = new Route($name, $path, $handler);
        $this->routes->put($name, $route);
        return $route;
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
     * @return Collection<string, Route>
     */
    public function getRoutes(): Collection
    {
        return $this->routes;
    }
}