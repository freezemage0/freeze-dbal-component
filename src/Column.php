<?php

declare(strict_types=1);

namespace Freeze\Component\DBAL;

final class Column
{
    public function __construct(
        public readonly string $name,
        public readonly string $type,
        public readonly bool $primary = false,
        public readonly bool $nullable = false
    ) {
    }
}
