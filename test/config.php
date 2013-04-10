<?php
/**
 * Set up tests
 */

error_reporting(-1);
assert_options(ASSERT_ACTIVE, true);

require 'src/autoload.php';

abstract class NaF_TestCase extends PHPUnit_Framework_TestCase {}
?>
