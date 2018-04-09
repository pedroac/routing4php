<?php

use PHPUnit\Framework\TestCase;
use pedroac\routing\HttpRouter;
use pedroac\routing\MethodsRouter;
use pedroac\routing\PathRouter\HashRouter;

/**
 * HttpRouter class tests.
 * 
 * @author Pedro Amaral Couto
 * @license MIT
 */
class HttpRouterTest extends TestCase
{
    /**
     * @covers pedroac\routing\HttpRouter::__construct
     * @covers pedroac\routing\HttpRouter::map
     * @covers pedroac\routing\HttpRouter::match
     */
    public function testMatch()
    {
        $func1 = function() {
        };
        $func2 = function() {
        };
        $func3 = function() {
        };
        $router = new HttpRouter(
            new HashRouter
        );
        $router->map('GET', 'home', $func1);
        $router->map('GET', 'home/about', $func2);
        $router->map('GET', 'home/sitemap', $func3);
        $this->assertSame(
            $func1,
            $router->match('GET', 'home')->getCallable()
        );
        $this->assertSame(
            $func2,
            $router->match('GET', 'home/about')->getCallable()
        );
        $this->assertSame(
            $func3,
            $router->match('GET', 'home/sitemap')->getCallable()
        );
    }

    /**
     * @covers pedroac\routing\HttpRouter::__construct
     * @covers pedroac\routing\HttpRouter::map
     * @covers pedroac\routing\HttpRouter::match
     */
    public function testMatchMethod()
    {
        $func1 = function() {
        };
        $func2 = function() {
        };
        $func3 = function() {
        };
        $router = new HttpRouter(
            new HashRouter
        );
        $router->map('GET', 'home', $func1);
        $router->map('POST', 'home', $func2);
        $router->map('DELETE', 'home', $func3);
        $this->assertSame(
            $func1,
            $router->match('GET', 'home')->getCallable()
        );
        $this->assertSame(
            $func2,
            $router->match('POST', 'home')->getCallable()
        );
        $this->assertSame(
            $func3,
            $router->match('DELETE', 'home')->getCallable()
        );
    }

    /**
     * @covers pedroac\routing\HttpRouter::__construct
     * @covers pedroac\routing\HttpRouter::map
     * @covers pedroac\routing\HttpRouter::getPathOptions
     */
    public function testGetPathOptions()
    {
        $func1 = function() {
        };
        $router = new HttpRouter(
            new HashRouter
        );
        $router->map('GET', 'home', $func1);
        $router->map('POST', 'home', $func1);
        $router->map('DELETE', 'home', $func1);
        $router->map('GET', 'home/about', $func1);
        $options = $router->getPathOptions('home');
        sort($options);
        $this->assertEquals(
            ['DELETE', 'GET', 'POST'],
            $options
        );
        $this->assertEquals(
            array('PUT'),
            array_diff(
                ['PUT', 'GET', 'POST', 'DELETE'],
                $options
            )
        );
    }

    /**
     * @covers pedroac\routing\HttpRouter::__construct
     * @covers pedroac\routing\HttpRouter::map
     * @covers pedroac\routing\HttpRouter::getPathOptions
     */
    public function testGetNoPathOptions()
    {
        $func1 = function() {
        };
        $router = new HttpRouter(
            new HashRouter
        );
        $router->map('GET', 'home', $func1);
        $router->map('POST', 'home', $func1);
        $router->map('DELETE', 'home', $func1);
        $options = $router->getPathOptions('home/about');
        $this->assertEquals(
            array(),
            $options
        );
    }
}