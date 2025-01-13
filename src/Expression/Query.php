<?php

declare(strict_types=1);

namespace Freeze\Component\DBAL\Expression;

use Freeze\Component\DBAL\Contract\Expression\BindableExpressionInterface;
use Freeze\Component\DBAL\Expression\Order\Rule;

final class Query
{
    private Criteria $criteria;
    /** @var array<Rule> */
    private array $rules = [];
    private ?Navigation $navigation = null;

    public function __construct()
    {
        $this->criteria = new Criteria();
    }

    public function where(BindableExpressionInterface $criterion): Query
    {
        $this->criteria->addCriterion($criterion);
        return $this;
    }

    public function logic(LogicalExpression $logic): Query
    {
        $this->criteria->addLogicalExpression($logic);
        return $this;
    }

    public function getCriteria(): Criteria
    {
        return $this->criteria;
    }

    public function orderBy(Rule ...$rules): Query
    {
        $this->rules = \array_merge($this->rules, $rules);
        return $this;
    }

    public function getOrderRules(): array
    {
        return $this->rules;
    }

    public function navigation(Navigation $navigation): Query
    {
        $this->navigation = $navigation;
        return $this;
    }

    public function getNavigation(): ?Navigation
    {
        return $this->navigation;
    }
}
