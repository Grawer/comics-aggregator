<?php

namespace Grawer\ComicsAggregator\Source;

use SimpleXMLElement;

class WhoSaidICanAdult extends Base
{
    protected $homepage;

    public function getLatestComicImageUrl()
    {
        // $this->homepage = file_get_contents('https://tapas.io/series/Who-Said-I-Can-Adult');

$this->homepage = file_get_contents('source.html');

        preg_match_all(
            '!<img class="art-image".*?src="(.*?)"!sm',
            $this->homepage,
            $matches
        );

        if (isset($matches[1])) {
            return $matches[1];
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
            '!\<h1 class="title".*?>(.*?)<\/h1\>!sm',
            $this->homepage,
            $matches
        );

        if (isset($matches[1])) {
            return $matches[1];
        }

        return '';
    }
}
