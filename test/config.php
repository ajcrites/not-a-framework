<?php
/**
 * Set up tests
 */

error_reporting(-1);
assert_options(ASSERT_ACTIVE, true);

define('TESTROOT', dirname(__FILE__));

require 'src/autoload.php';

abstract class NaF_TestCase extends PHPUnit_Framework_TestCase {}
?>
