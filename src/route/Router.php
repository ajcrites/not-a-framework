<?php

/**
 * Router class that provides the
 * appropriate route based on the provided path and route definitions
 * @package naf
 */

namespace Naf\route;

/**
 * Router class
 * Generally used to set appropriate parameters based on user agent requested path
 */
class Router
{
    /**
     * @var RouteMatcher
     */
    private $matcher;

    /**
     * @var array available routes
     */
    private $routes;

    /**
     * Create a Router with the provided available route definitions
     */
    public function __construct(RouteMatcher $matcher, $routes)
    {
        $this->routes = $routes;
    }

    /**
     * Create array representing the path from user agent requested (usually) path
     * Pieces are separated by slashes and empty paths are thrown out
     */
    public function cleanPath($path)
    {
        //array_values re-orders pieces from zero
        return array_values(array_filter(explode('/', $path)));
    }

    /**
     * Route the provided request based on its path
     */
    public function route(\Naf\http\Request $request)
    {
        $path = $this->cleanPath($request->PATH);

        //Use default route when empty path requested
        if (empty($path)) {
            foreach ($this->routes['default'] as $name => $value) {
                $request->$name = $value;
            }
            return $request;
        }

        foreach ($this->routes as $definition => $values) {
            if ($parameters = $this->found($path, $definition, $values)) {
                foreach ($parameters as $name => $value) {
                    $request->$name = $value;
                }
                return $request;
            }
        }

        //Use 404 route when no available route is found based on the path
        foreach ($this->routes['404'] as $name => $value) {
            $request->$name = $value;
        }
        return $request;
    }

    /**
     * Determine whether a matching route for the provided path has been found
     */
    public function found($path, $definitionString, $values)
    {
        $parameters = array();
        $definition = $this->cleanPath($definitionString);

        //requested path is shorter than definition
        //Values starting with : are optional
        if (count(array_filter($definition, function ($val) { return strpos($val, ':') !== 0; })) > count($path)) {
            return false;
        }

        foreach ($path as $piece) {
            //path is longer than definition; route cannot match
            $name = array_shift($definition);
            if (!$name) {
                return false;
            }

            //parameter must pass matching test
            if (isset($values['match'][$name])) {
                //Special handling for the `is` rule since it is so common
                //and an additional parameter often not needed
                if (!is_array($values['match'][$name])) {
                    if (!$this->$matcher->is($piece, $name)) {
                        return false;
                    }
                }
                else {
                    foreach ($values['match'][$name] as $rule => $param) {
                        if (!$this->matcher->$rule($piece, $param)) {
                            return false;
                        }
                    }
                }
            }
            $parameters[ltrim($name, ':')] = $piece;
        }

        //Request will be created from default parameters overwritten by path-provided ones
        return array_merge(array('route' => $definitionString), $values['default'], $parameters);
    }
}
?>
