<?php

namespace pedroac\routing;

/**
 * The interface for path routers.
 * 
 * @author Pedro Amaral Couto <pedro.amaral.couto@gmail.com>
 * @license MIT
 */
interface CanRoutePath
{
    /**
     * Attempt to match a specified route path against mapped routes.
     * 
     * If a match was found, it should be returned a  Match with a 
     * callable mapped to the pattern that matches the specified path.
     * Otherwise, it should be returned a Match response with empty properties.
     * It should only find matches if path patterns and callables were
     * mapped previously.
     *
     * @param string $path Route path that should be matched.
     * @return RouteMatch Route match response.
     */
    public function match(string $path): RouteMatch;

    /**
     * Map a path pattern with a callable (eg: a function).
     * 
     * This should be used to find the callable and, if appropriate, 
     * an associative array that match a specified path.
     *
     * @param string $pattern The path pattern.
     * @param callable $callable The callable.
     * @return void
     */
    public function map(string $pattern, callable $callable);
}