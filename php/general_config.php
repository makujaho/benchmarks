<?php

ini_set('display_errors','On');
error_reporting(E_ALL);

// Zend Optimizer+ is not available in CLI, but APC might be enabled
ini_set('apc.enabled','0');
ini_set('apc.enable_cli', '0');

define('E', PHP_EOL);
