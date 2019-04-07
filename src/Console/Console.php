<?php

namespace Cherry\Console;

use Cherry\Console\Input\ArgvInput;
use Cherry\Console\Output\Output;

class Console
{
    private $_argvInput;
    private $_output;

    private $_argv;
    private $_argvParsed;

    public function __construct()
    {
        $this->_argvInput = new ArgvInput();
        $this->_output = new Output();

        $this->_argv = $this->_argvInput->getArgv();
        $this->_argvParsed = $this->_argvInput->getArgvParsed();

        $this->_run();
    }

    private function _run()
    {
        $argvInput = $this->_argvInput;

        $argv = $this->_argv;

        if ($argvInput->getArgvCount() == 0 ||
            $argvInput->getBoolean('help') ||
            $argvInput->getBoolean('h')
        ) {
            $this->_printHelp();
            return;
        }

        $this->_call($argv[0]);
    }

    private function _call($method)
    {
        $method = "_{$method}";

        if (method_exists($this, $method)) {
            $this->{$method}();
        } else {
            $this->_printHelp();
        }
    }

    private function _printHelp()
    {
        $hello = <<<EOF
Welcome to
  ____ _                          
 / ___| |__   ___ _ __ _ __ _   _ 
| |   | '_ \ / _ \ '__| '__| | | |
| |___| | | |  __/ |  | |  | |_| |
 \____|_| |_|\___|_|  |_|   \__, |
                            |___/
                            
                          Console
----------------------------------

help, --help, -h            - Show help.
    
server [option] [arguments] - Start PHP Development server.
       [option]   - Server start options
            run     - Start server on 127.0.0.1:8000
            start   - Start server on given address:port
       [argument] - Additional arguments for option "start" address:port (127.0.0.1:8000)
            
EOF;

        print $this->_output
            ->text($hello);
    }

    private function _server()
    {
        $argv = $this->_argv;

        $server = null;

        if (isset($argv[1]) && $argv[1] == 'run') {
            $server = "127.0.0.1:8000";
        } else if (isset($argv[1]) && $argv[1] == 'start') {
            if (isset($argv[2])) {
                $server = $argv[2];
            } else {
                $this->_printHelp();
                return;
            }
        } else {
            $this->_printHelp();
            return;
        }

        $info = <<<EOF
        
{$this->_output->success("Started Cherry Server on  http://{$server}")}
// Quit the server with Ctrl + C.
EOF;

        print $this->_output
            ->text($info);

        echo exec("php -S {$server} -t " . dirname(dirname(__DIR__)));
    }
}