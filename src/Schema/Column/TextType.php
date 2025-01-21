<?php

declare(strict_types=1);

namespace Freeze\Component\DBAL\Schema\Column;

use Attribute;
use Freeze\Component\DBAL\Contract\ColumnTypeInterface;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class TextType implements ColumnTypeInterface
{
    public function getExpression(): string
    {
        return 'TEXT';
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
