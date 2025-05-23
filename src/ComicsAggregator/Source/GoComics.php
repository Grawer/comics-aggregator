<?php

namespace Grawer\ComicsAggregator\Source;

abstract class GoComics extends Base
{
    protected $homepage;

    abstract protected function getCommicName();

    public function getLatestComicImageUrl()
    {
        $url = $this->getTodaysComicUrl();
        $isPresent = $this->checkComicUrlExists($url);

        if (!$isPresent) {
            return false;
        }

        $this->homepage = file_get_contents($url, false, stream_context_create($this->options));

        preg_match(
            '/(https:\/\/featureassets\.gocomics\.com\/assets\/[a-z0-9]+)/ms',
            $this->homepage,
            $matches
        );

        if (isset($matches[1])) {
            $url = $matches[1];

            return $url;
        }

        return false;
    }

    protected function getTodaysComicUrl()
    {
        $url = 'https://www.gocomics.com/'
            . $this->getCommicName()
            ;

        return $url;
    }
}
