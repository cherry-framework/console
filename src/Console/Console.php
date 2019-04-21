<?php
/**
 * The file contains Console class
 *
 * PHP version 5
 *
 * @category Library
 * @package  Cherry
 * @author   Temuri Takalandze <takalandzet@gmail.com>
 * @license  https://github.com/cherry-framework/console/blob/master/LICENSE MIT
 * @link     https://github.com/cherry-framework/console
 */

namespace Cherry\Console;

use Cherry\Console\Command\Server;
use Cherry\Console\Input\ArgvInput;
use Cherry\Console\Output\Output;

/**
 * CLI Console for Cherry-project
 *
 * @category Library
 * @package  Cherry
 * @author   Temuri Takalandze <takalandzet@gmail.com>
 * @license  https://github.com/cherry-framework/console/blob/master/LICENSE MIT
 * @link     https://github.com/cherry-framework/console
 */
class Console
{
    use Server;

    /** @var ArgvInput $_argvInput */
    private $_argvInput;
    private $_output;

    private $_argv;
    private $_argvParsed;

    /**
     * Console constructor.
     */
    public function __construct()
    {
        $this->_argvInput = new ArgvInput();
        $this->_output = new Output();

        $this->_argv = $this->_argvInput->getArgv();
        $this->_argvParsed = $this->_argvInput->getArgvParsed();

        $this->_run();
    }

    /**
     * Run the Console.
     *
     * @return void
     */
    private function _run()
    {
        $argvInput = $this->_argvInput;

        $argv = $this->_argv;

        if ($argvInput->getArgvCount() == 0
            || $argvInput->getBoolean('help')
            || $argvInput->getBoolean('h')
        ) {
            $this->_printHelp();
            return;
        }

        //Call action
        $this->_call($argv[0]);
    }

    /**
     * Call method of this class.
     *
     * @param string $method Method name
     *
     * @return void
     */
    private function _call($method)
    {
        $method = "_{$method}";

        if (method_exists($this, $method)) {
            $this->{$method}();
        } else {
            $this->_printHelp();
        }
    }

    /**
     * Print console help message.
     *
     * @return void
     */
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
}
