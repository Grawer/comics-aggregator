<?php

namespace Grawer\ComicsAggregator\Source;

class SarahcAndersen extends Base
{
    public function getLatestComicImageUrl()
    {
        $this->homepage = file_get_contents('http://sarahcandersen.com/');

        preg_match(
            '!<article.*?<img.*?src="(.*?)"!sm',
            $this->homepage,
            $matches
        );

        if (!isset($matches[1])) {
            return false;
        }

        if (isset($matches[1])) {
            $url = $matches[1];

            return $url;
        }

        return false;
    }
}
