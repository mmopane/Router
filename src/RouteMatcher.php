<?php

namespace MMOPANE\Router;

use MMOPANE\Collection\Collection;
use MMOPANE\Router\Exception\MethodNotAllowedException;
use MMOPANE\Router\Exception\NotFoundException;

class RouteMatcher
{
    /**
     * @var Collection<string, Route>
     */
    protected Collection $routes;

    /**
     * @param Collection<string, Route> $routes
     */
    public function __construct(Collection $routes)
    {
        $this->routes = $routes;
    }

    /**
     * @param string $uri
     * @param string $method
     * @return RouteMatch
     */
    public function match(string $uri, string $method): RouteMatch
    {
        $routes = $this->routes->filter(fn (Route $route) => preg_match($route->getRegex(), $uri));

        if($routes->isEmpty())
            throw new NotFoundException();

        $routes = $this->routes->filter(fn (Route $route) => $route->hasMethods($method));

        if($routes->isEmpty())
            throw new MethodNotAllowedException();

        /** @var Route $route */
        $route = $routes->first();

        $uriSegments = explode('/', '/' . trim($uri, '/'));
        $pathSegments = explode('/', $route->getPath());
        $arguments = new Collection();

        foreach ($pathSegments as $index => $pathSegment)
        {
            if(preg_match('^\{[a-zA-Z_]+}$^', $pathSegment))
                $arguments->put(trim($pathSegment, '{}'), $uriSegments[$index]);
        }

        return new RouteMatch($route, $arguments);
    }
}