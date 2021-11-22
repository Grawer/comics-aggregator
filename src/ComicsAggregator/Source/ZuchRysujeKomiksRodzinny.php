<?php

namespace Grawer\ComicsAggregator\Source;

class ZuchRysujeKomiksRodzinny extends Base
{
    protected $homepage;

    public function getLatestComicImageUrl()
    {
        $this->homepage = file_get_contents('https://zuch.media/category/komiks-rodzinny/', false, stream_context_create($this->options));

        preg_match(
            '!<noscript .*?><img src="(.*?)".*?>.*?</noscript>!sm',
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
