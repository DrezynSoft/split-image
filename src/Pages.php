<?php

namespace DrezynSoft\SplitImage;

class Pages
{
    private $pages;
    private $rows;
    private $cols;
    private $sep;

    public function __construct(OneDimension $rows, OneDimension $cols, $sep)
    {
        $rowPages = new OneDimensionPages($rows);
        $this->rows = $rowPages->get();
        $colPages = new OneDimensionPages($cols);
        $this->cols = $colPages->get();
        $this->sep = $sep;
    }

    public function get()
    {
        if ($this->pages === null) {
            $this->pages = array();
            $this->generate();
        }
        return $this->pages;
    }

    private function generate()
    {
        foreach ($this->cols as $c => $col) {
            foreach ($this->rows as $r => $row) {
                $this->pages[] = array(
                    'name' => $this->getName($col['name'], $row['name']),
                    'x1' => $row['start'],
                    'x2' => $row['end'],
                    'y1' => $col['start'],
                    'y2' => $col['end'],
                    'width' => $row['length'],
                    'height' => $col['length'],
                );
            }
        }
    }

    private function getName($col, $row)
    {
        return $col.$this->sep.$row;
    }
}
