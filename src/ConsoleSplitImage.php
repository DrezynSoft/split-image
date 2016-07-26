<?php

namespace DrezynSoft\SplitImage;

class ConsoleSplitImage extends AbstractSplitImage
{
    const ACTION_SPLIT = 'split';
    private $console;

    public function __construct($config, ConsoleOutput $console)
    {
        if ($config['action'] !== self::ACTION_SPLIT) {
            throw new SplitImageException('Action to take has been not recognized. Should be ['.self::ACTION_SPLIT.'], ['.$config['action'].'] given.');
        }
        parent::__construct($config);
        $this->console = $console;
    }

    public function split()
    {
        $this->console->writeln('Conversion process started...');
        $data = $this->getSplitData();
        if (!empty($data)) {
            $this->setMemoryLimit($data['memory']);
            $this->openImage();
            $this->generateSplitFiles($data['pages']);
        }
    }

    protected function setMemoryLimit($limit)
    {
        parent::setMemoryLimit($limit);
        $this->console->writeln('Memory limit has been set successfully to ['.$limit.'MB].');
    }

    protected function openImage()
    {
        parent::openImage();
        $this->console->writeln('Source file has been opened.');
    }

    private function generateSplitFiles($pages)
    {
        $this->console->writeln('Conversion has been started.');
        $totalSize = 0;
        foreach ($pages as $i => $p) {
            try {
                $file = $this->generateSplitFile($p);
                $fileSize = $this->getFileSize($file);
                $totalSize += $fileSize;
                $this->console->writeln($file.' converted successfully ('.$fileSize.'MB).');
            } catch (SplitImageException $ex) {
                $this->console->warning($ex->getMessage());
            }
        }
        $this->console->writeln('Conversion done ('.++$i.' files, '.$totalSize.'MB).');
        $this->console->writeln('Memory used: '.$this->getMemoryUsage().'.');
    }

    private function getFileSize($file)
    {
        if (file_exists($file)) {
            return round(filesize($file) / 1024 / 1024, 3);
        }
        throw new SplitImageException('Created file ['.$file.'] does not exist.');
    }

    public function getSplitData()
    {
        $ret = parent::getSplitData();
        $this->console->writeln('Necessary data calculated.');
        return $ret;
    }
}
