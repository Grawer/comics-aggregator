<?php

namespace Grawer\ComicsAggregator\Source;

class IntrovertDoodles extends Base
{
    public function getLatestComicImageUrl()
    {
        $this->homepage = file_get_contents('http://introvertdoodles.com/', false, stream_context_create($this->options));

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

    public function getTitle()
    {
        if (empty($this->homepage)) {
            $this->getLatestComicImageUrl();
        }

        preg_match(
            '!<article.*?<h1.*?<a.*?>(.*?)</a>!sm',
            $this->homepage,
            $matches
        );

        if (isset($matches[1])) {
            return $matches[1];
        }

        return '';
    }
}
