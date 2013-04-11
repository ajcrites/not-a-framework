<?php
class ContainerText extends NaF_TestCase
{
    private $cnt;
    public function setUp()
    {
        $this->cnt = new Naf\di\Container();
    }

    public function testContainerCreation()
    {
        $cnt = new Naf\di\Container();
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
        include TESTROOT . '/help/ObjectWithDependency.php';
        $obj = $this->cnt->create('ObjectWithDependency');

        $this->assertTrue($obj instanceof ObjectWithDependency);
    }

    public function testCreateNafObject()
    {
        $obj = $this->cnt->create('Naf\http\Request');

        $this->assertTrue($obj instanceof Naf\http\Request);
    }
}
?>
