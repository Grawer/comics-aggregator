<?php

require_once './vendor/autoload.php';

$comicId = (isset($_GET['id']) ? $_GET['id'] : null);
$repository = new \Grawer\ComicsAggregator\Entity\ComicItemRepository();
$comic = $repository->getComicById($comicId);

if ($comic) {
    ob_start();
    include('views/single.php');
    $content = ob_get_clean();
    echo $content;
} else {
    header('HTTP/1.0 404 Not Found', true, 404);
}
