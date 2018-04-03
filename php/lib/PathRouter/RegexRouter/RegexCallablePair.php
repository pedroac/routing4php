<?php

namespace pedroac\routing\PathRouter\RegexRouter;
use \pedroac\routing\RouteMatch;

/**
 * Callable and path regex pattern pair.
 * 
 * The callable and pattern are associated with each other.
 * 
 * @author Pedro Amaral Couto
 * @license MIT
 */
class RegexCallablePair
{
    /**
     * Path regex pattern associated with the callable.
     *
     * @var string
     */
    private $regex;
    /**
     * Callable associated with the path regex pattern.
     *
     * @var callable
     */
    private $callable;

    /**
     * Create a callable and path regex pattern pair.
     *
     * @param string $regex The regex pattern.
     * @param callable $callable The callable,
     */
    public function __construct(string $regex, callable $callable)
    {
        $this->regex = $regex;
        $this->callable = $callable;
    }


    /**
     * Check if the regex pattern and a specified path match:
     * if they do, return the route match response with the callable 
     * and the results captured (the associative array that should be
     * used as the callable argument). 
     * @uses \preg_match To evaluated the regex pattern.
     * 
     * @throws RegexException
     * @param string $path The path that should be evaluated.
     * @return RouteMatch|null The match response with the callable
     *  and matched patterns, or NULL if it was not a match.
     */
    public function match(string $path): ?RouteMatch
    {
        $regexMatches = array();
        try {
            if (preg_match($this->regex, $path, $regexMatches)) {
                return new RouteMatch(
                    $this->callable,
                    array_slice($regexMatches, 1)
                );
            }
            return null;
        } catch (\Throwable $throwable) {
            throw new RegexException(
                $throwable->getMessage(),
                $throwable->getCode(),
                $throwable->getPrevious()
            );
        }
    }
}