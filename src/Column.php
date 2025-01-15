<?php

declare(strict_types=1);

namespace Freeze\Component\DBAL;

use Freeze\Component\DBAL\Contract\ColumnTypeInterface;

final class Column
{
    public function __construct(
        public readonly string $name,
        public readonly ColumnTypeInterface $type,
        public readonly bool $primary = false,
        public readonly bool $nullable = false
    ) {
    }
}
