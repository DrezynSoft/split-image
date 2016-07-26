<?php

namespace DrezynSoft\SplitImage;

class OneDimensionPages
{
    private $pages;
    private $count;
    private $dimension;

    public function __construct(OneDimension $dimension)
    {
        $this->dimension = $dimension;
    }

    public function get()
    {
        if ($this->pages === null) {
            $this->pages = array();
            $this->calculate();
        }
        return $this->pages;
    }

    private function calculate()
    {
        $this->count = $this->dimension->get();
        $this->digits = floor(log10(count($this->count))) + 1;
        $this->generate();
    }

    private function generate()
    {
        foreach ($this->count as $i => $el) {
            if ($el['end'] - $el['start'] > 0) {
                $this->pages[] = array(
                    'name' => $this->getName($i),
                    'start' => $el['start'],
                    'end' => $el['end'],
                    'length' => $el['end'] - $el['start'],
                );
            }
        }
    }

    private function getName($val)
    {
        $val++;
        if ($val < $this->digits * 10) {
            return sprintf('%0'.$this->digits.'d', $val);
        }
        return $val;
    }
}
