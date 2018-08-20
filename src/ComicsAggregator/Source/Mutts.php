<?php

namespace Grawer\ComicsAggregator\Source;

class Mutts extends Base
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
        $url = 'https://mutts.com/wp-content/uploads/'
            . (new \DateTime())->format('Y')
            . '/'
            . (new \DateTime())->format('m')
            . '/'
            . (new \DateTime())->format('mdy')
            . '.gif'
            ;

        return $url;
    }
}
