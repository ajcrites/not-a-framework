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

    public function testTrim()
    {
        $request = new Naf\http\Request('', '');
        $this->assertEquals($request->trim('  spaces  '), 'spaces');
        $this->assertEquals($request->trim(array('  spaces  ', array('  spaces  '))), array('spaces', array('spaces')));
    }

    public function testMagicGetterSetter()
    {
        $request = new Naf\http\Request('', '');
        //headers has the special default empty array value
        $this->assertEquals($request->headers, array());
        $this->assertNull($request->nonextant);
        $request->one = 1;
        $this->assertEquals($request->one, 1);
        $request->array = array('of values');
        $this->assertEquals($request->array, array('of values'));
    }
}
?>
