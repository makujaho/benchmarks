<?php

ini_set('display_errors','On');
error_reporting(E_ALL);

require_once 'benchframe.php';

class ObjectVsNamespace extends Benchframe {
    protected $version = 1;
}

$timer          = new ObjectVsNamespace();
$testcount      = 100000;
$testconstants  = array(10,100,1000,5000);
$d              = dirname(__FILE__);

foreach ($testconstants as $constnumber) {

    echo 'Generating namespace with ' . $constnumber . ' constants:'.E;

    $constants = '<?php namespace testspace' . $constnumber . ';';
    for ($i = 0; $i <= $constnumber; ++$i) {
        //$constants .= "define(__NAMESPACE__ . '\constant$i', 'constval$i');";
        $constants .= "define('testspace$constnumber\constant$i', 'constval$i');";
    }
    $n_fname = $d . '/tmp/object_vs_namespace_namespace' . $constnumber . '.php';
    file_put_contents($n_fname, $constants);

    echo 'Generating object with $constnumber constants...'.E;

    $object = '<?php class testclass' . $constnumber . ' {';
    for ($i = 0; $i <= $constnumber; ++$i) {
        $object .= "const FFFFFFFFFFFFFFFFFconstant$i = 'constval$i';";
    }
    $object .= '}';
    $o_fname = $d . '/tmp/object_vs_namespace_object' . $constnumber . '.php';
    file_put_contents($o_fname, $object);

    echo 'Generated files. Starting tests.'.E;
    echo 'Accessing constants'.E;
    $timer->addTiming();

    require $n_fname;
    for ($i = 0; $i <= $testcount; ++$i) {
        // Access random constant
        $c = rand(0, $constnumber);
        $t = constant("testspace$constnumber\\constant$c");
    }

    echo 'Accessing object'.E;
    $timer->addTiming('Namespace - Constants: ' . $constnumber);
    
    require $o_fname;
    for ($i = 0; $i <= $testcount; ++$i) {
        // Access random object const
        $c = rand(0, $constnumber);
        $t = constant("testclass$constnumber::FFFFFFFFFFFFFFFFFconstant$c");
    }
    $timer->addTiming('Object    - Constants: ' . $constnumber);

    echo 'Done testing. Results:'.E;
    echo $timer;
}
