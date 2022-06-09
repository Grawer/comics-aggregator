<?php

namespace Grawer\ComicsAggregator\Source;

class CommitStrip extends Base
{
    protected $homepage;

    public function getLatestComicImageUrl()
    {
        $this->homepage = file_get_contents('http://www.commitstrip.com/en/', false, stream_context_create($this->options));

        preg_match(
            '!<section>.*?<a href="(.*?)"!sm',
            $this->homepage,
            $matches
        );

        $url = null;
        if (isset($matches[1])) {
            $url = $matches[1];
        }

        if (empty($url)) {
            return false;
        }

        $this->homepage = file_get_contents($url, false, stream_context_create($this->options));

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
            '!<header class="entry-header">.*?<h1 class="entry-title">(.*?)</h1>!sm',
            $this->homepage,
            $matches
        );

        if (isset($matches[1])) {
            return $matches[1];
        }

        return '';
    }
}
