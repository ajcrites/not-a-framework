<?php
/**
 * Make sure that NaF doesn't start smoking when it runs
 */
class SmokeTest extends NaF_TestCase
{
    function testForSmoke()
    {
        $this->assertEquals("smoke", "smoke");
    }
}
?>
