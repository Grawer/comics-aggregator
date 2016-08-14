<?php

namespace Grawer\ComicsAggregator\Helper;

class Configuration
{
    public static $config;

    public function __construct()
    {
        self::$config = json_decode(file_get_contents('config.json'), true);
    }

    public static function get($propertyName)
    {
        foreach (self::$config as $key => $value) {
            if ($key == $propertyName) {
                return $value;
            }
        }

        return null;
    }
}
