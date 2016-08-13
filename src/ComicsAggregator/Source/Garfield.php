<?php

namespace Grawer\ComicsAggregator\Source;

class Garfield extends Base
{
    public function getLatestComicImageUrl()
    {
        $url = $this->getTodaysComicUrl();
        $isPresent = $this->checkComicUrlExists($url);

        if ($isPresent) {
            return $url;
        }

        return false;
    }

    protected function getTodaysComicUrl()
    {
        $url = 'http://s3.amazonaws.com/static.garfield.com/comics/garfield/'
            . (new \DateTime())->format('Y')
            . '/'
            . (new \DateTime())->format('Y-m-d')
            . '.gif'
            ;

        return $url;
    }
}
