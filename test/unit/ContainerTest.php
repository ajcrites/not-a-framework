<?php
class ContainerText extends NaF_TestCase
{
    public function testContainerCreation()
    {
        $cnt = new Naf\di\Container();
        $this->assertTrue(true, "container created and message reached");
    }
}
?>
