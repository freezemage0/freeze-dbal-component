<?php

declare(strict_types=1);

namespace Freeze\Component\DBAL\Sqlite;

use Freeze\Component\DBAL\Contract\IdentityGeneratorInterface;
use SQLite3;

final class IdentityGenerator implements IdentityGeneratorInterface
{
    public function __construct(
        private readonly SQLite3 $driver
    ) {
    }

    public function createIdentity(): int|string
    {
        return $this->driver->lastInsertRowID();
    }
}
