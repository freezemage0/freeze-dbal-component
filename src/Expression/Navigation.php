<?php

declare(strict_types=1);

namespace Freeze\Component\DBAL\Expression;

final class Navigation
{
    public function __construct(
        public readonly ?int $limit = null,
        public readonly ?int $offset = null
    ) {
    }
}
