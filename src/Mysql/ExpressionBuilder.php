<?php

declare(strict_types=1);

namespace Freeze\Component\DBAL\Mysql;

use Freeze\Component\DBAL\Contract\Expression\QuoteStrategyInterface;
use Freeze\Component\DBAL\Contract\ExpressionBuilderInterface;
use Freeze\Component\DBAL\Expression\Assignment;
use Freeze\Component\DBAL\Expression\Criterion\Between;
use Freeze\Component\DBAL\Expression\Criterion\Comparison;
use Freeze\Component\DBAL\Expression\Criterion\Range;
use Freeze\Component\DBAL\Expression\LogicalExpression;

final class ExpressionBuilder implements ExpressionBuilderInterface
{
    public function __construct(
        private readonly QuoteStrategyInterface $quoteStrategy
    ) {
    }

    public function buildComparison(Comparison $comparison): string
    {
        return "{$this->quoteStrategy->quote($comparison->column)} {$comparison->operator} ?";
    }

    public function buildBetween(Between $between): string
    {
        return "{$this->quoteStrategy->quote($between->column)} BETWEEN ? AND ?";
    }

    public function buildAssignment(Assignment $assignment): string
    {
        return "{$this->quoteStrategy->quote($assignment->column)} = ?";
    }

    public function buildRange(Range $range): string
    {
        $items = \implode(', ', \array_fill(0, \count($range->values), '?'));
        return "{$this->quoteStrategy->quote($range->column)} IN ({$items})";
    }

    public function buildLogical(LogicalExpression $logicalExpression): string
    {
        return $logicalExpression->value;
    }
}
