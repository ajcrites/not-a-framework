<?php
/**
 * Tests for individual Session methods without dependencies
 * session\Session is the default NaF SESSION handler
 */
class ScalarSessionTest extends Naf_TestCase
{
    public function testCreateSession()
    {
        $session = new Naf\session\ScalarSession('phpunit');
        $this->assertTrue($session instanceof Naf\session\ScalarSession);
    }
}
?>
