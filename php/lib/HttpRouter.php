<?php

namespace pedroac\routing;
use Psr\Http\Message\ServerRequestInterface;

/**
 * HTTP request router.
 * 
 * TODO: the interface will be change in order to use PSR-7.
 * 
 * @author Pedro Amaral Couto
 * @license MIT
 */
class HttpRouter
{
    /**
     * The path router.
     *
     * @var CanRoutePath
     */
    private $pathRouter;
    /**
     * The HTTP methods routers associated with path patterns.
     * The associate arrays makes the mapping faster.
     *
     * @var HttpMethodsRouter[]
     */
    private $methodsRouters = array();

    /**
     * Create a HTTP request router.
     *
     * @param CanRoutePath $pathRouter
     */
    public function __construct(
        CanRoutePath $pathRouter
    ) {
        $this->pathRouter = $pathRouter;
    }

    /**
     * Return all the available HTTP methods for a specified path route.
     *
     * @param string $path The path route.
     * @return array A list of available HTTP method for a specified path route.
     */
    public function getPathOptions(string $path): array
    {
        $methodsRouter = ($this->pathRouter->match($path)->getCallable())[0];
        if (!$methodsRouter) {
            return array();
        }
        return $methodsRouter->getOptions();
    }

    /**
     * Attempt to match a HTTP request against mapped routes.
     *
     * @param ServerRequestInterface $request HTTP request.
     * @return RouteMatch
     */
    public function match(ServerRequestInterface $request): RouteMatch
    {
        $pathMatch = $this->pathRouter->match(
            $request->getUri()->getPath()
        );
        if (!$pathMatch->getCallable()) {
            return $pathMatch;
        }
        $methodsRouter = $pathMatch->getCallable()[0];
        return $methodsRouter->match(
            $request->getMethod(),
            $pathMatch->getVars()
        );
    }

    /**
     * Map a HTTP request with a callable.
     *
     * @param string $method
     * @param string $pattern
     * @param callable $callback
     * @return void
     */
    public function map(
        string $method,
        string $pattern,
        callable $callback
    ) {
        if (!isset($this->methodsRouters[$pattern])) {
            $this->methodsRouters[$pattern] = new HttpMethodsRouter;
            $this->pathRouter->map(
                $pattern,
                [$this->methodsRouters[$pattern], 'match']
            );
        }
        ($this->methodsRouters[$pattern])
            ->map($method, $callback);
    }
}