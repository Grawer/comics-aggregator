<?php

namespace Grawer\ComicsAggregator\Entity;

class ComicItem
{
    public $title;
    public $url;
    public $description;

    public function equals(ComicItem $item)
    {
        if ($item->url == $this->url) {
            return true;
        }

        return false;
    }

    public function getFeedXml()
    {
        $xml = '<item>';
        $xml .= '<title>' . $this->title . '</title>';
        $xml .= '<link>' . $this->url . '</link>';
        $xml .= '<description>' . $this->description . '</description>';
        $xml .= '</item>';

        return $xml;
    }
}
