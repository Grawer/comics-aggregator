<?php

namespace Grawer\ComicsAggregator\Source;

class Xkcd extends Base
{
    protected $homepage;

    public function getLatestComicImageUrl()
    {
        $this->homepage = file_get_contents('https://xkcd.com/', false, stream_context_create($this->options));

        preg_match(
            '!\<div id\=\"comic\">.*?.*?\<img src\=\"(.*?)\"!sm',
            $this->homepage,
            $matches
        );

        if (isset($matches[1])) {
            $url = 'http:' . $matches[1];

            return $url;
        }

        return false;
    }

    public function getTitle()
    {
        if (empty($this->homepage)) {
            $this->getLatestComicImageUrl();
        }

        preg_match(
            '!\<div id\=\"ctitle"\>(.*?)\<\/div\>!sm',
            $this->homepage,
            $matches
        );

        if (isset($matches[1])) {
            return $matches[1];
        }

        return '';
    }

    public function getDescription()
    {
        if (empty($this->homepage)) {
            $this->getLatestComicImageUrl();
        }

        preg_match(
            '!\<div id\=\"comic\">.*?.*?\<img .*?title\=\"(.*?)\"!sm',
            $this->homepage,
            $matches
        );

        if (isset($matches[1])) {
            return $matches[1];
        }

        return '';
    }
}
