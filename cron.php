<?php

require_once './vendor/autoload.php';

$config = new \Grawer\ComicsAggregator\Helper\Configuration();

function apiCall($method, $payload)
{
    $config = new \Grawer\ComicsAggregator\Helper\Configuration();
    $url = $config::get('pocket_base_url') . $method;

    $payload['consumer_key'] = $config::get('pocket_consumer_key');
    $payload['access_token'] = $config::get('pocket_access_token');

    $options = array(
        CURLOPT_URL             => $url,
        CURLOPT_RETURNTRANSFER  => true,
        CURLOPT_SSL_VERIFYPEER  => false,
        CURLOPT_POST            => true,
        CURLOPT_POSTFIELDS      => json_encode($payload),
        CURLOPT_HTTPHEADER      => array('Content-Type: application/json; charset=UTF8',),
    );

    $curl = curl_init();
    curl_setopt_array($curl, $options);
    $response = curl_exec($curl);
    curl_close($curl);
    $response = json_decode($response, true);

    return $response;
}

$comics = array(
    'AndrzejRysuje'         => 'Andrzej Rysuje',
    'BoliBlog'              => 'boli blog',
    'CommitStrip'           => 'Commit Strip',
    'CyanideAndHappiness'   => 'Cyanide & Hapiness',
    'Deathbulge'            => 'Deathbulge',
    'Dilbert'               => 'Dilbert',
    'GeekAndPoke'           => 'Geek & Poke',
    'IntrovertDoodles'      => 'Introvert doodles',
    'KryzysWieku'           => 'Kryzys Wieku',
    'MonkeyUser'            => 'Monkey User',
    'SarahcAndersen'        => 'Sarah Andersen',
    'Wumo'                  => 'Wulff & Morgenthaler',
    'Xkcd'                  => 'Xkcd',
    // 'Garfield'              => 'Garfield',
    // 'Mutts'                 => 'Mutts',
    // 'PhdComics'             => 'PHD Comics',
    // 'WheresMyBubble'        => 'Where\'s My Bubble',
    // 'ZuchRysuje'            => 'Zuch rysuje',
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
        $comicItem = $repository->save($comicItem);

        if ($comicItem !== false) {
            $method = 'add';
            $payload = [
                'url'   => $config::get('base_url') . 'single.php?id=' . $comicItem->id,
                // 'url'   => $comicItem->url,
                // 'title' => $comicItem->getPocketTitle(),
            ];

            $result = apiCall($method, $payload);
        }
    }
}
