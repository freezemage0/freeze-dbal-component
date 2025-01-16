<?php

declare(strict_types=1);

namespace Freeze\Component\DBAL\Expression;

use Freeze\Component\DBAL\Contract\Expression\BindableExpressionInterface;
use Freeze\Component\DBAL\Contract\Expression\EscapeStrategyInterface;
use Freeze\Component\DBAL\Contract\ExpressionBuilderInterface;
use Freeze\Component\DBAL\Contract\StatementInterface;

final class Assignment implements BindableExpressionInterface
{
    public function __construct(
        public readonly string $column,
        public readonly mixed $value
    ) {
    }

    public function bind(StatementInterface $statement): void
    {
        $statement->bind(":{$this->column}", $this->value);
    }

    public function build(ExpressionBuilderInterface $expressionBuilder): string
    {
        return $expressionBuilder->buildAssignment($this);
    }
}
