<?php

declare(strict_types=1);

namespace Freeze\Component\DBAL\Schema\Column;

use Attribute;
use DateTimeImmutable;
use DateTimeInterface;
use Freeze\Component\DBAL\Contract\ColumnTypeInterface;
use Freeze\Component\DBAL\Exception\InvalidArgumentValueException;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class DateType implements ColumnTypeInterface
{
    private const DATE_FORMAT = 'Y-m-d';

    public function getExpression(): string
    {
        return 'DATE';
    }

    public function internalize(mixed $value): DateTimeInterface
    {
        return DateTimeImmutable::createFromFormat(DateType::DATE_FORMAT, $value);
    }

    /**
     * @throws InvalidArgumentValueException
     */
    public function externalize(mixed $value): string
    {
        if (!($value instanceof DateTimeInterface)) {
            throw new InvalidArgumentValueException('Date value MUST be an instance of DateTimeInterface');
        }

        return $value->format(DateType::DATE_FORMAT);
    }
}
