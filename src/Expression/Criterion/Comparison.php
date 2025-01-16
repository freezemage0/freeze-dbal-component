<?php

declare(strict_types=1);

namespace Freeze\Component\DBAL\Expression\Criterion;

use Freeze\Component\DBAL\Contract\Expression\BindableExpressionInterface;
use Freeze\Component\DBAL\Contract\Expression\EscapeStrategyInterface;
use Freeze\Component\DBAL\Contract\ExpressionBuilderInterface;
use Freeze\Component\DBAL\Contract\StatementInterface;

final class Comparison implements BindableExpressionInterface
{
    public const EQUALS = '=';

    public static function equals(string $column, mixed $value): Comparison
    {
        return new self($column, self::EQUALS, $value);
    }

    public function __construct(
        public readonly string $column,
        public readonly string $operator,
        public readonly mixed $value,
    ) {
    }

    public function build(ExpressionBuilderInterface $expressionBuilder): string
    {
        return $expressionBuilder->buildComparison($this);
    }

    public function bind(StatementInterface $statement): void
    {
        $statement->bind($this->getBinding(), $this->value);
    }

    private function getBinding(): string
    {
        return ":{$this->column}";
    }
}
