<?php

namespace Cherry\Console;

class ArgvInput
{
    private $_argv;

    public function __construct()
    {
        $argv = $_SERVER['argv'];

        // Strip the application name
        array_shift($argv);

        $this->_argv = $argv;
    }

    public function getArgv()
    {
        return $this->_argv;
    }
}