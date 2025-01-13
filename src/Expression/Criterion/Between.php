<?php

declare(strict_types=1);

namespace Freeze\Component\DBAL\Expression\Criterion;

use Freeze\Component\DBAL\Contract\Expression\BindableExpressionInterface;
use Freeze\Component\DBAL\Contract\Expression\QuoteStrategyInterface;
use Freeze\Component\DBAL\Contract\StatementInterface;

final class Between implements BindableExpressionInterface
{
    public function __construct(
        public readonly string $column,
        public readonly mixed $lowestBoundary,
        public readonly mixed $highestBoundary
    )
    {
    }

    public function bind(StatementInterface $statement): void
    {
        $statement->bind($this->getLowestBoundaryBinding(), $this->lowestBoundary);
        $statement->bind($this->getHighestBoundaryBinding(), $this->highestBoundary);
    }

    public function build(QuoteStrategyInterface $quoteStrategy): string
    {
        return "{$quoteStrategy->quote($this->column)} BETWEEN {$this->getLowestBoundaryBinding()} AND {$this->getHighestBoundaryBinding()}";
    }

    private function getLowestBoundaryBinding(): string
    {
        return ":{$this->column}_lowest";
    }

    private function getHighestBoundaryBinding(): string
    {
        return ":{$this->column}_highest";
    }
}
