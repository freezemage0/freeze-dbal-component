<?php

declare(strict_types=1);

namespace Freeze\Component\DBAL\Expression;

use ArrayIterator;
use Freeze\Component\DBAL\Contract\Expression\BindableExpressionInterface;
use Freeze\Component\DBAL\Contract\Expression\ExpressionInterface;
use Freeze\Component\DBAL\Contract\Expression\QuoteStrategyInterface;
use Freeze\Component\DBAL\Contract\ExpressionBuilderInterface;
use IteratorAggregate;
use Traversable;

/**
 * @template-implements IteratorAggregate<int, ExpressionInterface>
 */
final class Criteria implements IteratorAggregate
{
    /** @var array<array-key, ExpressionInterface> */
    private array $criteria = [];
    private ?ExpressionInterface $previousCriterion = null;

    public function addCriterion(BindableExpressionInterface $criterion): Criteria
    {
        if ($this->previousCriterion instanceof BindableExpressionInterface) {
            $this->addLogicalExpression(LogicalExpression::and());
        }

        $this->criteria[] = $this->previousCriterion = $criterion;
        return $this;
    }

    public function addLogicalExpression(LogicalExpression $logicalExpression): Criteria
    {
        if ($this->previousCriterion instanceof LogicalExpression) {
            \array_pop($this->criteria);
        }
        $this->criteria[] = $this->previousCriterion = $logicalExpression;

        return $this;
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->criteria);
    }

    public function build(ExpressionBuilderInterface $expressionBuilder): string
    {
        $result = [];
        foreach ($this->criteria as $expression) {
            $result[] = $expression->build($expressionBuilder);
        }

        return \implode(' ', $result);
    }
}
