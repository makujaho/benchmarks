<?php

require_once 'benchframe.php';

class example_timer extends benchframe {
    protected $version = 3;
}

$timer = new example_timer();

$timer->add_timing();

for ($i = 0; $i<=10000;$i++) {
    $e = $i + 1;
}

$timer->add_timing('I plus one.');

for ($i = 0; $i<=10000;$i++) {
    $e = $i++;
}

$timer->add_timing('Plus plus i');

echo $timer;
