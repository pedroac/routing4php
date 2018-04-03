<?php

use PHPUnit\Framework\TestCase;
use pedroac\routing\RouteMatch;

/**
 * RouteMatch class tests.
 * 
 * @author Pedro Amaral Couto
 * @license MIT
 */
class RouteMatchTest extends TestCase
{
    /**
     * @cover pedroac\routing\RouteMatch::getCallable
     * @cover pedroac\routing\RouteMatch::__construct
     */
    public function testCallable()
    {
        $func1 = function() {
        };
        $func2 = function() {
        };
        $this->assertSame(
            $func1,
            (new RouteMatch($func1))->getCallable()
        );
        $this->assertFalse(
            (new RouteMatch($func1))->getCallable() == $func2
        );
    }

    /**
     * @cover pedroac\routing\RouteMatch::getVars
     * @cover pedroac\routing\RouteMatch::__construct
     */
    public function testVars()
    {
        $func = function() {
        };
        $vars1 = array(
            'k-a' => 'v-a',
            'k-b' => 'v-b',
        );
        $vars2 = array(
            'k-c' => 'v-c',
            'k-d' => 'v-d',
        );
        $this->assertEquals(
            $vars1,
            (new RouteMatch($func, $vars1))->getVars()
        );
        $this->assertFalse(
            (new RouteMatch($func, $vars1))->getVars() == $vars2
        );
    }

    /**
     * @cover pedroac\routing\RouteMatch::getVar
     * @cover pedroac\routing\RouteMatch::__construct
     */
    public function testVar()
    {
        $func = function() {
        };
        $vars = array(
            'k-a' => 'v-a',
            'k-b' => 'v-b',
        );
        $this->assertSame(
            'v-a',
            (new RouteMatch($func, $vars))->getVar('k-a')
        );
        $this->assertFalse(
            (new RouteMatch($func, $vars))->getVar('k-a') === 'v-b'
        );
    }

    /**
     * @cover pedroac\routing\RouteMatch::__invoke
     * @cover pedroac\routing\RouteMatch::__construct
     */
    public function testInvoke()
    {
        $vars = array(
            'k-a' => 'v-a',
            'k-b' => 'v-b',
        );
        $match1 = new RouteMatch([$this, 'setVar1']);
        $match2 = new RouteMatch([$this, 'setVar2'], $vars);
        $match1();
        $match2();
        $this->assertSame(array(), $this->var1);
        $this->assertSame($vars, $this->var2);
    }

    private $var1;
    private $var2;
    public function setVar1($var)
    {
        $this->var1 = $var;
    }
    public function setVar2($var)
    {
        $this->var2 = $var;
    }
}