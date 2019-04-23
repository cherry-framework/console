<?php

namespace Cherry\Console\Command;

use Cherry\Console\Input\ArgvInput;
use Cherry\Console\Output\Output;

trait Debugger
{
    private function _debug(ArgvInput $input, Output $output)
    {
        $argv = $input->getArgv();

        if ($input->getArgvCount() == 1) {
            $this->_debugHelp($output);
        } else {
            $this->_callDebuggerMethod($argv[1], $input, $output);
        }
    }

    private function _callDebuggerMethod($method, ArgvInput $input, Output $output)
    {
        $method = '_debug'.ucfirst($method);

        if (method_exists($this, $method)) {
            $this->{$method}($input, $output);
        } else {
            $this->_debugHelp($output);
        }
    }

    private function _debugHelp(Output $output)
    {
        $help = <<<EOF
Cherry Debugger.

run ./console debug {argument} for debugging {argument} feature.

{argument} values:

    router - Debug application all route.
          
EOF;

        print $output->text($help);
    }

    private function _debugRouter(ArgvInput $input, Output $output)
    {
        echo $output->success('Cherry Router Debugger')."\n\n";

        $routes = @file_get_contents(ROUTES_FILE);
        $routes = json_decode($routes, 1);

        foreach ($routes as $k => $v) {
            $desc = '';
            foreach ($v as $k2 => $v2) {
                $desc .= <<<EOF
    {$k2} - {$v2}

EOF;
            }

            $full = <<<EOF
{$output->info($k.':')}
{$desc}
EOF;

            echo $output->text($full);
        }
    }
}
