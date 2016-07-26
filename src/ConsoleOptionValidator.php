<?php

namespace DrezynSoft\SplitImage;

class ConsoleOptionValidator
{
    private $data;
    private $val;
    private $key;
    private $condition;
    private $option;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function setOption(ConsoleOption $option)
    {
        $this->option = $option;
    }

    public function check($key, $val)
    {
        if (isset($this->data[$key])) {
            $this->key = $key;
            $this->condition = $this->parseCondition($key);
            $this->val = $val;
            return $this->doCheck();
        }
        return true;
    }

    private function parseCondition($key)
    {
        if (is_array($this->data[$key])) {
            if (isset($this->data[$key][0])) {
                $toCheck = $this->data[$key][0];
            }
            if (isset($this->data[$key][1])) {
                $callback = $this->data[$key][1];
            }
            if (isset($this->data[$key][2])) {
                $msg = $this->data[$key][2];
            }
        } else {
            $toCheck = $this->data[$key];
        }
        return compact('toCheck', 'callback', 'msg');
    }

    private function doCheck()
    {
        $toCheck = $this->getConditionParam('toCheck', '');
        switch ($toCheck) {
            case 'int':
                return $this->checkInt();
            case 'string':
                return $this->checkString();
            case 'float':
                return $this->checkFloat();
            default :
                throw new ConsoleOptionException('Type of check ['.$toCheck.'] not recognized.');
        }
    }

    private function checkFilter($filter, $info)
    {
        return $this->executeCallback(
            filter_var($this->val, $filter) !== false,
            sprintf($info, $this->key)
        );
    }

    private function checkInt()
    {
        return $this->checkFilter(FILTER_VALIDATE_INT, 'The param [%s] should be the int.');
    }

    private function checkString()
    {
        return $this->checkFilter(FILTER_UNSAFE_RAW, 'The param [%s] should be the string.');
    }

    private function checkFloat()
    {
        return $this->checkFilter(FILTER_VALIDATE_FLOAT, 'The param [%s] should be the float.');
    }

    private function executeCallback($check, $info)
    {
        if ($check) {
            $callback = $this->getConditionParam('callback', $this->getDefaultCallback());
            if ($callback($this->option->get(), $this->val)) {
                return true;
            }
            throw new ConsoleOptionException($this->getConditionParam('msg', $info));
        }
        throw new ConsoleOptionException($info);
    }

    private function getDefaultCallback()
    {
        return function ($config, $val) {
            return true;
        };
    }

    private function getConditionParam($key, $default)
    {
        if (isset($this->condition[$key])) {
            return $this->condition[$key];
        }
        return $default;
    }
}
