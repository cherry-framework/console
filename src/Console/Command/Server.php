<?php

namespace Cherry\Console\Command;

trait Server
{
    /**
     * Run PHP Development server from CLI
     *
     * @return void
     */
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

        echo exec("php -S {$server} -t " . WEB_ROOT);
    }
}
