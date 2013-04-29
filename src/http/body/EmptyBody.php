<?php
/**
 * Representation of empty response body
 * @author Andrew Crites <explosion-pills@aysites.com>
 * @package naf
 */
namespace Naf\http\body;

class EmptyBody implements Body {
   public function emit() {}
}
?>
