<?php

namespace Grawer\ComicsAggregator\Source;

class Dillbert extends Base
{
    public function getLatestComicImageUrl()
    {
        $homepage = file_get_contents('http://dilbert.com/');
        preg_match(
            '!\<img class\=\"img-responsive img-comic\".*?src=\"(.*?)"!',
            $homepage,
            $matches
        );

        if (isset($matches[1])) {
            $url = $matches[1];

            return $url;
        }

        return false;
    }
}
