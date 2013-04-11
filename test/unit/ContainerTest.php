<?php
class ContainerText extends NaF_TestCase
{
    private $cnt;
    public function setUp()
    {
        $this->cnt = new di\Container();
    }

    public function testContainerCreation()
    {
        $cnt = new di\Container();
        $this->assertTrue(true, "container created and message reached");
    }

    public function testCreateSimpleObject()
    {
        include TESTROOT . '/help/ObjectCreatedByContainer.php';
        $obj = $this->cnt->create('ObjectCreatedByContainer');

        $this->assertTrue($obj instanceof ObjectCreatedByContainer);
    }

    public function testCreateNestedObject()
    {
        $cnt = new di\Container();
        include TESTROOT . '/help/ObjectWithDependency.php';
        $obj = $this->cnt->create('ObjectWithDependency');

        $this->assertTrue($obj instanceof ObjectWithDependency);
    }
}
?>
