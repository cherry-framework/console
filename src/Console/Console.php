<?php

namespace Cherry\Console;

class Console
{
    private $_argvInput;
    private $_argv;

    public function __construct(ArgvInput $argvInput)
    {
        $this->_argvInput = $argvInput;
        $this->_argv = $argvInput->getArgv();

        var_dump($this->_argv);
    }
}