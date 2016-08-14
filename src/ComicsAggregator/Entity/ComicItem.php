<?php

namespace Grawer\ComicsAggregator\Entity;

use Grawer\ComicsAggregator\Helper\Configuration;

class ComicItem
{
    public $id;
    public $sourceName;
    public $title;
    public $url;
    public $description;
    public $date;

    public function equals(ComicItem $item)
    {
        if ($item->url == $this->url) {
            return true;
        }

        return false;
    }

    public function getFeedXml()
    {
        $config = new Configuration();
        $baseUrl = $config::get('base_url');

        $xml = '<item>';
        $xml .= '<title>' . $this->sourceName . ' - ' . $this->date->format('Y-m-d') . '</title>';
        $xml .= '<link>' . $baseUrl . 'single.php?id=' . $this->id . '</link>';
        $xml .= '<description>' . $this->description . '</description>';
        $xml .= '<pubDate>' . $this->date->format('r') . '</pubDate>';
        $xml .= '<guid>' . $baseUrl . 'single.php?id=' . $this->id . '</guid>';
        $xml .= '</item>';

        return $xml;
    }
}
