<?php

namespace Grawer\ComicsAggregator\Source;

class Mutts extends Base
{
    public function getLatestComicImageUrl()
    {
        $opts = array(
            'http'  =>  array(
                'method'    =>  'GET',
                'header'    =>
                    "Accept-language: en\r\n"
                    . "User-Agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36\r\n"
            )
        );
        $context = stream_context_create($opts);
        $this->homepage = file_get_contents('https://mutts.com/', false, $context);

        preg_match(
            '!<div class="daily-callout-product-image">.*?<img src="(.*?)".*?/>!sm',
            $this->homepage,
            $matches
        );

        if (isset($matches[1])) {
            $url = $matches[1];

            return $url;
        }

        return false;
    }
}
