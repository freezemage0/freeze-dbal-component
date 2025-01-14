<?php

declare(strict_types=1);

namespace Freeze\Component\DBAL\Mysql;

use Freeze\Component\DBAL\Contract\TransactionServiceInterface;

final class TransactionService implements TransactionServiceInterface
{
    public function __construct(
        private readonly Driver $driver
    ) {
    }

    public function start(): void
    {
        $this->driver->query('START TRANSACTION');
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
