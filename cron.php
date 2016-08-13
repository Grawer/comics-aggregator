<?php

require_once './vendor/autoload.php';

$comic = new \Grawer\ComicsAggregator\Source\Garfield();
$imageUrl = $comic->getLatestComicImageUrl();

if (!empty($imageUrl)) {
    $comicItem = new \Grawer\ComicsAggregator\Entity\ComicItem();
    $comicItem->title = 'Garfield';
    $comicItem->url = $imageUrl;
    $comicItem->description = '';

    $repository = new \Grawer\ComicsAggregator\Entity\ComicItemRepository();
    $repository->save($comicItem);
}

$comic = new \Grawer\ComicsAggregator\Source\Dillbert();
$imageUrl = $comic->getLatestComicImageUrl();

if (!empty($imageUrl)) {
    $comicItem = new \Grawer\ComicsAggregator\Entity\ComicItem();
    $comicItem->title = 'Dillbert';
    $comicItem->url = $imageUrl;
    $comicItem->description = '';

    $repository = new \Grawer\ComicsAggregator\Entity\ComicItemRepository();
    $repository->save($comicItem);
}
