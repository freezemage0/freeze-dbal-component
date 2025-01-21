<?php

declare(strict_types=1);

namespace Freeze\Component\DBAL\Schema\Definition;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
final class SchemaDefinition
{
    public function __construct(
        public readonly string $tableName
    ) {
    }
}
