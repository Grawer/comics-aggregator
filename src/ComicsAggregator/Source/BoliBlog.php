<?php

namespace Grawer\ComicsAggregator\Source;

class BoliBlog extends Base
{
    protected $homepage;

    public function getLatestComicImageUrl()
    {
        $this->homepage = file_get_contents('http://boli-blog.pl/', false, stream_context_create($this->options));

        preg_match(
            '!<div class="entry-content">.*?<img .*?src="(.*?)"!sm',
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
            '!<h1 class="entry-title"><a.*?>(.*?)</a></h1>!sm',
            $this->homepage,
            $matches
        );

        if (isset($matches[1])) {
            return $matches[1];
        }

        return '';
    }
}
