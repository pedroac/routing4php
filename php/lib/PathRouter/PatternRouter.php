<?php

namespace pedroac\routing\PathRouter;
use \pedroac\routing\RouteMatch;

/**
 * Path router using custom path patterns.
 * 
 * The custom patterns are converted to regex patterns and the
 * PatternRouter path match function should behave like the
 * RegexRouter path match function.
 * 
 * @author Pedro Amaral Couto
 * @license MIT
 */
class PatternRouter implements \pedroac\routing\CanRoutePath
{
    /**
     * The collaborator that converts custom patterns to regex patterns.
     *
     * @var CanToRegex
     */
    private $translator;
    /**
     * The regex router.
     *
     * @var RegexRouter
     */
    private $regexRouter;

    /**
     * Create a path router using custom path patterns.
     *
     * @param CanToRegex $translator Custom pattern translator to regex. 
     */
    public function __construct(CanToRegex $translator)
    {
        $this->translator = $translator;
        $this->regexRouter = new RegexRouter;
    }

    /**
     * {@inheritdoc}
     */
    public function match(string $path): RouteMatch
    {
        return $this->regexRouter->match($path);
    }

    /**
     * {@inheritdoc}
     */
    public function map(string $pattern, callable $callable)
    {
        return $this->regexRouter->map(
            $this->translator->toRegex($pattern),
            $callable
        );
    }
}