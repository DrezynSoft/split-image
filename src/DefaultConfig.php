<?php

namespace DrezynSoft\SplitImage;

class DefaultConfig
{
    const CONFIG_FILE = 'config/config.php';
    private static $config;

    public function get($key = null)
    {
        if (self::$config === null) {
            self::$config = $this->getFromFile();
        }
        if (isset(self::$config[$key])) {
            return self::$config[$key];
        }
        return self::$config;
    }

    private function getFromFile()
    {
        if (file_exists(self::CONFIG_FILE)) {
            return require self::CONFIG_FILE;
        }
        throw new SplitImageException('Default configuration file ['.self::CONFIG_FILE.'] not found.');
    }
}
