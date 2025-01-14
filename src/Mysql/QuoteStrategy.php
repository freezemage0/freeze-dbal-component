<?php

declare(strict_types=1);

namespace Freeze\Component\DBAL\Mysql;

use Freeze\Component\DBAL\Contract\Expression\QuoteStrategyInterface;

final class QuoteStrategy implements QuoteStrategyInterface
{
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
}
