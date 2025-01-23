<?php

declare(strict_types=1);

namespace Freeze\Component\DBAL\Common;

use Freeze\Component\DBAL\Contract\TransactionServiceInterface;

final class NullTransactionService implements TransactionServiceInterface
{
    public function start(): void
    {
        // Explicit noop
    }

    public function commit(): void
    {
        // Explicit noop
    }

    public function rollback(): void
    {
        // Explicit noop
    }
}
