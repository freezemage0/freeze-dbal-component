<?php

declare(strict_types=1);

namespace Freeze\Component\DBAL\Schema\Definition;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class Name
{
    public function __construct(
        public readonly string $value
    ) {
    }
}
