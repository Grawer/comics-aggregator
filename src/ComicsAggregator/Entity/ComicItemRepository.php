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

        $comicsContainer = array();

        foreach ($this->items as $k => $item) {
            $comicItem = new ComicItem();
            $comicItem->id = $item->id;
            $comicItem->sourceName = $item->sourceName;
            $comicItem->title = $item->title;
            $comicItem->url = $item->url;
            $comicItem->description = $item->description;
            $comicItem->date = new \DateTime($item->date->date);

            $comicsContainer[$comicItem->id] = $comicItem;
        }

        $this->items = $comicsContainer;
    }

    public function getAllItems()
    {
        return $this->items;
    }

    public function getComicById($id)
    {
        foreach ($this->items as $item) {
            if ($item->id == $id) {
                return $item;
            }
        }

        return null;
    }

    public function save(ComicItem $newItem)
    {
        foreach ($this->items as $item) {
            if ($item->equals($newItem)) {
                $newItem->id = $item->id;

                return true;
            }
        }

        $newElementId = empty($this->items) ? 1 : max(array_keys($this->items)) + 1;
        $newItem->id = $newElementId;
        $this->items[$newItem->id] = $newItem;

        file_put_contents(
            self::REPOSITORY_FILE,
            json_encode($this->items)
        );

        return true;
    }
}
