<?php

declare(strict_types=1);

namespace Freeze\Component\DBAL\Expression;

use Freeze\Component\DBAL\Contract\Expression\ExpressionInterface;
use Freeze\Component\DBAL\Contract\ExpressionBuilderInterface;

final class LogicalExpression implements ExpressionInterface
{
    private const LOGIC_AND = 'AND';
    private const LOGIC_OR = 'OR';

    /** @var array<value-of<self>, self> */
    private static array $cache = [];

    public static function and(): LogicalExpression
    {
        return self::$cache[self::LOGIC_AND] ??= new self(self::LOGIC_AND);
    }

    public static function or(): LogicalExpression
    {
        return self::$cache[self::LOGIC_OR] ??= new self(self::LOGIC_OR);
    }

    private function __construct(
        public readonly string $value
    ) {
    }

    public function build(ExpressionBuilderInterface $expressionBuilder): string
    {
        return $expressionBuilder->buildLogical($this);
    }
}
