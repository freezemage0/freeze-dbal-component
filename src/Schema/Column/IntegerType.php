<?php

declare(strict_types=1);

namespace Freeze\Component\DBAL\Schema\Column;

use Attribute;
use Freeze\Component\DBAL\Contract\ColumnTypeInterface;
use Freeze\Component\DBAL\Exception\InvalidArgumentValueException;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class IntegerType implements ColumnTypeInterface
{
    /**
     * @throws InvalidArgumentValueException
     */
    public function __construct(
        private readonly int $length = 11
    ) {
        if ($this->length <= 0) {
            throw new InvalidArgumentValueException('Length MUST be a positive integer');
        }
    }

    public function getExpression(): string
    {
        return "INT($this->length)";
    }

    public function internalize(mixed $value): int
    {
        return (int) $value;
    }

    public function externalize(mixed $value): int
    {
        return (int) $value;
    }
}
