<?php

declare(strict_types=1);

namespace Freeze\Component\DBAL\Contract;

use Freeze\Component\DBAL\Expression\Assignment;
use Freeze\Component\DBAL\Expression\Criteria;
use Freeze\Component\DBAL\Expression\Query;
use Freeze\Component\DBAL\Schema;

interface QueryBuilderInterface
{
    public function buildSelect(Query $query): string;

    public function buildInsert(array $values): string;

    public function buildUpdate(Criteria $criteria, array $values): string;

    public function buildDelete(Criteria $criteria): string;

    public function buildTruncate(): string;
}
