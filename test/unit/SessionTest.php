<?php
/**
 * Tests for individual Session methods without dependencies
 * session\Session is the default NaF SESSION handler
 */
class SessionTest extends Naf_TestCase
{
    public function testCreateSession()
    {
        $session = new Naf\session\Session('phpunit');
        $this->assertTrue($session instanceof Naf\session\Session);
    }
}
?>
