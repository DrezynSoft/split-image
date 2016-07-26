<?php

namespace DrezynSoft\SplitImage;

class ConsoleConfig
{
    const MAIN_PARAM_ACTION = 1;
    const MAIN_PARAM_SOURCE = 2;
    const MAIN_PARAM_DESTINATION = 3;
    private $config;
    private $default;

    public function __construct(ConsoleOption $parser, DefaultConfig $default)
    {
        $this->parser = $parser;
        $this->default = $default;
    }

    public function get()
    {
        if (empty($this->config)) {
            $this->parse();
            $this->config = $this->parser->get();
        }
        return $this->config;
    }

    private function parse()
    {
        $this->parser->
            getMainParam(self::MAIN_PARAM_ACTION, 'action')->
            getMainParam(self::MAIN_PARAM_SOURCE, 'source-file', false, $this->default->get('default-file'))->
            getMainParam(self::MAIN_PARAM_DESTINATION, 'destination-dir', false, $this->default->get('default-dir'));

        foreach ($this->default->get() as $key => $val) {
            $this->parser->getOption($key, false, $val);
        }
    }
}
