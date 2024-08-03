<?php

namespace CoverageChecker;

use SebastianBergmann\CodeCoverage\Node\Directory;

class ClassChecker extends Checker
{
    public function calculateCoveragePercentage(Directory $report): float
    {
        return $this->calculatePercentage(
            $report->numberOfTestedClasses(),
            $report->numberOfClasses()
        );
    }

    protected function getType(): string
    {
        return 'class';
    }
}
