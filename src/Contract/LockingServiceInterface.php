<?php

declare(strict_types=1);

namespace Freeze\Component\DBAL\Contract;

interface LockingServiceInterface
{
    public function acquire(string $name, int $timeout = 0): bool;

    public function release(string $name): bool;
}
