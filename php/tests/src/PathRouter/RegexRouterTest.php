<?php

namespace pedroac\routing\PathRouter;
use pedroac\routing\PathRouter\RegexRouter\RegexException;
use PHPUnit\Framework\TestCase;

/**
 * RegexRouter class tests.
 * 
 * @author Pedro Amaral Couto
 * @license MIT
 */
class RegexRouterTest extends TestCase
{
    /**
     * @covers pedroac\routing\PathRouter\RegexRouter::match
     * @covers pedroac\routing\PathRouter\RegexRouter::__construct
     * @covers pedroac\routing\PathRouter\RegexRouter::map
     * @covers pedroac\routing\PathRouter\RegexRouter\RegexCallablePair::__construct
     * @covers pedroac\routing\PathRouter\RegexRouter\RegexCallablePair::match
     */
    public function testStaticRoutes()
    {
        $func1 = function () {};
        $func2 = function () {};
        $func3 = function () {};
        $router = new RegexRouter;
        $router->map('~/aa/ba~', $func1);
        $router->map('~/aa/bb~', $func2);
        $router->map('~/aa/bc~', $func3);
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
    }

    /**
     * @covers pedroac\routing\PathRouter\RegexRouter::match
     * @covers pedroac\routing\PathRouter\RegexRouter::__construct
     * @covers pedroac\routing\PathRouter\RegexRouter::map
     * @covers pedroac\routing\PathRouter\RegexRouter\RegexCallablePair::__construct
     * @covers pedroac\routing\PathRouter\RegexRouter\RegexCallablePair::match 
     */
    public function testNamesDynamicRoutesCallables()
    {
        $func1 = function () {};
        $func2 = function () {};
        $func3 = function () {};
        $func4 = function () {};
        $router = new RegexRouter;
        $router->map('~^/aa/(?P<d>\d+)$~', $func1);
        $router->map('~^/aa/(?P<w>\w+)$~', $func2);
        $router->map('~^/aa/(?P<d>\d+)/(?P<w>t\w*)$~', $func3);
        $router->map('~^/aa/(?P<d>\d+)/(?P<w>[^/]*)$~', $func4);
        $this->assertSame(
            $func1,
            $router->match('/aa/123')->getCallable()
        );
        $this->assertSame(
            $func2,
            $router->match('/aa/test')->getCallable()
        );
        $this->assertSame(
            $func3,
            $router->match('/aa/123/test')->getCallable()
        );
        $this->assertSame(
            $func4,
            $router->match('/aa/123/')->getCallable()
        );
        $this->assertSame(
            $func4,
            $router->match('/aa/123/r34')->getCallable()
        );
    }

    /**
     * @covers pedroac\routing\PathRouter\RegexRouter::match
     * @covers pedroac\routing\PathRouter\RegexRouter::__construct
     * @covers pedroac\routing\PathRouter\RegexRouter::map
     * @covers pedroac\routing\PathRouter\RegexRouter\RegexCallablePair::__construct
     * @covers pedroac\routing\PathRouter\RegexRouter\RegexCallablePair::match 
     */
    public function testIndexesDynamicRoutesIndexedVars()
    {
        $func1 = function () {};
        $func2 = function () {};
        $router = new RegexRouter;
        $router->map('~^/aa/(\d+)$~', $func1);
        $router->map('~^/aa/(\d+)/(?P<w>\w+)$~', $func2);
        $this->assertEquals(
            123,
            $router->match('/aa/123')->getVar(0)
        );
        $this->assertEquals(
            123,
            $router->match('/aa/123/test')->getVar(0)
        );
        $this->assertEquals(
            'test',
            $router->match('/aa/123/test')->getVar(1)
        );
    }

    /**
     * @covers pedroac\routing\PathRouter\RegexRouter::match
     * @covers pedroac\routing\PathRouter\RegexRouter::__construct
     * @covers pedroac\routing\PathRouter\RegexRouter::map
     * @covers pedroac\routing\PathRouter\RegexRouter\RegexCallablePair::__construct
     * @covers pedroac\routing\PathRouter\RegexRouter\RegexCallablePair::match
     */
    public function testDynamicRoutesNamedVars()
    {
        $func1 = function () {};
        $func2 = function () {};
        $func3 = function () {};
        $router = new RegexRouter;
        $router->map('~^/aa/(?P<a>\d+)$~', $func1);
        $router->map('~^/aa/(?P<b>\w+)$~', $func2);
        $router->map('~^/aa/(?P<d>\d+)/(?P<w>\w+)$~', $func3);
        $this->assertEquals(
            123,
            $router->match('/aa/123')->getVar('a')
        );
        $this->assertEquals(
            'test',
            $router->match('/aa/test')->getVar('b')
        );
        $this->assertArraySubset(
            [
                'd' => 123,
                'w' => 'test'
            ],
            $router->match('/aa/123/test')->getVars()
        );
    }

    /**
     * @covers pedroac\routing\PathRouter\RegexRouter::match
     * @covers pedroac\routing\PathRouter\RegexRouter::__construct
     * @covers pedroac\routing\PathRouter\RegexRouter::map
     * @covers pedroac\routing\PathRouter\RegexRouter\RegexCallablePair::__construct
     * @covers pedroac\routing\PathRouter\RegexRouter\RegexCallablePair::match
     */
    public function testNoMatch()
    {
        $func1 = function () {};
        $func2 = function () {};
        $router = new RegexRouter;
        $router->map('~/aa/ba~', $func1);
        $router->map('~^/aa/([\w]*)$~', $func2);
        $this->assertSame(
            null,
            $router->match('/ba/aa')->getCallable()
        );
        $this->assertSame(
            null,
            $router->match('/aa/cc/dd')->getCallable()
        );
        $this->assertSame(
            array(),
            $router->match('/aa/cc/dd')->getVars()
        );
    }

    /**
     * @covers pedroac\routing\PathRouter\RegexRouter::match
     * @covers pedroac\routing\PathRouter\RegexRouter::__construct
     * @covers pedroac\routing\PathRouter\RegexRouter::map
     * @covers pedroac\routing\PathRouter\RegexRouter\RegexCallablePair::__construct
     * @covers pedroac\routing\PathRouter\RegexRouter\RegexCallablePair::match
     */
    public function testException()
    {
        $func = function () {};
        $router = new RegexRouter;
        $router->map('~/aa/ba((~', $func);

        $this->expectException(RegexException::class);
        $router->match('/aa/ba((');
    }
}