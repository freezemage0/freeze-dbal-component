<?php

declare(strict_types=1);

namespace Freeze\Component\DBAL\Mysql;

use Freeze\Component\DBAL\Column;
use Freeze\Component\DBAL\Contract\Expression\QuoteStrategyInterface;
use Freeze\Component\DBAL\Contract\ExpressionBuilderInterface;
use Freeze\Component\DBAL\Contract\QueryBuilderInterface;
use Freeze\Component\DBAL\Expression\Criteria;
use Freeze\Component\DBAL\Expression\Query;
use Freeze\Component\DBAL\Expression\ValueMap;
use Freeze\Component\DBAL\Schema;
use RuntimeException;

final class QueryBuilder implements QueryBuilderInterface
{
    public function __construct(
        private readonly Schema $schema,
        private readonly ExpressionBuilderInterface $expressionBuilder,
        private readonly QuoteStrategyInterface $quoteStrategy
    ) {
    }

    public function buildSelect(Query $query): string
    {
        $conditions = $query->getCriteria()->build($this->expressionBuilder);

        $rules = [];
        foreach ($query->getOrderRules() as $rule) {
            $rules[] = "{$this->quoteStrategy->quote($rule->column)} {$rule->direction->value}";
        }

        $sql = [
            'SELECT' => \implode(
                ', ',
                \array_map(fn(Column $c): string => $this->quoteStrategy->quote($c->name), $this->schema->columns)
            ),
            'FROM' => $this->quoteStrategy->quote($this->schema->name),
            'WHERE' => !empty($conditions) ? $conditions : null,
            'ORDER BY' => !empty($rules) ? \implode(', ', $rules) : null
        ];

        $navigation = $query->getNavigation();
        if ($navigation !== null) {
            $sql['LIMIT'] = $navigation->limit;
            $sql['OFFSET'] = $navigation->offset;
        }

        $result = [];
        foreach ($sql as $operation => $value) {
            if ($value === null) {
                continue;
            }

            $result[] = "{$operation} {$value}";
        }

        return \implode(' ', $result);
    }

    public function buildInsert(array $values): string
    {
    }

    public function buildUpdate(Criteria $criteria, ValueMap $map): string
    {
        $assignments = [];
        foreach ($map as $column => $value) {
            $assignments[] = "{$this->quoteStrategy->quote($column)} = ?";
        }

        $assignments = \implode(', ', $assignments);

        return "UPDATE {$this->quoteStrategy->quote($this->schema->name)} SET {$assignments} WHERE {$criteria->build($this->expressionBuilder)}";
    }

    public function buildDelete(Criteria $criteria): string
    {
        return "DELETE FROM {$this->quoteStrategy->quote($this->schema->name)} WHERE {$criteria->build($this->expressionBuilder)}";
    }

    public function buildTruncate(): string
    {
        return "TRUNCATE TABLE {$this->quoteStrategy->quote($this->schema->name)}";
    }
}
