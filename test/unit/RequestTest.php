<?php
/**
 * Tests for individual Request methods without dependencies
 * http\Request is the default NaF Request
 */
class RequestTest extends Naf_TestCase
{
    public function testSpecificGetters()
    {
        $request = new Naf\http\Request('PATH', 'METHOD');
        $this->assertEquals($request->getPath(), 'PATH');
        $this->assertEquals($request->getMethod(), 'METHOD');
    }

    public function testSimpleTrim()
    {
        $request = new Naf\http\Request('', '');
        $this->assertEquals($request->trim('  spaces  '), 'spaces');
    }
}
?>
