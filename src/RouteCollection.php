<?php

namespace MMOPANE\Router;

class RouteCollection
{
    /**
     * @var array<string, Route>
     */
    protected array $routes = [];

    /**
     * @param string $name
     * @param Route $route
     * @return Route
     */
    public function add(string $name, Route $route): Route
    {
        return $this->routes[$name] = $route;
    }

    /**
     * @param string $name
     * @return Route|null
     */
    public function get(string $name): Route|null
    {
        return $this->routes[$name] ?? null;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function has(string $name): bool
    {
        return array_key_exists($name, $this->routes);
    }

    /**
     * @param string $uri
     * @return Route|null
     */
    public function findByURI(string $uri): Route|null
    {
        foreach ($this->routes as $route)
        {
            if(preg_match($route->getRegex(), '/' . mb_strtolower(trim($uri, '/'))))
                return $route;
        }
        return null;
    }
}