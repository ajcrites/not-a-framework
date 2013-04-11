<?php
/**
 * Tests for Container methods and use-cases for
 * Container.
 *
 * di\Container is the default dependency injection
 * container for NaF that uses type hinting to
 * record and create dependencies.
 */
class ContainerText extends NaF_TestCase
{
    private $cnt;
    public function setUp()
    {
        $this->cnt = new Naf\di\Container();
    }

    /**
     * Practically a smoke test
     */
    public function testContainerCreation()
    {
        $cnt = new Naf\di\Container();
        $this->assertTrue(true, "container created and message reached");
    }

    /**
     * Test creating an object with no dependencies from string
     */
    public function testCreateSimpleObject()
    {
        include TESTROOT . '/help/ObjectCreatedByContainer.php';
        $obj = $this->cnt->create('ObjectCreatedByContainer');

        $this->assertTrue($obj instanceof ObjectCreatedByContainer);
    }

    /**
     * Test creating an object with dependencies
     */
    public function testCreateNestedObject()
    {
        include TESTROOT . '/help/ObjectWithDependency.php';
        $obj = $this->cnt->create('ObjectWithDependency');

        $this->assertTrue($obj instanceof ObjectWithDependency);
    }

    /**
     * Test creation of using an actual NaF core object
     * This relies on NaF's base autolaod
     */
    public function testCreateNafObject()
    {
        $obj = $this->cnt->create('Naf\http\Request');

        $this->assertTrue($obj instanceof Naf\http\Request);
    }
}
?>
