<?php

namespace Grawer\ComicsAggregator\Source;

class AndrzejRysuje extends Base
{
    protected $homepage;
    protected $json;

    public function getLatestComicImageUrl()
    {
        $this->homepage = file_get_contents('http://www.andrzejrysuje.pl/wordpress/wp-json/wp/v2/posts?page=1');
        $this->homepage = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $this->homepage);
        $this->json = json_decode($this->homepage, true);

        $url = false;
        if (isset($this->json[0]['post_attachment'])) {
            $url = $this->json[0]['post_attachment'];
        }

        return $url;
    }

    public function getTitle()
    {
        if (empty($this->homepage)) {
            $this->getLatestComicImageUrl();
        }

        $title = '';
        if (isset($this->json[0]['title']['rendered'])) {
            $title = $this->json[0]['title']['rendered'];
        }

        return $title;
    }
}
