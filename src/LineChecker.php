<?php

namespace CoverageChecker;

use SebastianBergmann\CodeCoverage\Node\Directory;

class LineChecker extends Checker
{
    public function calculateCoveragePercentage(Directory $report): float
    {
        return $this->calculatePercentage(
            $report->numberOfExecutedLines(),
            $report->numberOfExecutableLines()
        );
    }

    protected function getType(): string
    {
        return 'line';
    }
}
