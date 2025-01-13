<?php

declare(strict_types=1);

namespace Freeze\Component\DBAL\Expression\Order;

final class Rule
{
    public function __construct(
        public readonly string $column,
        public readonly Direction $direction = Direction::Ascending
    ) {
    }
}
