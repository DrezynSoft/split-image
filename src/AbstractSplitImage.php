<?php

namespace DrezynSoft\SplitImage;

abstract class AbstractSplitImage
{
    protected $data;
    protected $filename;
    protected $file;
    protected $config;

    public function __construct($config = array())
    {
        $this->config = $config;
        $this->filename = $this->config['source-file'];
        $this->data = new FilesData($this->filename, $this->config);
    }

    public function getSplitData()
    {
        return $this->data->get();
    }

    protected function setMemoryLimit($limit)
    {
        $ini = ini_set('memory_limit', $limit.'M');
        if ($ini === false) {
            throw new SplitImageException('Max memory limit ['.$limit.'MB] could not by set.');
        }
    }

    protected function openImage()
    {
        $this->file = imagecreatefrompng($this->filename);
        if ($this->file === false) {
            throw new SplitImageException('File ['.$this->filename.'] could not by opened.');
        }
    }

    protected function generateSplitFile($p)
    {
        if (!is_writable($this->getDir())) {
            throw new SplitImageException('Directory ['.$this->getDir().'] is not writable.');
        }
        $destFileName = $this->getPath($this->config['prefix'].$p['name'].$this->config['suffix']);
        $dest = imagecreatetruecolor($p['width'], $p['height']);
        imagecopy($dest, $this->file, 0, 0, $p['x1'], $p['y1'], $p['width'], $p['height']);
        $saved = imagepng($dest, $destFileName, $this->config['compression']);
        if ($saved === false) {
            throw new SplitImageException('File ['.$destFileName.'] has not been written successfully.');
        }
        return $destFileName;
    }

    protected function getPath($name)
    {
        return $this->getDir().$name.'.png';
    }

    private function getDir()
    {
        if (isset($this->config['destination-dir'])) {
            return $this->config['destination-dir'];
        }
        return $this->config['default-dir'];
    }

    protected function getMemoryUsage()
    {
        return round(memory_get_peak_usage(true) / 1024 / 1024 / 1024, 3).'GB';
    }
}
