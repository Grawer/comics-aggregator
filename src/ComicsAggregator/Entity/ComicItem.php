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
}
