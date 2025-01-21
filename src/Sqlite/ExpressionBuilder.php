<?php

declare(strict_types=1);

namespace Freeze\Component\DBAL\Sqlite;

use Freeze\Component\DBAL\Contract\Expression\EscapeStrategyInterface;
use Freeze\Component\DBAL\Contract\ExpressionBuilderInterface;
use Freeze\Component\DBAL\Expression\Assignment;
use Freeze\Component\DBAL\Expression\Criterion\Between;
use Freeze\Component\DBAL\Expression\Criterion\Comparison;
use Freeze\Component\DBAL\Expression\Criterion\Range;
use Freeze\Component\DBAL\Expression\LogicalExpression;

final class ExpressionBuilder implements ExpressionBuilderInterface
{
    public function __construct(
        private readonly EscapeStrategyInterface $escapeStrategy
    ) {
    }

    public function buildComparison(Comparison $comparison): string
    {
        return "{$this->escapeStrategy->quote($comparison->column)} {$comparison->operator} {$this->escapeStrategy->escape($comparison->value)};";
    }

    public function buildBetween(Between $between): string
    {
        // TODO: Implement buildBetween() method.
    }

    public function buildAssignment(Assignment $assignment): string
    {
        // TODO: Implement buildAssignment() method.
    }

    public function buildRange(Range $range): string
    {
        // TODO: Implement buildRange() method.
    }

    public function buildLogical(LogicalExpression $logicalExpression): string
    {
        // TODO: Implement buildLogical() method.
    }
}
