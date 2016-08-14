<?php

require_once './vendor/autoload.php';

$comics = array(
    'Dillbert',
    'Garfield',
    'Wumo',
    'Xkcd',
);

foreach ($comics as $comicName) {
    $className = '\Grawer\ComicsAggregator\Source\\' . $comicName;
    $comic = new $className();
    $imageUrl = $comic->getLatestComicImageUrl();
    $title = $comic->getTitle();
    $description = $comic->getDescription();

    if (!empty($imageUrl)) {
        $comicItem = new \Grawer\ComicsAggregator\Entity\ComicItem();
        $comicItem->title = $title;
        $comicItem->sourceName = $comicName;
        $comicItem->url = $imageUrl;
        $comicItem->description = $description;
        $comicItem->date = new \DateTime();

        $repository = new \Grawer\ComicsAggregator\Entity\ComicItemRepository();
        $repository->save($comicItem);
    }
}
