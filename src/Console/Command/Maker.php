<?php
/**
 * The file contains Maker trait
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
 * Maker Trait for Cherry Console.
 *
 * @category Library
 * @package  Cherry
 * @author   Temuri Takalandze <takalandzet@gmail.com>
 * @license  https://github.com/cherry-framework/console/blob/master/LICENSE MIT
 * @link     https://github.com/cherry-framework/console
 */
trait Maker
{
    private $_templatesPath = __DIR__.'/Maker/Templates';

    /**
     * Run Cherry Features maker.
     *
     * @param ArgvInput $input  CLI Input interface
     * @param Output    $output CLI Output interface
     *
     * @return void
     */
    private function _make(ArgvInput $input, Output $output)
    {
        $argv = $input->getArgv();

        if ($input->getArgvCount() == 1) {
            $this->_makeHelp($output);
        } else {
            $this->_callMakerMethod($argv[1], $input, $output);
        }
    }

    /**
     * Call maker by argument.
     *
     * @param string    $method Method for calling
     * @param ArgvInput $input  CLI Input interface
     * @param Output    $output CLI Output interface
     *
     * @return void
     */
    private function _callMakerMethod($method, ArgvInput $input, Output $output)
    {
        $method = '_make'.ucfirst($method);

        if (method_exists($this, $method)) {
            $this->{$method}($input, $output);
        } else {
            $this->_makeHelp($output);
        }
    }

    /**
     * Get Maker help
     *
     * @param Output $output CLI Output interface
     *
     * @return void
     */
    private function _makeHelp(Output $output)
    {
        $help = file_get_contents(__DIR__.'/Maker/Docs/help.txt');
        print $output->text($help);
    }

    /**
     * Make new Cherry Controller.
     *
     * @param ArgvInput $input  CLI Input interface
     * @param Output    $output CLI Output interface
     *
     * @return void
     */
    private function _makeController(ArgvInput $input, Output $output)
    {
        print $output->success('Make Controller.')."\n";
        print $output->text('Enter Controller Name [hello]:');

        //Get controller name from stdin
        $controllerTitle = readline() ?: 'hello';

        // Remove spaces
        $controllerTitle = trim($controllerTitle);

        // If empty, set default value
        $controllerTitle = $controllerTitle == '' ? 'hello' : $controllerTitle;

        // Generate Controller name
        $controllerName = ucfirst($controllerTitle).'Controller';

        // Check if controller exists
        if (file_exists(CONTROLLERS_PATH.'/'.$controllerName.'.php')) {
            print "\n".$output
                    ->warning("Controller {$controllerTitle} already exists!");
        } else {
            $templatesPath = $this->_templatesPath . '/Controller/';

            // Get templates
            $controllerTemplate = file_get_contents(
                $templatesPath . '/controller.txt'
            );
            $templateTemplate = file_get_contents($templatesPath . '/template.txt');

            // Replace controller name in templates
            $controllerTemplate = str_replace(
                ['{controllerName}', '{controllerTitle}'],
                [$controllerName, $controllerTitle],
                $controllerTemplate
            );
            $templateTemplate = str_replace(
                '{controllerName}',
                $controllerName,
                $templateTemplate
            );

            // Create directories if they not found
            if (!file_exists(CONTROLLERS_PATH)) {
                mkdir(CONTROLLERS_PATH, 0755, true);
            }
            if (!file_exists(TEMPLATES_PATH . '/' . $controllerTitle)) {
                mkdir(TEMPLATES_PATH . '/' . $controllerTitle, 0755, true);
            }

            // Write to files
            file_put_contents(
                CONTROLLERS_PATH . '/' . $controllerName . '.php',
                $controllerTemplate
            );
            file_put_contents(
                TEMPLATES_PATH . '/' . $controllerTitle . '/index.templater.php',
                $templateTemplate
            );

            // Add route for new controller

            // Get old routes
            $routes = file_get_contents(ROUTES_FILE);
            $routes = json_decode($routes, 1);

            // Add new route
            $routes[$controllerTitle] = array(
                'path' => '/' . $controllerTitle,
                'method' => 'GET',
                'action' => $controllerName . '::hello'
            );

            // Save routes
            file_put_contents(
                ROUTES_FILE,
                json_encode($routes, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
            );

            print "\n" . $output
                    ->success("Controller {$controllerTitle} created successfully!");
        }
    }
}
