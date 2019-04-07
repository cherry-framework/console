<?php
/**
 * The file contains CLIColor class
 *
 * PHP version 5
 *
 * @category Library
 * @package  Cherry
 * @author   Temuri Takalandze <takalandzet@gmail.com>
 * @license  https://github.com/cherry-framework/console/blob/master/LICENSE MIT
 * @link     https://github.com/cherry-framework/console
 */

namespace Cherry\Console\Output;

/**
 * Class for colorizing CLI outputs.
 *
 * @category Library
 * @package  Cherry
 * @author   Temuri Takalandze <takalandzet@gmail.com>
 * @license  https://github.com/cherry-framework/console/blob/master/LICENSE MIT
 * @link     https://github.com/cherry-framework/console
 */
class CLIColor
{
    private $_background_colors = array();
    private $_foreground_colors = array();

    /**
     * CLIColor constructor.
     */
    public function __construct()
    {
        $this->_background_colors['black'] = '40';
        $this->_background_colors['red'] = '41';
        $this->_background_colors['green'] = '42';
        $this->_background_colors['yellow'] = '43';
        $this->_background_colors['blue'] = '44';
        $this->_background_colors['magenta'] = '45';
        $this->_background_colors['cyan'] = '46';
        $this->_background_colors['light_gray'] = '47';

        $this->_foreground_colors['black'] = '0;30';
        $this->_foreground_colors['dark_gray'] = '1;30';
        $this->_foreground_colors['blue'] = '0;34';
        $this->_foreground_colors['light_blue'] = '1;34';
        $this->_foreground_colors['green'] = '0;32';
        $this->_foreground_colors['light_green'] = '1;32';
        $this->_foreground_colors['cyan'] = '0;36';
        $this->_foreground_colors['light_cyan'] = '1;36';
        $this->_foreground_colors['red'] = '0;31';
        $this->_foreground_colors['light_red'] = '1;31';
        $this->_foreground_colors['purple'] = '0;35';
        $this->_foreground_colors['light_purple'] = '1;35';
        $this->_foreground_colors['brown'] = '0;33';
        $this->_foreground_colors['yellow'] = '1;33';
        $this->_foreground_colors['light_gray'] = '0;37';
        $this->_foreground_colors['white'] = '1;37';
    }

    /**
     * Colorize string.
     *
     * @param string $string           Text for colorizing.
     * @param string $background_color Background color for string.
     * @param string $foreground_color Foreground color for string.
     *
     * @return string Colorized text.
     */
    public function getColoredString($string, $background_color = null,
        $foreground_color = null
    ) {
        $colored_string = "";

        // Check if given background color found
        if (isset($this->_background_colors[$background_color])) {
            $colored_string .= "\033[" .
                $this->_background_colors[$background_color] . "m";
        }

        // Check if given foreground color found
        if (isset($this->_foreground_colors[$foreground_color])) {
            $colored_string .= "\033[" .
                $this->_foreground_colors[$foreground_color] . "m";
        }

        // Add string and end coloring
        $colored_string .= $string . "\033[0m";

        return $colored_string;
    }
}