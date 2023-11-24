<?php

namespace Grawer\ComicsAggregator\Source;

class CyanideAndHappiness extends Base
{
    public function getLatestComicImageUrl()
    {
        $homepage = file_get_contents('http://explosm.net/comics/latest/', false, stream_context_create($this->options));

        preg_match(
            '!\<img src="(.*?)"!',
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
