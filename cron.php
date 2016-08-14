<?php

require_once './vendor/autoload.php';

$comics = array(
    'Garfield',
    'Dillbert',
    'Xkcd',
);

foreach ($comics as $comicName) {
    $className = '\Grawer\ComicsAggregator\Source\\' . $comicName;
    $comic = new $className();
    $imageUrl = $comic->getLatestComicImageUrl();

    if (!empty($imageUrl)) {
        $comicItem = new \Grawer\ComicsAggregator\Entity\ComicItem();
        $comicItem->title = '';
        $comicItem->sourceName = $comicName;
        $comicItem->url = $imageUrl;
        $comicItem->description = '';
        $comicItem->date = new \DateTime();

        $repository = new \Grawer\ComicsAggregator\Entity\ComicItemRepository();
        $repository->save($comicItem);
    }
}
