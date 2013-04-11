<?php
class ContainerText extends NaF_TestCase
{
    public function testContainerCreation()
    {
        $cnt = new di\Container();
        $this->assertTrue(true, "container created and message reached");
    }

    public function testCreateSimpleObject()
    {
        $cnt = new di\Container();
        include TESTROOT . '/help/ObjectCreatedByContainer.php';
        $obj = $cnt->create('ObjectCreatedByContainer');

        $this->assertTrue($obj instanceof ObjectCreatedByContainer);
    }

    public function testCreateNestedObject()
    {
        $cnt = new di\Container();
        include TESTROOT . '/help/ObjectCreatedByContainer.php';
        include TESTROOT . '/help/ObjectWithDependency.php';
        $obj = $cnt->create('ObjectWithDependency');

        $this->assertTrue($obj instanceof ObjectWithDependency);
    }
}
?>
