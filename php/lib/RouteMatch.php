<?php

namespace pedroac\routing;

/**
 * A route match response.
 * 
 * It should be immutable and have a callable (eg: a function) related
 * to an associative array, which should be used as the callable argument 
 * when it's called.
 * 
 * @see pedroac\routing\PathRouter
 * @author Pedro Amaral Couto
 * @license MIT
 */
class RouteMatch
{
    /**
     * Callable.
     *
     * @var callable|null
     */
    private $callable;
    /**
     * Associative array that should be passed to the callable.
     *
     * @var string[]|null
     */
    private $vars;

    /**
     * Create a route match response.
     *
     * @param callable $callable The associated callback.
     * @param array $vars The associative array that should be used as 
     * the callback argument.
     */
    public function __construct(callable $callable=null, array $vars=array())
    {
        $this->callable = $callable;
        $this->vars = $vars;
    }

    /**
     * Return the callback.
     *
     * @return callable|null
     */
    public function getCallable(): ?callable
    {
        return $this->callable;
    }

    /**
     * Return associative array that should be used as the callback argument.
     *
     * @return array|null
     */
    public function getVars(): ?array
    {
        return $this->vars;
    }

    /**
     * Return a value associated with a specified key from the associative array
     * that should be as the callback argument.
     *
     * @param string|int $name The key associated with the value that should be returned.
     * @return mixed
     */
    public function getVar($name)
    {
        return $this->vars[$name] ?? null;
    }

    /**
     * Call the callable with the associative array as the argument.
     *
     * @return void
     */
    public function __invoke()
    {
        if ($this->callable) {
            $callable = $this->callable;
            $callable($this->vars);
        }
    }
}