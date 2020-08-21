<?php

namespace Grawer\ComicsAggregator\Source;

class Garfield extends Base
{
    public function getLatestComicImageUrl()
    {
        $url = $this->getTodaysComicUrl();
        $isPresent = $this->checkComicUrlExists($url);

        if (!$isPresent) {
            return false;
        }

        $this->homepage = file_get_contents($url, false);

        preg_match(
            '!<meta property="og.image" content="(.*?)".?/>!sm',
            $this->homepage,
            $matches
        );

        if (isset($matches[1])) {
            $url = $matches[1];

            return $url . '.gif';
        }

        return false;
    }

    protected function getTodaysComicUrl()
    {
        $url = 'https://www.gocomics.com/garfield/'
            . (new \DateTime())->format('Y/m/d')
            ;

        return $url;
    }
}
