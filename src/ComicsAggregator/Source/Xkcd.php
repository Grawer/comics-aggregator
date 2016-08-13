<?php

namespace Grawer\ComicsAggregator\Source;

class Xkcd extends Base
{
    public function getLatestComicImageUrl()
    {
        $homepage = file_get_contents('https://xkcd.com/');
        preg_match(
            '!\<div id\=\"comic\">.*?.*?\<img src\=\"(.*?)\"!sm',
            $homepage,
            $matches
        );

        if (isset($matches[1])) {
            $url = 'http:' . $matches[1];

            return $url;
        }

        return false;
    }
}
