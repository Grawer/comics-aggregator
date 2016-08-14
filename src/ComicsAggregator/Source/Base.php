<?php

namespace Grawer\ComicsAggregator\Source;

abstract class Base
{
    abstract public function getLatestComicImageUrl();

    public function getTitle()
    {
        return '';
    }

    public function getDescription()
    {
        return '';
    }

    protected function checkComicUrlExists($url)
    {
        $curl = curl_init();

        $options = array(
            CURLOPT_URL             => $url,
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_SSL_VERIFYPEER  => false,
            CURLOPT_NOBODY          => true,
        );

        curl_setopt_array($curl, $options);
        curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($httpCode == 200) {
            return true;
        }

        return false;
    }
}
