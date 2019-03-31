<?php

namespace Cherry\Console\Output;

class Output
{
    private $_CLIColor;

    public function __construct()
    {
        $this->_CLIColor = new CLIColor();
    }

    public function info($text)
    {
        return $this->_colorizeString("[INFO] {$text}", 'blue', 'white');
    }

    public function warning($text)
    {
        return $this->_colorizeString("[WARNING] {$text}", 'yellow', 'white');
    }

    public function danger($text)
    {
        return $this->_colorizeString("[ERROR] {$text}", 'red', 'white');
    }

    public function success($text)
    {
        return $this->_colorizeString("[OK] {$text}", 'green', 'white');
    }

    public function text($text)
    {
        return $this->_colorizeString($text);
    }

    private function _colorizeString($text, $background_color = null, $foreground_color = null)
    {
        return $this->_CLIColor
                ->getColoredString($text, $background_color, $foreground_color) . "\n";
    }
}