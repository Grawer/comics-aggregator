<?php

require_once './vendor/autoload.php';

$repository = new \Grawer\ComicsAggregator\Entity\ComicItemRepository();
$items = $repository->getAllItems();
$items = array_reverse($items);

$config = new \Grawer\ComicsAggregator\Helper\Configuration();
$baseUrl = $config::get('base_url');

$xml = '<?xml version="1.0" encoding="UTF-8" ?>';
$xml .= '<rss version="2.0">';
$xml .= '<channel>';
$xml .= '<title>Comics Aggregator</title>';
$xml .= '<link>' . $baseUrl . 'feed.php</link>';
$xml .= '<description></description>';

foreach ($items as $item) {
    $xml .= $item->getFeedXml();
}

$xml .= '</channel>';
$xml .= '</rss>';

echo $xml;
