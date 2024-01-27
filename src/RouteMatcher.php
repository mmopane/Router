<?php

namespace MMOPANE\Router;

use MMOPANE\Router\Exception\MethodNotAllowedException;
use MMOPANE\Router\Exception\NotFoundException;

class RouteMatcher
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
     * @param string $uri
     * @param string $method
     * @return RouteMatch
     */
    public function match(string $uri, string $method): RouteMatch
    {
        $route = $this->routes->findByURI($uri);

        if(is_null($route))
            throw new NotFoundException();

        if(!$route->hasMethods($method))
            throw new MethodNotAllowedException();

        $uriSegments = explode('/', '/' . trim($uri, '/'));
        $pathSegments = explode('/', $route->getPath());
        $arguments = [];

        foreach ($pathSegments as $index => $pathSegment)
        {
            if(preg_match('^\{[a-zA-Z_]+}$^', $pathSegment))
                $arguments[trim($pathSegment, '{}')] = $uriSegments[$index];
        }

        return new RouteMatch($route, $arguments);
    }
}