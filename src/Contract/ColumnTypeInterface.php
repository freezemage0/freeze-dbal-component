<?php

declare(strict_types=1);

namespace Freeze\Component\DBAL\Contract;

interface ColumnTypeInterface
{
    /**
     * Returns column name as if it would be described in database, e.g. `TINYINT`, `TEXT`, `VARCHAR(255)`.
     */
    public function getExpression(): string;

    /**
     * Processes value from database.
     */
    public function internalize(mixed $value): mixed;

    /**
     * Returns the value that is ready to be persisted in external storage.
     */
    public function externalize(mixed $value): mixed;
}
