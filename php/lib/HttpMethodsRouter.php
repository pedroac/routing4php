<?php

namespace pedroac\routing;

/**
 * HTTP methods router.
 * 
 * @author Pedro Amaral Couto
 * @license MIT
 */
class HttpMethodsRouter
{
    /**
     * Callables (values) associated with methods names (keys).
     *
     * @var callable[]
     */
    private $map = array();

    /**
     * Get available HTTP methods that can be matched.
     *
     * @return array
     */
    public function getOptions(): array
    {
        return array_keys($this->map);
    }

    /**
     * Attempt to match a specified HTTP route against mapped routes.
     *
     * If a match was found, it should be returned a  RouteMatch with a 
     * callable mapped to the pattern that matches the specified method.
     * Otherwise, it should be returned a RouteMatch response with empty properties.
     * It should only find matches if HTTP methods and callables were
     * mapped previously.
     * 
     * @param string $method HTTP method.
     * @param array $vars An associative array that should be as the parameter
     *                    for the RouteMatch callable.
     * @return RouteMatch The match response.
     */
    public function match(string $method, array $vars=array()): RouteMatch
    {
        if (!isset($this->map[$method])) {
            return new RouteMatch;
        }
        return new RouteMatch(
            $this->map[strtoupper($method)],
            $vars
        );
    }

    /**
     * Map a HTTP method with a callable.
     *
     * @param string $method HTTP method.
     * @param callable $callable The callable.
     * @return void
     */
    public function map(string $method, callable $callable)
    {
        $this->map[strtoupper($method)] = $callable;
    }
}