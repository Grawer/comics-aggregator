<?php

namespace Grawer\ComicsAggregator\Source;

class AndrzejRysuje extends Base
{
    protected $homepage;

    public function getLatestComicImageUrl()
    {
        $this->homepage = file_get_contents('http://www.andrzejrysuje.pl/');

        preg_match(
            '!<div class="post-.*?<img class=".*?wp-image-.*?" src="(.*?)"!sm',
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
            '!<div class="post-.*?<h2.*?>(.*?)</h2>!sm',
            $this->homepage,
            $matches
        );

        if (isset($matches[1])) {
            $clean = strip_tags($matches[1]);

            return $clean;
        }

        return '';
    }

    public function getDescription()
    {
        if (empty($this->homepage)) {
            $this->getLatestComicImageUrl();
        }

        preg_match(
            '!<div class="post-.*?<img.*?/>(.*?)</p>!sm',
            $this->homepage,
            $matches
        );

        if (isset($matches[1])) {
            $clean = strip_tags($matches[1]);

            return $clean;
        }

        return '';
    }
}
