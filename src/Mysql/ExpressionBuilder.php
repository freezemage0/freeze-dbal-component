<?php

declare(strict_types=1);

namespace Freeze\Component\DBAL\Mysql;

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
        $parts = [
            $this->escapeStrategy->quote($comparison->column),
            $comparison->operator,
            $this->escape($comparison->value)
        ];
        return \implode(' ', $parts);
    }

    public function buildBetween(Between $between): string
    {
        $column = $this->escapeStrategy->quote($between->column);
        $min = $this->escape($between->lowestBoundary);
        $max = $this->escape($between->highestBoundary);

        return "{$column} BETWEEN {$min} AND {$max}";
    }

    public function buildAssignment(Assignment $assignment): string
    {
        return "{$this->escapeStrategy->quote($assignment->column)} = {$this->escape($assignment->value)}";
    }

    public function buildRange(Range $range): string
    {
        $values = \implode(', ', \array_map($this->escape(...), $range->values));
        return "{$this->escapeStrategy->quote($range->column)} IN ({$values})";
    }

    public function buildLogical(LogicalExpression $logicalExpression): string
    {
        return $logicalExpression->value;
    }

    private function escape(string|int|float|bool $value): string
    {
        if (!\is_int($value) && !\is_float($value)) {
            $value = "'{$value}'";
        }

        return $this->escapeStrategy->escape($value);
    }
}
