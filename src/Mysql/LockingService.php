<?php

declare(strict_types=1);

namespace Freeze\Component\DBAL\Mysql;

use Freeze\Component\DBAL\Contract\LockingServiceInterface;
use Freeze\Component\DBAL\Exception\QueryException;

final class LockingService implements LockingServiceInterface
{
    public function __construct(
        private readonly Driver $driver
    ) {
    }

    public function acquire(string $name, int $timeout = 0): bool
    {
        $result = $this->driver->query("SELECT GET_LOCK('{$name}', {$timeout}) as L")->fetch();

        if ($result['L'] === null) {
            throw new QueryException("Unable to acquire lock {$name}");
        }

        return $result['L'] === '1';
    }

    public function release(string $name): bool
    {
        $result = $this->driver->query("SELECT RELEASE_LOCK('{$name}') AS RL")->fetch();

        return $result['RL'] === '1';
    }
}
