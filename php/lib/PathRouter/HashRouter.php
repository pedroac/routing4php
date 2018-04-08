<?php

namespace pedroac\routing\PathRouter;
use \pedroac\routing\RouteMatch;

/**
 * Path router with an hash table.
 * 
 * Instead of transversing a list, an associative array
 * is used to find a match from a key (the path).
 * 
 * @example "php/examples/hash-path-router.php"
 * 
 * @author Pedro Amaral Couto
 * @license MIT
 */
class HashRouter implements \pedroac\routing\CanRoutePath
{
    /**
     * Callables (the values) associated with paths (the keys).
     *
     * @var callable[]
     */
    private $pathsCallablesMap = array();

    /**
     * {@inheritdoc}
     */
    public function match(string $path): RouteMatch
    {
        if (!isset($this->pathsCallablesMap[$path])) {
            return new RouteMatch;
        }
        return new RouteMatch($this->pathsCallablesMap[$path]);
    }

    /**
     * {@inheritdoc}
     * 
     * @param string $path The path that should be associated with the callable.
     */
    public function map(string $path, callable $callable)
    {
        $this->pathsCallablesMap[$path] = $callable;
    }
}