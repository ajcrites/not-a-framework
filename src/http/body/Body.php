<?php
/**
 * The purpose of this file is to define an interface for all
 * methods that Bodies must implement
 * @author Andrew Crites <explosion-pills@aysites.com>
 * @package naf
 */
namespace Naf\http\body;

/**
 * View interface
 */
interface Body
{
   /**
    * Output body to the user agent
    */
   public function emit();
}

?>
