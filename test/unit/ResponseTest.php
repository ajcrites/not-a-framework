<?php
/**
 * Tests for individual Response methods without dependencies
 * http\Response is the default NaF Response
 */
class ResponseTest extends Naf_TestCase
{
    public function testCreateResponse()
    {
        new Naf\http\Response(array());
        Naf\http\Response::create(array(), new Naf\di\Container);
    }
}
?>
