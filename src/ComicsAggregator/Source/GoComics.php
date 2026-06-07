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

        $curl = curl_init();

        $options = array(
            CURLOPT_URL             => $url,
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_SSL_VERIFYPEER  => false,
            CURLOPT_HTTPHEADER      => [
                "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36",
                "Accept-Language: pl-PL,pl;q=0.9,en-GB;q=0.8,en;q=0.7,pl-SP;q=0.6,en-US;q=0.5",
            ]
        );

        curl_setopt_array($curl, $options);
        $this->homepage = curl_exec($curl);
        curl_close($curl);

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
