<?php

declare(strict_types=1);

namespace Freeze\Component\DBAL\Driver\Mysql;

use Freeze\Component\DBAL\Column;
use Freeze\Component\DBAL\Contract\Expression\QuoteStrategyInterface;
use Freeze\Component\DBAL\Contract\QueryBuilderInterface;
use Freeze\Component\DBAL\Expression\Assignment;
use Freeze\Component\DBAL\Expression\Query;
use Freeze\Component\DBAL\Schema;

final class QueryBuilder implements QueryBuilderInterface, QuoteStrategyInterface
{
    public function buildSelect(Schema $schema, Query $query): string
    {
        $conditions = [];
        foreach ($query->getCriteria() as $criterion) {
            $conditions[] = $criterion->build($this);
        }

        $rules = [];
        foreach ($query->getOrderRules() as $rule) {
            $rules[] = "{$rule->column} {$rule->direction->value}";
        }

        $sql = [
            'SELECT' => \array_map(fn(Column $c): string => $this->quote($c->name), $schema->columns),
            'FROM' => $this->quote($schema->name),
            'WHERE' => !empty($conditions) ? \implode(', ', $conditions) : null,
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

    public function buildInsert(Schema $schema): string
    {
    }

    public function buildUpdate(Schema $schema): string
    {
    }

    public function buildDelete(Schema $schema, Assignment ...$assignments): string
    {
        $filter = \implode(' AND ', \array_map(static fn(Assignment $a): string => $a->build($this), $assignments));

        return "DELETE FROM {$this->quote($schema->name)} WHERE {$filter}";
    }

    public function buildTruncate(Schema $schema): string
    {
        return "TRUNCATE TABLE {$this->quote($schema->name)}";
    }

    public function quote(string $identifier): string
    {
        return '`' . \trim($identifier, '`') . '`';
    }
}
