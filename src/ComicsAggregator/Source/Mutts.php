<?php

namespace Grawer\ComicsAggregator\Source;

class Mutts extends Base
{
    public function getLatestComicImageUrl()
    {
        $homepage = file_get_contents('http://www.mutts.com/');

        preg_match(
            '!<figure><img src="(.*?)"!',
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
