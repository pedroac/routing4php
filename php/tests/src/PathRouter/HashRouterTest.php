<?php

namespace pedroac\routing\PathRouter;
use PHPUnit\Framework\TestCase;

/**
 * HashRouter class tests.
 * 
 * @author Pedro Amaral Couto
 * @license MIT
 */
class HashRouterTest extends TestCase
{
    /**
     * @cover pedroac\routing\HashRouter::match
     * @cover pedroac\routing\HashRouter::__construct
     * @cover pedroac\routing\HashRouter::map
     */
    public function testRoutes()
    {
        $func1 = function () {};
        $func2 = function () {};
        $func3 = function () {};
        $router = new HashRouter;
        $router->map('/aa/ba', $func1);
        $router->map('/aa/bb', $func2);
        $router->map('/aa/bc', $func3);
        $this->assertSame(
            $func1,
            $router->match('/aa/ba')->getCallable()
        );
        $this->assertSame(
            $func2,
            $router->match('/aa/bb')->getCallable()
        );
        $this->assertSame(
            $func3,
            $router->match('/aa/bc')->getCallable()
        );
        $this->assertSame(
            null,
            $router->match('/aa/bcc')->getCallable()
        );
    }
}