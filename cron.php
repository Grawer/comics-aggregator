<?php

require_once './vendor/autoload.php';

$comics = array(
    'AndrzejRysuje'         => 'Andrzej Rysuje',
    // 'BoliBlog'              => 'boli blog',
    'CommitStrip'           => 'Commit Strip',
    'CyanideAndHappiness'   => 'Cyanide & Hapiness',
    'Deathbulge'            => 'Deathbulge',
    'Dilbert'               => 'Dilbert',
    'Garfield'              => 'Garfield',
    'GeekAndPoke'           => 'Geek & Poke',
    'IntrovertDoodles'      => 'Introvert doodles',
    'KryzysWieku'           => 'Kryzys Wieku',
    'MonkeyUser'            => 'Monkey User',
    'Mutts'                 => 'Mutts',
    // 'SarahcAndersen'        => 'Sarah Andersen',
    // 'WheresMyBubble'        => 'Where\'s My Bubble',
    'Wumo'                  => 'Wulff & Morgenthaler',
    'Xkcd'                  => 'Xkcd',
    'ZuchRysuje'            => 'Zuch rysuje',
    // 'PhdComics'             => 'PHD Comics',
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
