<?php
/**
 * Tests for individual Response methods without dependencies
 * http\Response is the default NaF Response
 */
class ResponseTest extends Naf_TestCase
{
    public function testCreateResponse()
    {
        $response = new Naf\http\Response(array());
        $this->assertTrue($response instanceof Naf\http\Response);
        $response = Naf\http\Response::create(array(), new Naf\di\Container);
        $this->assertTrue($response instanceof Naf\http\Response);
    }

    public function testEmptyBody()
    {
        $response = Naf\http\Response::create(array(), new Naf\di\Container);
        $this->assertEquals($response->emit(), '');
    }
}
?>
