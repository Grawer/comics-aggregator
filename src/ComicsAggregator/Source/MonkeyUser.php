<?php

namespace Grawer\ComicsAggregator\Source;

class MonkeyUser extends Base
{
    private $baseUrl = 'https://www.monkeyuser.com/';

    private function getImageUrlPart()
    {
        $this->homepage = file_get_contents($this->baseUrl, false, stream_context_create($this->options));

        preg_match(
            '!<div class=comic>.*?<p><img src=(.*?) !sm',
            $this->homepage,
            $matches
        );

        if (!isset($matches[1])) {
            return false;
        }

        $url = $matches[1];

        return $url;
    }

    public function getLatestComicImageUrl()
    {
        return $this->baseUrl . $this->getImageUrlPart();
    }

    public function getTitle()
    {
        $url = $this->getImageUrlPart();

        preg_match(
            '!<div class=comic>.*?<p><img src=' . $url . ' alt="(.*?)"!sm',
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
        $url = $this->getImageUrlPart();

        preg_match(
            '!<div class=comic>.*?<p><img src=' . $url . '.*? title="(.*?)"!sm',
            $this->homepage,
            $matches
        );

        if (isset($matches[1])) {
            return $matches[1];
        }

        return '';
    }
}
