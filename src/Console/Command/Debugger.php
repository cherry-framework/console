<?php
/**
 * The file contains Debugger trait
 *
 * PHP version 5
 *
 * @category Library
 * @package  Cherry
 * @author   Temuri Takalandze <takalandzet@gmail.com>
 * @license  https://github.com/cherry-framework/console/blob/master/LICENSE MIT
 * @link     https://github.com/cherry-framework/console
 */

namespace Cherry\Console\Command;

use Cherry\Console\Input\ArgvInput;
use Cherry\Console\Output\Output;

/**
 * Debugger Trait for Cherry Console.
 *
 * @category Library
 * @package  Cherry
 * @author   Temuri Takalandze <takalandzet@gmail.com>
 * @license  https://github.com/cherry-framework/console/blob/master/LICENSE MIT
 * @link     https://github.com/cherry-framework/console
 */
trait Debugger
{
    /**
     * Run Cherry Features debugger.
     *
     * @param ArgvInput $input  CLI Input interface
     * @param Output    $output CLI Output interface
     *
     * @return void
     */
    private function _debug(ArgvInput $input, Output $output)
    {
        $argv = $input->getArgv();

        if ($input->getArgvCount() == 1) {
            $this->_debugHelp($output);
        } else {
            $this->_callDebuggerMethod($argv[1], $input, $output);
        }
    }

    /**
     * Call debugger by argument.
     *
     * @param string    $method Method for calling
     * @param ArgvInput $input  CLI Input interface
     * @param Output    $output CLI Output interface
     *
     * @return void
     */
    private function _callDebuggerMethod($method, ArgvInput $input, Output $output)
    {
        $method = '_debug'.ucfirst($method);

        if (method_exists($this, $method)) {
            $this->{$method}($input, $output);
        } else {
            $this->_debugHelp($output);
        }
    }

    /**
     * Get Debugger help
     *
     * @param Output $output CLI Output interface
     *
     * @return void
     */
    private function _debugHelp(Output $output)
    {
        $help = file_get_contents(__DIR__.'/Debugger/Docs/help.txt');
        print $output->text($help);
    }

    /**
     * Debug Cherry Router.
     *
     * @param ArgvInput $input  CLI Input interface
     * @param Output    $output CLI Output interface
     *
     * @return void
     */
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
