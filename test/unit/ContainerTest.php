<?php
class ContainerText extends NaF_TestCase
{
    public function testContainerCreation()
    {
        $cnt = new di\Container();
        $this->assertTrue(true, "container created and message reached");
    }
}
?>
