<?php

namespace MMOPANE\Router;

class RouteHandler
{
    /**
     * @var mixed|array|callable
     */
    protected mixed $handler;

    /**
     * @var array
     */
    protected array $constructorParams = [];

    /**
     * @var array
     */
    protected array $methodParams  = [];

    /**
     * @param callable|array $handler
     */
    public function __construct(callable|array $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @param mixed ...$parameters
     * @return $this
     */
    public function setConstructorParams(mixed ...$parameters): self
    {
        $this->constructorParams = $parameters;
        return $this;
    }

    /**
     * @param mixed ...$parameters
     * @return $this
     */
    public function setMethodParams(mixed ...$parameters): self
    {
        $this->methodParams = $parameters;
        return $this;
    }

    /**
     * @return mixed
     */
    public function execute(): mixed
    {
        if(is_callable($this->handler))
            return call_user_func($this->handler, ...$this->methodParams);

        if(!is_array($this->handler))
            throw new \RuntimeException('Handler is not valid');
        if(!class_exists($this->handler[0]))
            throw new \RuntimeException('Class not found');
        if(!method_exists($this->handler[0], $this->handler[1]))
            throw new \RuntimeException('Method not found');

        return (new $this->handler[0](...$this->constructorParams))->{$this->handler[1]}(...$this->methodParams);
    }
}