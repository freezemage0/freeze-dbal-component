<?php

declare(strict_types=1);

namespace Freeze\Component\DBAL\Schema\Column;

use Attribute;
use Freeze\Component\DBAL\Contract\ColumnTypeInterface;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class CharType implements ColumnTypeInterface
{
    public function __construct(
        private readonly int $length
    ) {
    }

    public function getExpression(): string
    {
        return "CHAR({$this->length})";
    }

    public function internalize(mixed $value): string
    {
        return (string) $value;
    }

    public function externalize(mixed $value): string
    {
        return (string) $value;
    }
}
