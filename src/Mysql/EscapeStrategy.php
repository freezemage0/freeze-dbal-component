<?php

declare(strict_types=1);

namespace Freeze\Component\DBAL\Mysql;

use Freeze\Component\DBAL\Contract\Expression\EscapeStrategyInterface;
use mysqli;

final class EscapeStrategy implements EscapeStrategyInterface
{
    public function __construct(
        private readonly mysqli $driver
    ) {
    }

    /**
     * Transforms identifier in form of "database.table" into "`database`.`table`".
     *
     * @param string $identifier
     * @return string
     */
    public function quote(string $identifier): string
    {
        $parts = \explode('.', $identifier);

        foreach ($parts as &$part) {
            $part = $this->quotePart($part);
        }
        unset($part);

        return \implode('.', $parts);
    }

    private function quotePart(string $part): string
    {
        return '`' . \trim($part, '`') . '`';
    }

    public function escape(float|bool|int|string $value): string
    {
        return $this->driver->real_escape_string($value);
    }
}
