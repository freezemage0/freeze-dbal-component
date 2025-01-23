<?php

declare(strict_types=1);

namespace Freeze\Component\DBAL\Common;

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
        return \sprintf(
            '%s %s %s',
            $this->escapeStrategy->quote($comparison->column),
            $comparison->operator,
            $this->escapeStrategy->escape($comparison->value)
        );
    }

    public function buildBetween(Between $between): string
    {
        return \sprintf(
            '%s BETWEEN %s AND %s',
            $this->escapeStrategy->quote($between->column),
            $this->escapeStrategy->escape($between->lowestBoundary),
            $this->escapeStrategy->escape($between->highestBoundary)
        );
    }

    public function buildAssignment(Assignment $assignment): string
    {
        return \sprintf(
            "%s = %s;",
            $this->escapeStrategy->quote($assignment->column),
            $this->escapeStrategy->escape($assignment->value)
        );
    }

    public function buildRange(Range $range): string
    {
        return \sprintf(
            '%s IN (%s)',
            $this->escapeStrategy->quote($range->column),
            \implode(', ', \array_map(
                $this->escapeStrategy->escape(...),
                $range->values
            ))
        );
    }

    public function buildLogical(LogicalExpression $logicalExpression): string
    {
        return $logicalExpression->value;
    }
}
