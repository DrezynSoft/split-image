<?php

namespace DrezynSoft\SplitImage;

class SplitImage extends AbstractSplitImage
{
    public function split()
    {
        $data = $this->getSplitData();
        if (!empty($data)) {
            $this->setMemoryLimit($data['memory']);
            $this->openImage();
            $this->generateSplitFiles($data['pages']);
        }
    }

    private function generateSplitFiles($pages)
    {
        foreach ($pages as $p) {
            $this->generateSplitFile($p);
        }
        return $this->getMemoryUsage();
    }
}
