<?php

namespace Grawer\ComicsAggregator\Source;

class ZuchRysuje extends Base
{
    protected $homepage;

    public function getLatestComicImageUrl()
    {
        $this->homepage = file_get_contents('http://zuch.media/category/komiks-biurowy/');

        preg_match(
            '!<h4 class="entry-title" itemprop="headline">.*?<a href="(.*?)".*?</h4>!sm',
            $this->homepage,
            $matches
        );

        if (!isset($matches[1])) {
            return false;
        }

        $url = $matches[1];
        $this->homepage = file_get_contents($url);

        preg_match(
            '!<img class="aligncenter size-full wp-image-.*?src="(.*?)"!sm',
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
            '!<h4 class="entry-title" itemprop="headline">(.*?)</h4>!sm',
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
            '!<p>.*?<img class="aligncenter size-full wp-image-.*?</p>.*?<p.*?>(.*?)</p>!sm',
            $this->homepage,
            $matches
        );

        if (isset($matches[1])) {
            return $matches[1];
        }

        return '';
    }
}
