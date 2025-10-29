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

        $this->options = array_merge(
            array(
                'http'  =>  array(
                    'method'    =>  'GET',
                    'header'    =>
                        "User-Agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36\r\n"
                )
            ),
            $this->options
        );
        $context = stream_context_create($this->options);
        $this->homepage = file_get_contents($url, false, $context);

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
