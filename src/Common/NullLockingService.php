<?php

declare(strict_types=1);

namespace Freeze\Component\DBAL\Common;

use Freeze\Component\DBAL\Contract\LockingServiceInterface;

final class NullLockingService implements LockingServiceInterface
{
    public function acquire(string $name, int $timeout = 0): bool
    {
        return true;
    }

    public function release(string $name): bool
    {
        return true;
    }
}
