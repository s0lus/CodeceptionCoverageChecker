<?php

namespace CoverageChecker;

use SebastianBergmann\CodeCoverage\Node\Directory;

class MethodChecker extends Checker
{
    public function calculateCoveragePercentage(Directory $report): float
    {
        return $this->calculatePercentage(
            $report->numberOfTestedMethods(),
            $report->numberOfMethods()
        );
    }

    protected function getType(): string
    {
        return 'method';
    }
}
