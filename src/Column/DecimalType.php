<?php

declare(strict_types=1);

namespace Freeze\Component\DBAL\Column;

use Freeze\Component\DBAL\Contract\ColumnTypeInterface;

final class DecimalType implements ColumnTypeInterface
{
    public function __construct(
        private readonly int $precision = 10,
        private readonly int $scale = 0
    ) {
    }

    public function getExpression(): string
    {
        return "DECIMAL({$this->precision}, {$this->scale})";
    }

    public function internalize(mixed $value): float
    {
        return (float) $value;
    }

    public function externalize(mixed $value): float
    {
        return (float) $value;
    }
}
