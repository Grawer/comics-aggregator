<?php

namespace Grawer\ComicsAggregator\Source;

class MonkeyUser extends Base
{
    public function getLatestComicImageUrl()
    {
        $this->homepage = file_get_contents('https://www.monkeyuser.com/');

        preg_match(
            '!<meta property="og:image" content="(.*?)"!sm',
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
        $url = $this->getLatestComicImageUrl();

        preg_match(
            '!<p><img src="' . $url . '" alt="(.*?)"!sm',
            $this->homepage,
            $matches
        );

        if (isset($matches[1])) {
            return $matches[1];
        }

        return '';
    }
}
