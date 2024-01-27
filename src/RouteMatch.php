<?php

namespace MMOPANE\Router;

class RouteMatch
{
    /**
     * @var Route
     */
    protected Route $route;

    /**
     * @var array
     */
    protected array $arguments;

    /**
     * @param Route $route
     * @param array $arguments
     */
    public function __construct(Route $route, array $arguments = [])
    {
        $this->route        = $route;
        $this->arguments    = $arguments;
    }

    /**
     * @return Route
     */
    public function getRoute(): Route
    {
        return $this->route;
    }

    /**
     * @return array
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }
}