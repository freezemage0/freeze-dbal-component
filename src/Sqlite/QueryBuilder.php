<?php

declare(strict_types=1);

namespace Freeze\Component\DBAL\Sqlite;

use Freeze\Component\DBAL\Contract\Expression\EscapeStrategyInterface;
use Freeze\Component\DBAL\Contract\QueryBuilderInterface;
use Freeze\Component\DBAL\Expression\Criteria;
use Freeze\Component\DBAL\Expression\Query;
use Freeze\Component\DBAL\Expression\ValueMap;
use Freeze\Component\DBAL\Schema;

final class QueryBuilder implements QueryBuilderInterface
{
    public function __construct(
        private readonly Schema $schema,
        private readonly EscapeStrategyInterface $escapeStrategy
    ) {
    }

    public function buildSelect(Query $query): string
    {
        // TODO: Implement buildSelect() method.
    }

    public function buildInsert(ValueMap $values): string
    {
        // TODO: Implement buildInsert() method.
    }

    public function buildUpdate(ValueMap $map, Criteria $criteria): string
    {
        // TODO: Implement buildUpdate() method.
    }

    public function buildDelete(Criteria $criteria): string
    {

    }

    public function buildTruncate(): string
    {
        /** @noinspection SqlWithoutWhere SQLite3 DELETE FROM without criteria == TRUNCATE TABLE. */
        return "DELETE FROM {$this->escapeStrategy->quote($this->schema->name)}";
    }
}
