<?php
/**
 * Make sure that NaF doesn't start smoking when it runs
 */
class SmokeTest extends Naf_TestCase
{
    function testForSmoke()
    {
        $this->assertEquals("smoke", "smoke");
    }
}
?>
