<?php

namespace MMOPANE\Router;

use MMOPANE\Collection\Collection;

class RouteMatch
{
    /**
     * @var Route
     */
    protected Route $route;

    /**
     * @var Collection<array-key, mixed>
     */
    protected Collection $arguments;

    /**
     * @param Route $route
     * @param Collection<array-key, mixed> $arguments
     */
    public function __construct(Route $route, Collection $arguments)
    {
        $this->route = $route;
        $this->arguments = $arguments;
    }

    /**
     * @return Route
     */
    public function getRoute(): Route
    {
        return $this->route;
    }

    /**
     * @return Collection<array-key, mixed>
     */
    public function getArguments(): Collection
    {
        return $this->arguments;
    }
}