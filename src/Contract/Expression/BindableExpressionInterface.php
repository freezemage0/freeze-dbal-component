<?php

declare(strict_types=1);

namespace Freeze\Component\DBAL\Contract\Expression;

use Freeze\Component\DBAL\Contract\StatementInterface;

interface BindableExpressionInterface extends ExpressionInterface
{
    public function bind(StatementInterface $statement): void;
}
