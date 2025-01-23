<?php

declare(strict_types=1);

namespace Freeze\Component\DBAL\Sqlite;

use Freeze\Component\DBAL\Contract\Expression\EscapeStrategyInterface;
use Freeze\Component\DBAL\Contract\ExpressionBuilderInterface;
use Freeze\Component\DBAL\Contract\QueryBuilderInterface;
use Freeze\Component\DBAL\Expression\Assignment;
use Freeze\Component\DBAL\Expression\Criteria;
use Freeze\Component\DBAL\Expression\Query;
use Freeze\Component\DBAL\Expression\ValueMap;
use Freeze\Component\DBAL\Schema;

final class QueryBuilder implements QueryBuilderInterface
{
    public function __construct(
        private readonly Schema $schema,
        private readonly EscapeStrategyInterface $escapeStrategy,
        private readonly ExpressionBuilderInterface $expressionBuilder
    ) {
    }

    public function buildSelect(Query $query): string
    {
        // TODO: Implement buildSelect() method.
    }

    public function buildInsert(ValueMap $values): string
    {

    }

    public function buildUpdate(ValueMap $map, Criteria $criteria): string
    {
        $assignments = [];
        foreach ($map as $column => $value) {
            $assignments[] = $this->expressionBuilder->buildAssignment(new Assignment($column, $value));
        }

        $template = 'UPDATE %s SET %s';

        return \sprintf(
            $template,
            $this->escapeStrategy->quote($this->schema->name),
            \implode(', ', $assignments),
            $criteria->build($this->expressionBuilder)
        );
    }

    public function buildDelete(Criteria $criteria): string
    {
        return \sprintf(
            'DELETE FROM %s WHERE %s',
            $this->escapeStrategy->quote($this->schema->name),
            $criteria->build($this->expressionBuilder)
        );
    }

    public function buildTruncate(): string
    {
        /** @noinspection SqlWithoutWhere SQLite3 DELETE FROM without criteria == TRUNCATE TABLE. */
        return "DELETE FROM {$this->escapeStrategy->quote($this->schema->name)}";
    }
}
