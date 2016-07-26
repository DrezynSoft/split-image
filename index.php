<?php

use DrezynSoft\SplitImage\SplitImage;
use DrezynSoft\SplitImage\DefaultConfig;
use DrezynSoft\SplitImage\SplitImageException;
use DrezynSoft\SplitImage\ConsoleOutput;

{ require 'autoload.php'; }

echo ConsoleOutput::START;
try {
    $config = new DefaultConfig();
    $splitImage = new SplitImage($config->get());
    $splitImage->split();
} catch (SplitImageException $ex) {
    echo $ex->getMessage();
}
echo '<br /><br />End of conversion.';
