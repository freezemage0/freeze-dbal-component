<?php

declare(strict_types=1);

namespace Freeze\Component\DBAL\Schema\Definition;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::IS_REPEATABLE)]
final class Primary
{
}
