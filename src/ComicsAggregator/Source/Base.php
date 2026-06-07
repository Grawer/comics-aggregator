<?php

namespace Grawer\ComicsAggregator\Source;

abstract class Base
{
    protected $homepage;

    abstract public function getLatestComicImageUrl();

    public $options = array(
        'ssl' => array(
            'verify_peer'       => false,
            'verify_peer_name'  => false,
        ),
    );

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
            CURLOPT_HTTPHEADER      => [
                "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36",
                "Accept-Language: pl-PL,pl;q=0.9,en-GB;q=0.8,en;q=0.7,pl-SP;q=0.6,en-US;q=0.5",
            ]
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
