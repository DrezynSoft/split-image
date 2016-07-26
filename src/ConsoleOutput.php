<?php

namespace DrezynSoft\SplitImage;

class ConsoleOutput
{
    protected static $inst;
    const START = 'SplitImage by DrezynSoft v1.0.0';

    public static function instance()
    {
        if (self::$inst === null) {
            self::$inst = new ConsoleOutput();
        }
        return self::$inst;
    }

    public function writeln($info)
    {
        echo $info."\n";
    }

    public function error($info)
    {
        echo "\n";
        echo 'Fatal Error!'."\n";
        echo $info."\n";
        echo "End of execution :(\n";
    }

    public function warning($info)
    {
        echo 'Warning!'."\n";
        echo $info."\n";
    }
}
