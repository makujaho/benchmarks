<?php

ini_set('display_errors','On');
error_reporting(E_ALL);

require_once 'benchframe.php';

class ArrayVsEquals extends Benchframe {
    protected $version = 1;
}

$timer          = new ArrayVsEquals();
$testvars       = array(5000,50000,100000);

echo "Array() vs. Equals";

foreach ($testvars as $varnumber) {

    $timer->addTiming();

    echo 'Creating ' . $varnumber . ' arrays with array():'.E;

    for ($i = 0; $i <= $varnumber; ++$i) {
        $var{$i} = array();
    }

    $timer->addTiming('Array() - Vars: ' . $varnumber);

    echo 'Creating ' . $varnumber . 'arrays with "$var1 = $var2 = array()"'.E;
    $var0 = array();
    for ($i = 1; $i <= $varnumber; ++$i) {
        $var{$i} = $var{$i-1};
    }

    $timer->addTiming('Equals - Vars: ' . $varnumber);
    
    echo 'Done testing. Results:'.E;
    echo $timer;
}
