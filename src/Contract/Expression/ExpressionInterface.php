<?php

declare(strict_types=1);

namespace Freeze\Component\DBAL\Contract\Expression;

interface ExpressionInterface
{
    public function build(QuoteStrategyInterface $quoteStrategy): string;
}
