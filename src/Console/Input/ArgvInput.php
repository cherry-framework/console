<?php

namespace Cherry\Console\Input;

class ArgvInput
{
    private $_argv;

    public function __construct($argv = [])
    {
        if (empty($argv)) {
            $argv = $_SERVER['argv'];

            // strip the application name
            array_shift($argv);
        }

        $this->_argv = $argv;
    }

    public function getArgvCount()
    {
        return count($this->_argv);
    }

    public function getArgv()
    {
        return $this->_argv;
    }

    public function getArgvParsed()
    {
        return $this->_parseArgv($this->_argv);
    }

    private function _parseArgv(array $argv)
    {
        $return = array();

        foreach ($argv as $arg) {
            if (substr($arg, 0, 2) == '--') {
                $eqPos = strpos($arg, '=');

                if ($eqPos === false) {
                    $key = substr($arg, 2);
                    $value = isset($return[$key]) ? $return[$key] : true;
                    $return[$key] = $value;
                } else {
                    $key = substr($arg, 2, $eqPos - 2);
                    $value = substr($arg, $eqPos + 1);
                    $return[$key] = $value;
                }
            } else if (substr($arg, 0, 1) == '-') {
                if (substr($arg, 2, 1) == '=') {
                    $key = substr($arg, 1, 1);
                    $value = substr($arg, 3);
                    $return[$key] = $value;
                } else {
                    $chars = str_split(substr($arg, 1));
                    foreach ($chars as $char) {
                        $key = $char;
                        $value = isset($return[$key]) ? $return[$key] : true;
                        $return[$key] = $value;
                    }
                }
            } else {
                $return[] = $arg;
            }
        }

        return $return;
    }

    public function get($key)
    {
        if (isset($this->getArgvParsed()[$key])) {
            return $this->getArgvParsed()[$key];
        }

        return null;
    }

    public function getBoolean($key, $default = false)
    {
        if (!isset($this->getArgvParsed()[$key])) {
            return $default;
        } else {
            $value = $this->getArgvParsed()[$key];

            if (is_bool($value)) {
                return $value;
            } else if (is_int($value)) {
                return (bool)$value;
            } else if (is_string($value)) {
                $value = strtolower($value);

                $map = array(
                    'y' =>     true,
                    'n' =>     false,
                    'yes' =>   true,
                    'no' =>    false,
                    'true' =>  true,
                    'false' => false,
                    '1' =>     true,
                    '0' =>     false,
                    'on' =>    true,
                    'off' =>   false,
                );

                if (isset($map[$value])) {
                    return $map[$value];
                }
            }
        }

        return $default;
    }
}