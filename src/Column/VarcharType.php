<?php

declare(strict_types=1);

namespace Freeze\Component\DBAL\Column;

use Freeze\Component\DBAL\Contract\ColumnTypeInterface;
use Freeze\Component\DBAL\Exception\InvalidArgumentValueException;

final class VarcharType implements ColumnTypeInterface
{
    /**
     * @throws InvalidArgumentValueException
     */
    public function __construct(
        private readonly int $length
    ) {
        if ($this->length <= 0) {
            throw new InvalidArgumentValueException('Varchar length MUST be a positive integer');
        }
    }

    public function getExpression(): string
    {
        return "VARCHAR({$this->length})";
    }

    public function internalize(mixed $value): string
    {
        return (string)$value;
    }

    public function externalize(mixed $value): string
    {
        return (string)$value;
    }
}
