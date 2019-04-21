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
    // Define foreground color constants
    const F_BLACK        = '0;30';
    const F_WHITE        = '1;37';
    const F_DARK_GRAY    = '1;30';
    const F_LIGHT_GRAY   = '0;37';
    const F_BLUE         = '0;34';
    const F_LIGHT_BLUE   = '1;34';
    const F_GREEN        = '0;32';
    const F_LIGHT_GREEN  = '1;32';
    const F_CYAN         = '0;36';
    const F_LIGHT_CYAN   = '1;36';
    const F_RED          = '0;31';
    const f_LIGHT_RED    = '1;31';
    const F_PURPLE       = '0;35';
    const F_LIGHT_PURPLE = '1;35';
    const F_BROWN        = '0;33';
    const F_YELLOW       = '1;33';

    // Define background color constants
    const B_BLACK        = '40';
    const B_RED          = '41';
    const B_GREEN        = '42';
    const B_YELLOW       = '43';
    const B_BLUE         = '44';
    const B_MAGENTA      = '45';
    const B_CYAN         = '46';
    const B_LIGHT_GRAY   = '47';

    /**
     * Colorize string.
     *
     * @param string $string           Text for colorizing.
     * @param string $background_color Background color for string.
     * @param string $foreground_color Foreground color for string.
     *
     * @return string Colorized text.
     */
    public function getColoredString($string, $background_color = '',
        $foreground_color = ''
    ) {
        $colored_string = "";

        // Add background color
        $colored_string .= "\033[" . $background_color . "m";

        // Add foreground color
        $colored_string .= "\033[" . $foreground_color . "m";

        // Add string and end coloring
        $colored_string .= $string . "\033[0m";

        return $colored_string;
    }
}
