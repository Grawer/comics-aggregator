<?php

require_once './vendor/autoload.php';

$comics = array(
    'CyanideAndHappiness'   => 'Cyanide & Hapiness',
    'Dillbert'              => 'Dillbert',
    'Garfield'              => 'Garfield',
    'Wumo'                  => 'Wulff & Morgenthaler',
    'Xkcd'                  => 'Xkcd',
    'ZuchRysuje'            => 'Zuch rysuje',
);

foreach ($comics as $sourceClass => $comicName) {
    $className = '\Grawer\ComicsAggregator\Source\\' . $sourceClass;
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
