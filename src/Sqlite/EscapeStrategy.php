<?php

declare(strict_types=1);

namespace Freeze\Component\DBAL\Sqlite;

use Freeze\Component\DBAL\Contract\Expression\EscapeStrategyInterface;
use SQLite3;

final class EscapeStrategy implements EscapeStrategyInterface
{
    public function quote(string $identifier): string
    {
        $parts = \explode('.', $identifier);
        $parts = \array_map(static fn (string $part): string => '"' . \trim($identifier, '"') . '"', $parts);

        return \implode('.', $parts);
    }

    public function escape(float|bool|int|string $value): string
    {
        return SQLite3::escapeString($value);
    }
}
