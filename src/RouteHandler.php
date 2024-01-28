<?php

namespace MMOPANE\Router;

use MMOPANE\Collection\Collection;
use MMOPANE\Router\Exception\ClassNotFoundException;
use MMOPANE\Router\Exception\HandlerNotValidException;
use MMOPANE\Router\Exception\MethodNotFoundException;

class RouteHandler
{
    /**
     * @var mixed|array|callable
     */
    protected mixed $handler;

    /**
     * @var Collection<array-key, mixed>
     */
    protected Collection $constructorParams;

    /**
     * @var Collection<array-key, mixed>
     */
    protected Collection $methodParams;

    /**
     * @param callable|array $handler
     */
    public function __construct(callable|array $handler)
    {
        $this->handler = $handler;
        $this->constructorParams = new Collection();
        $this->methodParams = new Collection();
    }

    /**
     * @param mixed $parameter
     * @return $this
     */
    public function addConstructorParam(mixed $parameter): self
    {
        $this->constructorParams->add($parameter);
        return $this;
    }

    /**
     * @param mixed $parameter
     * @return $this
     */
    public function addMethodParam(mixed ...$parameter): self
    {
        $this->methodParams->add($parameter);
        return $this;
    }

    /**
     * @return mixed
     */
    public function execute(): mixed
    {
        if(is_callable($this->handler))
            return call_user_func($this->handler, ...$this->methodParams->all());

        if(!is_array($this->handler))
            throw new HandlerNotValidException();
        if(!class_exists($this->handler[0]))
            throw new ClassNotFoundException();
        if(!method_exists($this->handler[0], $this->handler[1]))
            throw new MethodNotFoundException();

        return (new $this->handler[0](...$this->constructorParams->all()))->{$this->handler[1]}(...$this->methodParams->all());
    }
}