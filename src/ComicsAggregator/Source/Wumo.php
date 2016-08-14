<?php

namespace Grawer\ComicsAggregator\Source;

class Wumo extends Base
{
    protected $homepage;

    public function getLatestComicImageUrl()
    {
        $this->homepage = file_get_contents('http://wumo.com/wumo');

        preg_match(
            '!strip box box-normal.*?<img src="(.*?)"!',
            $this->homepage,
            $matches
        );

        if (isset($matches[1])) {
            $url = 'http://wumo.com/' . $matches[1];

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
            '!strip box box-normal.*?<img src=".*?".*?alt="(.*?)"!',
            $this->homepage,
            $matches
        );

        if (isset($matches[1])) {
            return $matches[1];
        }

        return '';
    }
}
