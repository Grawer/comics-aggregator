<?php

namespace Grawer\ComicsAggregator\Source;

use SimpleXMLElement;

class WheresMyBubble extends Base
{
    protected $homepage;

    public function getLatestComicImageUrl()
    {
        $opts = array(
            'http'  =>  array(
                'method'    =>  'GET',
                'header'    =>
                    "Accept-language: en\r\n"
                    . "User-Agent:\"curl/7.38.0\"\r\n"
            )
        );

        $context = stream_context_create($opts);
        $this->homepage = file_get_contents('http://wheresmybubble.tumblr.com/rss', false, $context);

        $xml = simplexml_load_string($this->homepage);
        $json = json_encode($xml);
        $content = json_decode($json,TRUE);

        $firstItem = reset($content['channel']['item']);

        if (!isset($firstItem['description'])) {
            return false;
        }

        $description = $firstItem['description'];

        preg_match(
            '!<img.*?src="(.*?)"!sm',
            $description,
            $matches
        );

        if (!isset($matches[1])) {
            return false;
        }

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

        $xml = simplexml_load_string($this->homepage);
        $json = json_encode($xml);
        $content = json_decode($json,TRUE);

        $firstItem = reset($content['channel']['item']);

        if (isset($firstItem['title'])) {
            return trim($firstItem['title']);
        }

        return '';
    }

    public function getDescription()
    {
        if (empty($this->homepage)) {
            $this->getLatestComicImageUrl();
        }

        $xml = simplexml_load_string($this->homepage);
        $json = json_encode($xml);
        $content = json_decode($json,TRUE);

        $firstItem = reset($content['channel']['item']);

        if (!isset($firstItem['description'])) {
            return false;
        }

        $description = $firstItem['description'];

        preg_match(
            '!<p>(.*?)</p>!sm',
            $description,
            $matches
        );

        if (!isset($matches[1])) {
            return false;
        }

        if (isset($matches[1])) {
            $description = $matches[1];

            return $description;
        }

        return '';
    }
}
