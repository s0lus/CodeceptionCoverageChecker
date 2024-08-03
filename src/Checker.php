<?php

namespace CoverageChecker;

use PHPUnit\TextUI\Output\Printer;
use SebastianBergmann\CodeCoverage\Node\Directory;

abstract class Checker
{
    public static bool $hasError = false;
    protected float $lowLimit;

    abstract protected function calculateCoveragePercentage(Directory $report): float;

    abstract protected function getType(): string;

    public function __construct(?string $lowLimit = '60.00')
    {
        $this->lowLimit = (float) number_format($lowLimit, 2, '.', '');
    }

    public function check(Printer $printer, Directory $report): void
    {
        $percentage = $this->calculateCoveragePercentage($report);
        if ($percentage < $this->lowLimit) {
            (new Error($printer))->write(
                $this->getType(),
                sprintf('%01.2F%%', $this->lowLimit),
                sprintf('%01.2F%%', $percentage)
            );

            self::$hasError = true;
        }
    }

    protected function calculatePercentage(int $tested, int $total): float
    {
        $percentage = 100;
        if ($total > 0) {
            $percentage = ($tested / $total) * 100;
        } elseif ($total == 0) {
            return 0;
        }
        return (float) number_format($percentage, 2, '.', '');
    }
}
