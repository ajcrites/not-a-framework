<?php
/**
 * Tests for individual Router methods
 * route\Router is the default NaF router
 */
class RouterTest extends Naf_TestCase
{
    /**
     * Test that cleanPath correctly ignore leading and trailing slashes
     * as well as duplicate slashes
     */
    public function testCleanPath()
    {
        $router = new Naf\route\Router(new Naf\route\RouteMatcher, array());
        $this->assertEquals($router->cleanPath("/one/two/three"), array("one","two","three"));
        $this->assertEquals($router->cleanPath("one/two/three"), array("one","two","three"));
        $this->assertEquals($router->cleanPath("one/two/three/"), array("one","two","three"));
        $this->assertEquals($router->cleanPath("one//two//three/"), array("one","two","three"));
        $this->assertEquals($router->cleanPath("one/0/three/"), array("one","0","three"));
    }

    public function testFound()
    {
        $router = new Naf\route\Router(new Naf\route\RouteMatcher, array());
        $path = $router->cleanPath("/one/two/three");
        $this->assertEquals(
            $router->found($path, "one/two/three", array('match' => array('one' => true, 'two' => true, 'three' => true))),
            array('route' => 'one/two/three', 'one' => 'one', 'two' => 'two', 'three' => 'three')
        );
    }
}
?>
