<?php

declare(strict_types=1);

namespace Freeze\Component\DBAL\Contract\Expression;

interface QuoteStrategyInterface
{
    public function quote(string $identifier): string;
}
