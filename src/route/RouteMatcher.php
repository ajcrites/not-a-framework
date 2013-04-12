<?php
namespace Naf\route;

/**
 * Matching rules used by the Router to determine route validity
 */
class RouteMatcher
{
    public function __call($method, $_)
    {
        throw new RouterException("Undefined match rule $method called");
    }

    public function is($test, $required)
    {
        return $test === $required;
    }

    public function regex($test, $regex)
    {
        return preg_match($regex, $test);
    }

    public function any($test, $anyof) {
        return in_array($test, $anyof, true);
    }

    public function int($test) {
        return ctype_digit($test);
    }
}
?>
