<?php

namespace Grawer\ComicsAggregator\Entity;

class ComicItemRepository
{
    const REPOSITORY_FILE = 'data.json';
    protected $items;

    public function __construct()
    {
        if (file_exists(self::REPOSITORY_FILE)) {
            $this->items = json_decode(
                file_get_contents(self::REPOSITORY_FILE),
                false
            );
        } else {
            $this->items = array();
        }

        foreach ($this->items as $k => $item) {
            $comicItem = new ComicItem();
            $comicItem->title = $item->title;
            $comicItem->url = $item->url;
            $comicItem->description = $item->description;

            $this->items[$k] = $comicItem;
        }
    }

    public function save(ComicItem $newItem)
    {
        foreach ($this->items as $item) {
            if ($item->equals($newItem)) {
                return true;
            }
        }

        $this->items[] = $newItem;

        file_put_contents(
            self::REPOSITORY_FILE,
            json_encode($this->items)
        );

        return true;
    }
}
