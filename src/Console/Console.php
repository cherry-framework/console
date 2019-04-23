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

use Cherry\Console\Command\Debugger;
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
    use Debugger;
    use Server;

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
            $this->{$method}($this->_argvInput, $this->_output);
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
        $help = file_get_contents(__DIR__.'/Files/Docs/help.txt');

        print $this->_output
            ->text($help);
    }
}
