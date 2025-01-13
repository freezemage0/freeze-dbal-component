<?php

declare(strict_types=1);

namespace Freeze\Component\DBAL\Contract;

use Freeze\Component\DBAL\Expression\Assignment;
use Freeze\Component\DBAL\Expression\Query;
use Freeze\Component\DBAL\Schema;

interface QueryBuilderInterface
{
    public function buildSelect(Schema $schema, Query $query): string;

    public function buildInsert(Schema $schema): string;

    public function buildUpdate(Schema $schema): string;

    public function buildDelete(Schema $schema, Assignment ...$assignments): string;

    public function buildTruncate(Schema $schema): string;
}
