<?php

require_once './vendor/autoload.php';

$comic = new \Grawer\ComicsAggregator\Source\Garfield();
$imageUrl = $comic->getLatestComicImageUrl();

$comicItem = new \Grawer\ComicsAggregator\Entity\ComicItem();
$comicItem->title = 'Garfield';
$comicItem->url = $imageUrl;
$comicItem->description = '';

$repository = new \Grawer\ComicsAggregator\Entity\ComicItemRepository();
$repository->save($comicItem);
