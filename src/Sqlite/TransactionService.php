<?php

declare(strict_types=1);

namespace Freeze\Component\DBAL\Sqlite;

use Freeze\Component\DBAL\Contract\TransactionServiceInterface;

final class TransactionService implements TransactionServiceInterface
{
    public function __construct(
        private readonly Driver $driver
    ) {
    }

    public function start(): void
    {
        $this->driver->query('BEGIN TRANSACTION');
    }

    public function commit(): void
    {
        $this->driver->query('COMMIT TRANSACTION');
    }

    public function rollback(): void
    {
        $this->driver->query('ROLLBACK TRANSACTION');
    }
}
