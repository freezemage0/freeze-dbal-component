<?php

declare(strict_types=1);

namespace Freeze\Component\DBAL\Expression\Criterion;

use Freeze\Component\DBAL\Contract\Expression\BindableExpressionInterface;
use Freeze\Component\DBAL\Contract\Expression\EscapeStrategyInterface;
use Freeze\Component\DBAL\Contract\ExpressionBuilderInterface;
use Freeze\Component\DBAL\Contract\StatementInterface;

final class Range implements BindableExpressionInterface
{
    public readonly array $values;

    public function __construct(
        public readonly string $column,
        mixed ...$values
    )
    {
        $this->values = $values;
    }

    public function bind(StatementInterface $statement): void
    {
        foreach ($this->values as $index => $value) {
            $statement->bind($this->getIndexedBinding($index), $value);
        }
    }

    private function getIndexedBinding(int $index): string
    {
        return ":{$this->column}_{$index}";
    }

    public function build(ExpressionBuilderInterface $expressionBuilder): string
    {
        return $expressionBuilder->buildRange($this);
    }
}
