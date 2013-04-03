<?php

ini_set('display_errors','On');
error_reporting(E_ALL);

define('E', PHP_EOL);

// TODO: Set *any* code optimizers like APC or Zend Optimizer to disabled
//require 'disable_optimizers.php';

// Even with large numbers, those tests sometimes turn out completely 
// different
$testcount      = 100000000;
$string         = 'Some random string';

$t1 = microtime(true);
echo 'strlen'.E;
for ($i = 0; $i <= $testcount; ++$i) {
    $t = strlen($string);
}

$t2 = microtime(true);
echo 'strlen with var'.E;
$len = strlen($string);
for ($i = 0; $i <= $testcount; ++$i) {
    $t = $len;
}

$t3 = microtime(true);

echo 'Done testing. Results:'.E;
echo 'strlen:          ' . ($t2 - $t1).E;
echo 'strlen with var: ' . ($t3 - $t2).E;
