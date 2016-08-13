<?php

require_once './vendor/autoload.php';

$repository = new \Grawer\ComicsAggregator\Entity\ComicItemRepository();
$items = $repository->getAllItems();
$items = array_reverse($items);

$xml = '<?xml version="1.0" encoding="UTF-8" ?>';
$xml .= '<channel>';
$xml .= '<title>Comics Aggregator</title>';
$xml .= '<link>...</link>';
$xml .= '<description></description>';

foreach ($items as $item) {
    $xml .= $item->getFeedXml();
}

$xml .= '</channel>';
$xml .= '</item>';

echo $xml;
