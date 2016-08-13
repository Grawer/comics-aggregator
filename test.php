<?php

require_once './vendor/autoload.php';

$foo = new \Grawer\ComicsAggregator\Source\Garfield();
$result = $foo->getLatestComicImageUrl();

var_dump($result);
