<?php

namespace Grawer\ComicsAggregator\Source;

class Deathbulge extends Base
{
    public function getLatestComicImageUrl()
    {
        $entry = file_get_contents('http://www.deathbulge.com/api/comics', false, stream_context_create($this->options));
        $this->entry = json_decode($entry, true);

        if (isset($this->entry['comic']['comic'])) {
            $url = 'http://www.deathbulge.com' . $this->entry['comic']['comic'];

            return $url;
        }

        return false;
    }

    public function getTitle()
    {
        if (isset($this->entry['comic']['title'])) {
            return $this->entry['comic']['title'];
        }

        return '';
    }

    public function getDescription()
    {
        if (isset($this->entry['comic']['alt_text'])) {
            return $this->entry['comic']['alt_text'];
        }

        return '';
    }
}
