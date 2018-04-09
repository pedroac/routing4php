<?php

use PHPUnit\Framework\TestCase;
use pedroac\routing\HttpMethodsRouter;

/**
 * HttpMethodsRouter class tests.
 * 
 * @author Pedro Amaral Couto
 * @license MIT
 */
class HttpMethodsRouterTest extends TestCase
{
    /**
     * @covers pedroac\routing\HttpMethodsRouter::map
     * @covers pedroac\routing\HttpMethodsRouter::match
     */
    public function testMatch()
    {
        $func1 = function() {
        };
        $func2 = function() {
        };
        $func3 = function() {
        };
        $router = new HttpMethodsRouter;
        $router->map('GET', $func1);
        $router->map('POST', $func2);
        $router->map('DELETE', $func3);
        $this->assertSame(
            $func1,
            $router->match('GET')->getCallable()
        );
        $this->assertSame(
            $func2,
            $router->match('POST')->getCallable()
        );
        $this->assertSame(
            $func3,
            $router->match('DELETE')->getCallable()
        );
    }

    /**
     * @covers pedroac\routing\HttpMethodsRouter::map
     * @covers pedroac\routing\HttpMethodsRouter::getOptions
     */
    public function testGetOptions()
    {
        $func1 = function() {
        };
        $router = new HttpMethodsRouter;
        $router->map('GET', $func1);
        $router->map('POST', $func1);
        $router->map('DELETE', $func1);
        $this->assertEquals(
            ['GET', 'POST', 'DELETE'],
            $router->getOptions()
        );
        $options = $router->getOptions();
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
     * @covers pedroac\routing\HttpMethodsRouter::map
     * @covers pedroac\routing\HttpMethodsRouter::match
     */
    public function testNoMatch()
    {
        $func1 = function() {
        };
        $router = new HttpMethodsRouter;
        $router->map('GET', $func1);
        $router->map('POST', $func1);
        $router->map('DELETE', $func1);
        $this->assertNull(
            $router->match('PUT')->getCallable()
        );
        $router->map('PUT', $func1);
        $this->assertSame(
            $func1,
            $router->match('PUT')->getCallable()
        );
    }
}