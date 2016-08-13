<?php

require_once './vendor/autoload.php';

// $foo = new \Grawer\ComicsAggregator\Source\Garfield();
// $result = $foo->getLatestComicImageUrl();
// var_dump($result);

$repository = new \Grawer\ComicsAggregator\Entity\ComicItemRepository();

var_dump($repository);

$foo = new Grawer\ComicsAggregator\Entity\ComicItem();
$foo->title = 'test';
$foo->url = 'http://www.wp.pl/';
$foo->description = '';

$repository->save($foo);

var_dump($repository);
