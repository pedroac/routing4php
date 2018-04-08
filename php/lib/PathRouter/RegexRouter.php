<?php
/**
 * @author Pedro Amaral Couto <pedro.amaral.couto@gmail.com>
 * @license MIT
 */

namespace pedroac\routing\PathRouter;
use \pedroac\routing\RouteMatch;
use \pedroac\routing\PathRouter\RegexRouter\RegexCallablePair;

/**
 * Path router using regex patterns.
 * 
 * @example "php/examples/regex-path-router.php"
 * 
 * @author Pedro Amaral Couto
 * @license MIT
 */
class RegexRouter implements \pedroac\routing\CanRoutePath
{
    /**
     * A list of regex and callable pairs.
     *
     * @var RegexCallablePair[]
     */
    private $regexCallablePairs = array();

    /**
     * Create a path router that uses regex patterns.
     */
    public function __construct()
    {
    }

    /**
     * {@inheritdoc}
     * 
     * The matched callable should be the first that was mapped with the
     * regex pattern that matches with the specified path.
     * @uses RegexCallablePair::match to evaluate and capture regex results.
     */
    public function match(string $path): RouteMatch
    {
        foreach ($this->regexCallablePairs as $pair) {
            if ($match = $pair->match($path)) {
                return $match;
            }
        }
        return new RouteMatch;
    }

    /**
     * {@inheritdoc}
     * 
     * The order of the mapped pairs might be important.
     * It's recommended that the regex pattern has a starting and ending 
     * line delimiters (eg: '/^path/(.+)$/').
     * 
     * @param string $regex Path regex pattern associated with the callback.
     */
    public function map(string $regex, callable $callback)
    {
        $this->regexCallablePairs[] = new RegexCallablePair($regex, $callback);
    }
}