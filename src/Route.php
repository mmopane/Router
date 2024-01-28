<?php

namespace MMOPANE\Router;

use MMOPANE\Collection\Collection;

class Route
{
    /**
     * @var string
     */
    protected string $name;

    /**
     * @var string
     */
    protected string $path;

    /**
     * @var Collection<array-key, string>
     */
    protected Collection $methods;

    /**
     * @var RouteHandler
     */
    protected RouteHandler $handler;

    /**
     * @var Collection<array-key, RouteHandler>
     */
    protected Collection $middlewares;

    /**
     * @var string
     */
    protected string $regex;

    /**
     * @param string $name
     * @param string $path
     * @param array|callable $handler
     */
    public function __construct(string $name, string $path, array|callable $handler)
    {
        $this->setName($name);
        $this->setPath($path);
        $this->setHandler($handler);
        $this->methods = new Collection();
        $this->middlewares = new Collection();
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = mb_strtolower($name);
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $path
     * @return $this
     */
    public function setPath(string $path): self
    {
        $this->path = '/' . mb_strtolower(trim($path, '/'));
        $segments = [];
        foreach (explode('/', $this->path) as $segment)
        {
            if(preg_match('^\{[a-zA-Z_]+}$^', $segment))
                $segments[] = '[A-Za-z0-9_\-.!()*;:,\=%]+';
            else
                $segments[] = $segment;
        }
        $this->regex = '/^' . implode('\/', $segments) . '$/';
        return $this;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string ...$methods
     * @return $this
     */
    public function setMethods(string ...$methods): self
    {
        $this->methods = new Collection(array_map('mb_strtoupper', $methods));
        return $this;
    }

    /**
     * @return Collection<array-key, string>
     */
    public function getMethods(): Collection
    {
        return $this->methods;
    }

    /**
     * @param string ...$methods
     * @return bool
     */
    public function hasMethods(string ...$methods): bool
    {
        return $this->methods->in(...array_map('mb_strtoupper', $methods));
    }

    /**
     * @param array|callable $handler
     * @return $this
     */
    public function setHandler(array|callable $handler): self
    {
        $this->handler = new RouteHandler($handler);
        return $this;
    }

    /**
     * @return RouteHandler
     */
    public function getHandler(): RouteHandler
    {
        return $this->handler;
    }

    /**
     * @param array|callable $handler
     * @return $this
     */
    public function addMiddleware(array|callable $handler): self
    {
        $this->middlewares->add(new RouteHandler($handler));
        return $this;
    }

    /**
     * @return Collection<array-key, RouteHandler>
     */
    public function getMiddlewares(): Collection
    {
        return $this->middlewares;
    }

    /**
     * @return string
     */
    public function getRegex(): string
    {
        return $this->regex;
    }

    /**
     * @param array $arguments
     * @return string
     */
    public function compileURI(array $arguments = []): string
    {
        $segments = [];
        foreach (explode('/', $this->path) as $segment)
        {
            if(preg_match('^\{[a-zA-Z_]+}$^', $segment))
            {
                $argumentName = trim($segment, '{}');
                if(array_key_exists($argumentName, $arguments))
                    $segments[] = $arguments[$argumentName];
                else
                    $segments[] = $segment;
            }
            else
            {
                $segments[] = $segment;
            }
        }
        return implode('/', $segments);
    }

}