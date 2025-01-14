<?php

declare(strict_types=1);

namespace Freeze\Component\DBAL\Contract\Expression;

use Freeze\Component\DBAL\Contract\ExpressionBuilderInterface;

interface ExpressionInterface
{
    public function build(ExpressionBuilderInterface $expressionBuilder): string;
}
