<?php

namespace Grawer\ComicsAggregator\Source;

class PhdComics extends Base
{
    protected $homepage;

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

        $this->homepage = file_get_contents('http://phdcomics.com/comics.php', false, $context);

        preg_match(
            '!<meta property="og.image" content="(.*?)"/>!sm',
            $this->homepage,
            $matches
        );

        if (isset($matches[1])) {
            $url = $matches[1];

            return $url;
        }

        return false;
    }

    public function getTitle()
    {
        if (empty($this->homepage)) {
            $this->getLatestComicImageUrl();
        }

        preg_match(
            '!<meta name="twitter:title" content="(.*?)">!sm',
            $this->homepage,
            $matches
        );

        if (isset($matches[1])) {
            return $matches[1];
        }

        return '';
    }

    public function getDescription()
    {
        if (empty($this->homepage)) {
            $this->getLatestComicImageUrl();
        }

        preg_match(
            '!<img id=comic.*?<font face=Arial.*?>(.*?)</font>!sm',
            $this->homepage,
            $matches
        );

        if (isset($matches[1])) {
            $clean = strip_tags($matches[1]);
            $clean = html_entity_decode($clean, ENT_COMPAT | ENT_HTML401, 'UTF-8');

            return $clean;
        }

        return '';
    }
}
