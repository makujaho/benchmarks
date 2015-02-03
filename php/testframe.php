<?php

require_once 'benchframe.php';

class ExampleTimer extends Benchframe {
    protected $version = 3;
}

$timer = new ExampleTimer();

$timer->addTiming();

for ($i = 0; $i<=10000;$i++) {
    $e = $i + 1;
}

$timer->addTiming('I plus one.');

for ($i = 0; $i<=10000;$i++) {
    $e = $i++;
}

$timer->addTiming('Plus plus i');

echo $timer;
