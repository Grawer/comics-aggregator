<?php

namespace Grawer\ComicsAggregator\Source;

class Mutts extends Base
{
    public function getLatestComicImageUrl()
    {
        $this->homepage = file_get_contents('https://mutts.com/');

        preg_match(
            '!<div class="daily-strip-wrapper"><a href="https://mutts.com/product/strip-082120/"><img src="(.*?)".*?/>!sm',
            $this->homepage,
            $matches
        );

        if (isset($matches[1])) {
            $url = $matches[1];

            return $url;
        }

        return false;
    }
}
