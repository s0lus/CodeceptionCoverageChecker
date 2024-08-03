<?php

namespace CoverageChecker;

use PHPUnit\TextUI\Output\Printer;

class Error
{
    protected const array COLORS = [
        'red' => "\x1b[37;41m",
        'reset' => "\x1b[0m",
    ];

    public static bool $noColors = false;

    private Printer $printer;

    public function __construct(Printer $printer)
    {
        $this->printer = $printer;
    }

    public function write(string $type, string $limit, string $linePercentage): void
    {
        $title = ' ERROR: ' . ucfirst($type) . ' coverage lower than threshold ';
        $title = $this->formatLine(self::COLORS['red'], strlen($title), $title);
        $lines = [
            '  ' . 'Threshold: ' . $limit,
            '  ' . 'Coverage: ' . $linePercentage,
        ];
        $this->output($this->formatMessage($title, $lines, self::COLORS['reset']));
    }

    private function output(string $message): void
    {
        $this->printer->print($message . PHP_EOL);
    }

    private function formatMessage(string $title, array $lines, string $color): string
    {
        $lineLength = strlen($title . PHP_EOL . PHP_EOL);
        for ($i = 0; $i < count($lines); $i++) {
            $lineLength = $lineLength < strlen($lines[$i]) ? strlen($lines[$i]) : $lineLength;
            $padding = $lineLength - strlen($lines[$i]);
            $padding = $i === count($lines) - 1 ? --$padding : $padding;
            $lines[$i] = $this->formatLine($color, $padding, $lines[$i]);
        }
        return $title . PHP_EOL . implode(PHP_EOL, $lines) . PHP_EOL;
    }

    private function formatLine(string $color, int $padding, string $string): string
    {
        if (self::$noColors) {
            $color = '';
        } elseif (strpos($color, "\x1b[") !== 0) {
            $color = isset(self::COLORS[$color]) ? self::COLORS[$color] : '';
        }

        $reset = $color ? self::COLORS['reset'] : '';
        return $color . str_pad($string, $padding) . $reset;
    }
}
