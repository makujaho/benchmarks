<?php

define('E', PHP_EOL);
// TODO: Set *any* code optimizers like APC or Zend Optimizer to disabled

$testcount      = 1000;
$testconstants  = array(10,100,1000,5000);
$d              = dirname(__FILE__);

foreach ($testconstants as $constnumber) {

    echo 'Generating namespace with ' . $constnumber . ' constants:'.E;
    $t1 = microtime(true);

    $constants = '<?php namespace testspace' . $constnumber . ';';
    for ($i = 0; $i <= $constnumber; ++$i) {
        //$constants .= "define(__NAMESPACE__ . '\constant$i', 'constval$i');";
        $constants .= "define('testspace$constnumber\constant$i', 'constval$i');";
    }
    $n_fname = $d . '/tmp/object_vs_namespace_namespace' . $constnumber . '.php';
    file_put_contents($n_fname, $constants);

    echo 'Generating object with $constnumber constants...'.E;
    $t2 = microtime(true);

    $object = '<?php class testclass' . $constnumber . ' {';
    for ($i = 0; $i <= $constnumber; ++$i) {
        $object .= "const FFFFFFFFFFFFFFFFFconstant$i = 'constval$i';";
    }
    $object .= '}';
    $o_fname = $d . '/tmp/object_vs_namespace_object' . $constnumber . '.php';
    file_put_contents($o_fname, $object);

    echo 'Generated files. Starting tests.'.E;
    $t3 = microtime(true);

    echo 'Accessing constants'.E;
    $t4 = microtime(true);

    require $n_fname;
    require $o_fname;
    for ($i = 0; $i <= $testcount; ++$i) {
        // Access random constant
        $c = rand(0, $constnumber);
        $t = constant("testspace$constnumber\\constant$c");
    }

    echo 'Accessing object'.E;
    $t5 = microtime(true);
    
    for ($i = 0; $i <= $testcount; ++$i) {
        // Access random object const
        $c = rand(0, $constnumber);
        $t = constant("testclass$constnumber::constant$c");
    }
    $t6 = microtime(true);

    echo 'Done testing. Results:'.E;
    echo 'Namespace: ' . ($t5 - $t4).E;
    echo 'Object:    ' . ($t6 - $t5).E;
    echo 'Times: '.E;
    echo '       1 - ' . $t1.E;
    echo '       2 - ' . $t2.E;
    echo '       3 - ' . $t3.E;
    echo '       4 - ' . $t4.E;
    echo '       5 - ' . $t5.E;
    echo '       6 - ' . $t6.E;
}
