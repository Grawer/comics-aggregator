<?php

require_once './vendor/autoload.php';

use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

$config = new \Grawer\ComicsAggregator\Helper\Configuration();

$comics = array(
    'AdamAtHome'                    => 'Adam@Home',
    'AndrzejRysuje'                 => 'Andrzej Rysuje',
    'AuntyAcid'                     => 'Aunty Acid',
    'Bacon'                         => 'Bacon',
    'Ben'                           => 'Ben',
    'BoliBlog'                      => 'boli blog',
    'CalvinAndHobbes'               => 'Calvin and Hobbes',
    'Crabgras'                      => 'Crabgras',
    'CyanideAndHappiness'           => 'Cyanide & Hapiness',
    'Foxtrot'                       => 'Foxtrot',
    'Garfield'                      => 'Garfield',
    'JerryKing'                     => 'Jerry King',
    'KryzysWieku'                   => 'Kryzys Wieku',
    'MonkeyUser'                    => 'Monkey User',
    'Mutts'                         => 'Mutts',
    'PeanutsBegins'                 => 'Peanuts Begins',
    'Pickles'                       => 'Pickles',
    'SarahcAndersen'                => 'Sarah Andersen',
    'TooMuchCoffeeMan'              => 'Too Much Coffee Man',
    'Wumo'                          => 'Wulff & Morgenthaler',
    'Xkcd'                          => 'Xkcd',
    'ZenPencils'                    => 'Zen Pencils',

    // Temporaily off
    // 'Bottomliners'                  => 'Bottomliners',
    // 'CommitStrip'                   => 'Commit Strip',
    // 'Deathbulge'                    => 'Deathbulge',
    // 'Dilbert'                       => 'Dilbert',
    // 'GeekAndPoke'                   => 'Geek & Poke',
    // 'IntrovertDoodles'              => 'Introvert doodles',
    // 'PhdComics'             => 'PHD Comics',
    // 'TheAdventuresOfBusinessCat'    => 'The Adventures Of Business Cat',
    // 'WheresMyBubble'        => 'Where\'s My Bubble',
    // 'ZuchRysuje'                    => 'Zuch rysuje',
    // 'ZuchRysujeKomiksRodzinny'      => 'Zuch rysuje - komiks rodzinny',
);

foreach ($comics as $sourceClass => $comicName) {
    $className = '\Grawer\ComicsAggregator\Source\\' . $sourceClass;
    $comic = new $className();

    $imageUrl = $comic->getLatestComicImageUrl();

    if (!empty($imageUrl)) {
        $comicItem = new \Grawer\ComicsAggregator\Entity\ComicItem();
        $comicItem->title = $comic->getTitle();
        $comicItem->sourceName = $comicName;
        $comicItem->url = $imageUrl;
        $comicItem->description = $comic->getDescription();
        $comicItem->date = new \DateTime();

        $repository = new \Grawer\ComicsAggregator\Entity\ComicItemRepository();
        $comicItem = $repository->save($comicItem);

        if ($comicItem !== false) {
            sendToEmail($comicItem->id);
        }
    }
}

function sendToEmail(int $comicId): bool
{
    $repository = new \Grawer\ComicsAggregator\Entity\ComicItemRepository();

    $comic = $repository->getComicById($comicId);

    if (!$comic) {
        return false;
    }

    $config = new \Grawer\ComicsAggregator\Helper\Configuration();

    $transport = Transport::fromDsn($config::get('email_dsn'));
    $mailer = new Mailer($transport);

    $email = (new Email())
        ->from(new Address($config::get('email'), 'Comics Aggregator'))
        ->to($config::get('email'))
        ->subject($comic->getFullTitle(). ' #comics')
        ;

    $imageUrls = $comic->url;
    if (!is_array($imageUrls)) {
        $imageUrls = [$imageUrls];
    }

    foreach ($imageUrls as $i => $imageUrl) {
        $email->embedFromPath($imageUrl, 'image-' . $i, 'image/png');
    }

    ob_start();
    include('views/body.php');
    $body = ob_get_clean();

    $email->html($body);
    $mailer->send($email);

    return false;
}
