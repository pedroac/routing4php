<?php

use PHPUnit\Framework\TestCase;
use pedroac\routing\PathRouter\PatternRouter;
use pedroac\routing\PathRouter\CanToRegex;

/**
 * PatternRouter class tests.
 * 
 * @author Pedro Amaral Couto
 * @license MIT
 */
class PatternRouterTest extends TestCase
{
    /**
     * @covers pedroac\routing\PathRouter\PatternRouter::__construct
     * @covers pedroac\routing\PathRouter\PatternRouter::map
     * @covers pedroac\routing\PathRouter\PatternRouter::match
     */
    public function testMatch()
    {
        $func1 = function() {
        };
        $func2 = function() {
        };
        $func3 = function() {
        };
        $router = new PatternRouter(new NaiveToRegexTranslator);
        $router->map('users', $func1);
        $router->map('users/<user_id>', $func2);
        $router->map('users/<user_id>/photos/<photo_id>', $func3);
        $this->assertSame(
            $func1,
            $router->match('users')->getCallable()
        );
        $this->assertSame(
            $func2,
            $router->match('users/pedroac')->getCallable()
        );
        $this->assertSame(
            $func3,
            $router->match('users/pedroac/photos/123')->getCallable()
        );
    }
}

class NaiveToRegexTranslator implements CanToRegex
{
    public function toRegex(string $pattern): string
    {
        return 
            '~^'
            . str_replace(
                ['<', '>',],
                ['(?P<', '>[^/]*)',],
                $pattern
            )
            . '$~';
    }
}