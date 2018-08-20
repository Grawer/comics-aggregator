<?php

namespace Grawer\ComicsAggregator\Source;

class GeekAndPoke extends Base
{
    public function getLatestComicImageUrl()
    {
        $opts = array(
            'http'  =>  array(
                'method'    =>  'GET',
                'header'    =>
                    "Accept-language: en\r\n"
                    . "User-Agent:\"Mozilla/5.0 (Windows NT 6.1; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0\"\r\n"
            )
        );

        $context = stream_context_create($opts);

        $this->homepage = file_get_contents('http://geek-and-poke.com/', false, $context);

        preg_match(
            '!<noscript><img src="(.*?)"!sm',
            $this->homepage,
            $matches
        );

        if (!isset($matches[1])) {
            return false;
        }

        $url = $matches[1];

        return $url;
    }

    public function getTitle()
    {
        if (empty($this->homepage)) {
            $this->getLatestComicImageUrl();
        }

        preg_match(
            '!<header>.*?<h1 class="entry-title">.*?<a href="/geekandpoke/.*?">(.*?)</a>!sm',
            $this->homepage,
            $matches
        );

        if (isset($matches[1])) {
            return $matches[1];
        }

        return '';
    }
}
