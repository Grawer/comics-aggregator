<?php

namespace Grawer\ComicsAggregator\Source;

class MonkeyUser extends Base
{
    public function getLatestComicImageUrl()
    {
        if (empty($this->homepage)) {
            $this->homepage = file_get_contents('https://www.monkeyuser.com/', false, stream_context_create($this->options));
        }

        preg_match(
            '!<div class="content">.*?<p><img src="(.*?)"!sm',
            $this->homepage,
            $matches
        );

        if (!isset($matches[1])) {
            return false;
        }

        $url = $matches[1];

        return $url;
    }

    public function getTitle()
    {
        $url = $this->getLatestComicImageUrl();

        preg_match(
            '!<div class="content">.*?<p><img src="' . $url . '" alt="(.*?)"!sm',
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
        $url = $this->getLatestComicImageUrl();

        preg_match(
            '!<div class="content">.*?<p><img src="' . $url . '".*? title="(.*?)"!sm',
            $this->homepage,
            $matches
        );

        if (isset($matches[1])) {
            return $matches[1];
        }

        return '';
    }
}
