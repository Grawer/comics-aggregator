<?php

namespace Grawer\ComicsAggregator\Source;

class SarahcAndersen extends Base
{
    public function getLatestComicImageUrl()
    {
        $this->homepage = file_get_contents('http://sarahcandersen.com/', false, stream_context_create($this->options));

        preg_match(
            '!<article.*?<img.*?src="(.*?)"!sm',
            $this->homepage,
            $matches
        );

        if (!isset($matches[1])) {
            return false;
        }

        $url = $matches[1];

        return $url;
    }
}
