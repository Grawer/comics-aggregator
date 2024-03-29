<?php

namespace Grawer\ComicsAggregator\Source;

class Dilbert extends Base
{
    protected $homepage;

    public function getLatestComicImageUrl()
    {
        $this->homepage = file_get_contents('http://dilbert.com/', false, stream_context_create($this->options));

        preg_match(
            '!\<img class\=\"img-responsive img-comic\".*?src=\"(.*?)"!',
            $this->homepage,
            $matches
        );

        if (isset($matches[1])) {
            $url = $matches[1];

            $path = parse_url($url, PHP_URL_PATH);
            $basename = basename($path);
            $extension = pathinfo($basename, PATHINFO_EXTENSION);

            if (empty($extension)) {
                $url .= '.jpg';
            }

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
