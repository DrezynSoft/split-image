<?php

namespace DrezynSoft\SplitImage;

class OneDimension
{
    private $oryg;
    private $margin;
    private $size;

    public function __construct($oryg, $margin, $size)
    {
        $this->oryg = $oryg;
        $this->margin = $margin;
        $this->size = $size;
    }

    public function get()
    {
        $sizes = array();
        $current = 0;
        while ($current < $this->oryg) {
            $size = $this->getOnSize($current);
            $sizes[] = $size;
            $current = $size['end'];
        }
        if ($current > $this->oryg) {
            $sizes[] = $this->getOnSize($current);
        }
        return $sizes;
    }

    private function getOnSize($size)
    {
        return array(
            'start' => $this->getStart($size),
            'end' => $this->getEnd($size),
        );
    }

    private function getStart($size)
    {
        if ($size == 0) {
            return $size;
        }
        $result = $size - $this->margin;
        if ($result > $this->oryg) {
            return $this->oryg;
        }
        return $result;
    }

    private function getEnd($size)
    {
        if ($size == 0) {
            $result = $this->size;
        } else {
            $result = $size - $this->margin + $this->size;
        }
        if ($result > $this->oryg) {
            return $this->oryg;
        }
        return $result;
    }
}
