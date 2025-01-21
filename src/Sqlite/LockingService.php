<?php

declare(strict_types=1);

namespace Freeze\Component\DBAL\Sqlite;

use Freeze\Component\DBAL\Contract\LockingServiceInterface;

final class LockingService implements LockingServiceInterface
{
    public function acquire(string $name, int $timeout = 0): bool
    {
        // TODO: Implement acquire() method.
    }

    public function release(string $name): bool
    {
        // TODO: Implement release() method.
    }
}
