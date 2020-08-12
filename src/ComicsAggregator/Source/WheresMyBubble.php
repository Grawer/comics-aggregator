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
                    . 'Cookie: pfg=012bada80ac349b86bd7e5a5e4457c9941fa3482969eb67b32a09c925c04aad7%23%7B%22eu_resident%22%3A1%2C%22gdpr_is_acceptable_age%22%3A1%2C%22gdpr_consent_core%22%3A1%2C%22gdpr_consent_first_party_ads%22%3A1%2C%22gdpr_consent_third_party_ads%22%3A1%2C%22gdpr_consent_search_history%22%3A1%2C%22exp%22%3A1572543735%2C%22vc%22%3A%22%22%7D%236393324604' . "\r\n",
            )
        );

        $context = stream_context_create($opts);
        $this->homepage = file_get_contents('http://wheresmybubble.tumblr.com/rss', false, $context);


// 14474076e6b02303134de0181db8146d4c96fc805bac01cdf52361d1d4b34a28%23%7B%22eu_resident%22%3A1%2C%22gdpr_is_acceptable_age%22%3A1%2C%22gdpr_consent_core%22%3A1%2C%22gdpr_consent_first_party_ads%22%3A1%2C%22gdpr_consent_third_party_ads%22%3A1%2C%22gdpr_consent_search_history%22%3A1%2C%22exp%22%3A1572543735%2C%22vc%22%3A%22%22%7D%232793346787

// pfg=012bada80ac349b86bd7e5a5e4457c9941fa3482969eb67b32a09c925c04aad7%23%7B%22eu_resident%22%3A1%2C%22gdpr_is_acceptable_age%22%3A1%2C%22gdpr_consent_core%22%3A1%2C%22gdpr_consent_first_party_ads%22%3A1%2C%22gdpr_consent_third_party_ads%22%3A1%2C%22gdpr_consent_search_history%22%3A1%2C%22exp%22%3A1572543735%2C%22vc%22%3A%22%22%7D%236393324604

// 7c3b10bb639d9ff9daec0714379f8f71d583a9626ffe04bf8de40fd4b336c0db#{"eu_resident":1,"gdpr_is_acceptable_age":1,"gdpr_consent_core":1,"gdpr_consent_first_party_ads":1,"gdpr_consent_third_party_ads":1,"gdpr_consent_search_history":1,"exp":1572542930,"vc":""}#4577333227


file_put_contents('source.html', $this->homepage);
$this->homepage = file_get_contents('source.html');

die;
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
