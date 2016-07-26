<?php

namespace DrezynSoft\SplitImage;

class FilesData
{
    private $width;
    private $height;
    private $leftRightMargin;
    private $topBottomMargin;
    private $sep;
    private $ramFactor;
    private $configs = array(
        'width' => 'width',
        'height' => 'height',
        'left-right-margin' => 'leftRightMargin',
        'top-bottom-margin' => 'topBottomMargin',
        'sep' => 'sep',
        'RAM-factor' => 'ramFactor',
    );
    private $orygWidth;
    private $orygHeight;
    private $memory;
    private $filename;

    public function __construct($filename, $config = array())
    {
        $this->filename = $filename;
        $this->setConfig($config);
    }

    private function setConfig(array $config)
    {
        foreach ($this->configs as $conf => $prop) {
            if (isset($config[$conf])) {
                $this->{$prop} = $config[$conf];
            }
        }
    }

    private function prepare()
    {
        if (file_exists($this->filename)) {
            $data = getimagesize($this->filename);
            $this->orygWidth = $data[0];
            $this->orygHeight = $data[1];
            $this->memory = round($this->orygWidth * $this->orygHeight * 3 / 1024 / 1024 * $this->ramFactor);
        } else {
            throw new SplitImageException('File ['.$this->filename.'] not found.');
        }
    }

    public function get()
    {
        $this->prepare();
        if ($this->orygWidth !== null && $this->orygHeight !== null) {
            return array(
                'pages' => $this->getPages(),
                'memory' => $this->memory,
            );
        }
        return array();
    }

    private function getPages()
    {
        $allPages = new Pages(
            new OneDimension($this->orygWidth, $this->leftRightMargin, $this->width),
            new OneDimension($this->orygHeight, $this->topBottomMargin, $this->height),
            $this->sep
        );
        return $allPages->get();
    }
}
