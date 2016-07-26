<?php

namespace DrezynSoft\SplitImage;

class ConsoleOptionValidatorData
{
    public static function get()
    {
        return array(
            'source-file' => 'string',
            'destination-dir' => 'string',
            'width' => array('int', function ($config, $val) {
                return ($val > 0);
            }, 'Width can not be smaller then 0.'),
            'height' => array('int', function ($config, $val) {
                return ($val > 0);
            }, 'Height can not be smaller then 0.'),
            'left-right-margin' => array('int', function ($config, $val) {
                return ($val + 1 < $config['width']);
            }, 'Width can not be smaller then left-right-margin.'),
            'top-bottom-margin' => array('int', function ($config, $val) {
                return ($val + 1 < $config['height']);
            }, 'Height can not be smaller then top-bottom-margin.'),
            'sep' => 'string',
            'default-dir' => 'string',
            'prefix' => 'string',
            'suffix' => 'string',
            'RAM-factor' => array('float', function ($config, $val) {
                return ($val > 0);
            }, 'RAM Factor can only by grater then 0.'),
            'compression' => array('int', function ($config, $val) {
                return ($val >= 0 && $val <= 9);
            }, 'Compression of PNG file must be in range 0-9.'),
        );
    }
}
