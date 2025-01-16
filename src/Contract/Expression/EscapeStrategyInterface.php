<?php

declare(strict_types=1);

namespace Freeze\Component\DBAL\Contract\Expression;

interface EscapeStrategyInterface
{
    public function quote(string $identifier): string;

    public function escape(string|int|bool|float $value): string;
}
