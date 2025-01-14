<?php

declare(strict_types=1);

namespace Freeze\Component\DBAL\Mysql;

use Freeze\Component\DBAL\Contract\IdentityGeneratorInterface;

final class IdentityGenerator implements IdentityGeneratorInterface
{
    public function __construct(
        private readonly \mysqli $driver
    ) {
    }

    public function createIdentity(): int|string
    {
        return $this->driver->insert_id;
    }
}
