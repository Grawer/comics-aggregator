<?php

namespace Grawer\ComicsAggregator\Source;

class Mutts extends Base
{
    public function getLatestComicImageUrl()
    {
        $this->options = array_merge(
            array(
                'http'  =>  array(
                    'method'    =>  'GET',
                    'header'    =>
                        "Accept-language: en\r\n"
                        . "User-Agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36\r\n"
                )
            ),
            $this->options
        );
        $context = stream_context_create($this->options);
        $this->homepage = file_get_contents('https://mutts.com/', false, $context);

        preg_match(
            '!<div class="the-daily-mutts-section--inner-img-wrapper">.*?<img src="(.*?)".*?/>!sm',
            $this->homepage,
            $matches
        );

        if (isset($matches[1])) {
            $url = 'http:' . $matches[1];

            return $url;
        }

        return false;
    }
}
