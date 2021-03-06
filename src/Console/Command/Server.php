<?php
/**
 * The file contains Server trait
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
 * Server Trait for Cherry Console.
 *
 * @category Library
 * @package  Cherry
 * @author   Temuri Takalandze <takalandzet@gmail.com>
 * @license  https://github.com/cherry-framework/console/blob/master/LICENSE MIT
 * @link     https://github.com/cherry-framework/console
 */
trait Server
{
    /**
     * Run PHP Development server from CLI
     *
     * @param ArgvInput $input  CLI Input interface
     * @param Output    $output CLI Output interface
     *
     * @return void
     */
    private function _server(ArgvInput $input, Output $output)
    {
        $argv = $input->getArgv();

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
        
{$output->success("Started Cherry Server on  http://{$server}")}
// Quit the server with Ctrl + C.
EOF;

        print $output->text($info);

        echo exec("php -S {$server} -t " . WEB_ROOT);
    }
}
