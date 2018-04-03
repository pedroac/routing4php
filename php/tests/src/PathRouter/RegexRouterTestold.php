<?php

namespace pedroac\routing\PathRouter;

use PHPUnit\Framework\TestCase;

class RegexRouterTest extends TestCase
{
    /**
     * @covers pedroac\routing\RegexRouterTest::match
     * @covers pedroac\routing\RegexRouterTest::__construct
     * @covers pedroac\routing\RegexRouterTest::map
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
     * @covers pedroac\routing\RegexRouterTest::match
    * @covers pedroac\routing\RegexRouterTest::__construct
     * @covers pedroac\routing\RegexRouterTest::map
     */
    public function testDynamicRoutesCallables()
    {
        $func1 = function () {};
        $func2 = function () {};
        $func3 = function () {};
        $router = new RegexRouter;
        $router->map('~^/aa/(?P<d>\d+)$~', $func1);
        $router->map('~^/aa/(?P<w>\w+)$~', $func2);
        $router->map('~^/aa/(?P<d>\d+)/(?P<w>\w+)$~', $func3);
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
    }

    /**
     * @covers pedroac\routing\RegexRouterTest::match
     * @covers pedroac\routing\RegexRouterTest::__construct
     * @covers pedroac\routing\RegexRouterTest::map
     */
    public function testDynamicRoutesVars()
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
}