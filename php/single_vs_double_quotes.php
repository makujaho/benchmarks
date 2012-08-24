<?php

ini_set('display_errors','On');
error_reporting(E_ALL);

define('E', PHP_EOL);

// TODO: Set *any* code optimizers like APC or Zend Optimizer to disabled
//require 'disable_optimizers.php';

// Even with large numbers, those tests sometimes turn out completely 
// different
$testcount      = 100000000;
$teststring     = 'Teststring';

$t1 = microtime(true);
echo 'Single quotes, no variables'.E;
for ($i = 0; $i <= $testcount; ++$i) {
    $t = '1 Teststring';
}

$t2 = microtime(true);
echo 'Double quotes, no variables'.E;
for ($i = 0; $i <= $testcount; ++$i) {
    $t = "1 Teststring";
}

$t3 = microtime(true);
echo 'Single quotes, one variable, concat'.E;
for ($i = 0; $i <= $testcount; ++$i) {
    $t = '1 Teststring ' . $teststring;
}

$t4 = microtime(true);
echo 'Double quotes, one variable, inline'.E;
for ($i = 0; $i <= $testcount; ++$i) {
    $t = "1 Teststring $teststring";
}

$t5 = microtime(true);
echo 'Double quotes, one variable, concat'.E;
for ($i = 0; $i <= $testcount; ++$i) {
    $t = "1 Teststring" . $teststring;
}

$t6 = microtime(true);

echo 'Done testing. Results:'.E;
echo 'Single quotes, no var:          ' . ($t2 - $t1).E;
echo 'Double quotes, no var:          ' . ($t3 - $t2).E;
echo 'Single quotes, one var:         ' . ($t4 - $t3).E;
echo 'Double quotes, one var, inline: ' . ($t5 - $t4).E;
echo 'Double quotes, one var, concat: ' . ($t6 - $t5).E;
