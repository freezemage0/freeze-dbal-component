<?php

declare(strict_types=1);

namespace Freeze\Component\DBAL\Schema\Column;

use Attribute;
use DateTimeImmutable;
use DateTimeInterface;
use Freeze\Component\DBAL\Contract\ColumnTypeInterface;
use Freeze\Component\DBAL\Exception\InvalidArgumentValueException;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class DateTimeType implements ColumnTypeInterface
{
    private const DATE_TIME_FORMAT = 'Y-m-d H:i:s';

    public function getExpression(): string
    {
        return 'DATETIME';
    }

    public function internalize(mixed $value): DateTimeInterface
    {
        return DateTimeImmutable::createFromFormat(DateTimeType::DATE_TIME_FORMAT, $value);
    }

    /**
     * @throws InvalidArgumentValueException
     */
    public function externalize(mixed $value): string
    {
        if (!($value instanceof DateTimeInterface)) {
            throw new InvalidArgumentValueException('Value MUST be an instance of DateTimeInterface');
        }

        return $value->format(DateTimeType::DATE_TIME_FORMAT);
    }
}
