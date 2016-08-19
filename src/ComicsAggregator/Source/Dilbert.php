<?php

namespace Grawer\ComicsAggregator\Source;

class Dilbert extends Base
{
    protected $homepage;

    public function getLatestComicImageUrl()
    {
        $this->homepage = file_get_contents('http://dilbert.com/');

        preg_match(
            '!\<img class\=\"img-responsive img-comic\".*?src=\"(.*?)"!',
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
            '!<span class="comic-title-name">(.*?)</span>!sm',
            $this->homepage,
            $matches
        );

        if (isset($matches[1])) {
            return $matches[1];
        }

        return '';
    }

    public function getDescription()
    {
        if (empty($this->homepage)) {
            $this->getLatestComicImageUrl();
        }

        preg_match(
            '!<div id="js-toggle-transcript.*?<p>(.*?)</p>!sm',
            $this->homepage,
            $matches
        );

        if (isset($matches[1])) {
            return $matches[1];
        }

        return '';
    }
}
