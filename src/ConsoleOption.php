<?php

namespace DrezynSoft\SplitImage;

class ConsoleOption
{
    private $data;
    private $config = array();
    private $validator;

    public function __construct(array $data, ConsoleOptionValidator $validator)
    {
        $this->validator = $validator;
        $this->validator->setOption($this);
        $this->data = $data;
    }

    public function get()
    {
        return $this->config;
    }

    public function getOption($name, $required = false, $default = null)
    {
        $this->setOption($name, $required, $default);
        $this->validator->check($name, $this->config[$name]);
        return $this;
    }

    public function getMainParam($index, $name, $required = true, $default = null)
    {
        if (isset($this->data[$index]) && strpos($this->data[$index], '--') === false) {
            $this->config[$name] = $this->data[$index];
            return $this;
        }
        if ($required) {
            throw new ConsoleOptionException('Lack of main param ['.$name.'] at index ['.$index.'].');
        }
        $this->config[$name] = $default;
        return $this;
    }

    private function setOption($name, $required, $default)
    {
        $val = $this->parseOption($name);
        if ($val === null && $required) {
            throw new ConsoleOptionException('Option ['.$name.'] does not exists but is required.');
        } elseif ($val !== null) {
            $this->config[$name] = $val;
        } else {
            $this->config[$name] = $default;
        }
    }

    private function parseOption($name)
    {
        $keys = array_keys($this->data, '--'.$name);
        if (!empty($keys) && count($keys) === 1) {
            return $this->parseOneOption(reset($keys));
        }
        return null;
    }

    private function parseOneOption($key)
    {
        $key++;
        if (isset($this->data[$key]) && strpos($this->data[$key], '--') !== 0) {
            return $this->data[$key];
        }
        throw new ConsoleOptionException('Option ['.$this->data[--$key].'] has to be filled.');
    }
}
