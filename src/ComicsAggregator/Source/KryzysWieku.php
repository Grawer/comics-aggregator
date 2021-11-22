<?php

namespace Grawer\ComicsAggregator\Source;

class KryzysWieku extends Base
{
    protected $homepage;

    public function getLatestComicImageUrl()
    {
        $this->homepage = file_get_contents('http://kryzyswieku.blogspot.com/', false, stream_context_create($this->options));

        preg_match(
            '!<div class=\'post hentry.*?<img .*?src="(.*?)\"!sm',
            $this->homepage,
            $matches
        );

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
            '!<div class=\'post hentry.*?<h3 class=\'post-title.*?<a.*?>(.*?)</a>!sm',
            $this->homepage,
            $matches
        );

        if (isset($matches[1])) {
            return $matches[1];
        }

        return '';
    }
}
