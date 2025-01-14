<?php

declare(strict_types=1);

namespace Freeze\Component\DBAL\Contract;

use Freeze\Component\DBAL\Expression\Assignment;
use Freeze\Component\DBAL\Expression\Criterion\Between;
use Freeze\Component\DBAL\Expression\Criterion\Comparison;
use Freeze\Component\DBAL\Expression\Criterion\Range;
use Freeze\Component\DBAL\Expression\LogicalExpression;

interface ExpressionBuilderInterface
{
    public function buildComparison(Comparison $comparison): string;

    public function buildBetween(Between $between): string;

    public function buildAssignment(Assignment $assignment): string;

    public function buildRange(Range $range): string;

    public function buildLogical(LogicalExpression $logicalExpression): string;
}
